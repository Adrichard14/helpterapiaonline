<?php
    class Queue {
        private $ID; //Int
        private $status;
        private $authorID; 
        private $image;//Varchar
        private $subject;
        private $content; //TEXT
        private $execution_date;// Date 
        private $status_date; //Date time
        private $registry_date; // Time stamp
        public $PUBLIC_VARS = array("ID", "status", "authorID", "image", "subject", "content", "execution_date", "status_date", "registry_date");
        public static $DATABASE         = "newsletter_queue";
        public static $FOLDER           = "uploads/boletins-informativos";
        public static $SEPARATOR        = ";";
        public static $MAX_STATUS       = 4;
        public static $STATUS_DRAFT     = 0; // rascunho
        public static $STATUS_PENDENT   = 1; // em fila
        public static $STATUS_DELETED   = 2; // excluído [padrão do sistema]
        public static $STATUS_STARTED   = 3; // envio iniciado
        public static $STATUS_SENT      = 4; // 100% enviado
        public function __construct(array $data) {
            if(!empty($data))
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS))
                        $this->{$v} = $value;
        }
        public function get($var) {
            return $this->{$var};
        }
        public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1, $authorID = -1) {
            $h = $ID != -1 || $status != -1 || $authorID != -1;
            $w = $h ? " WHERE" : "";
            $a = $h ? array("") : NULL;
            $o = $orderby != NULL ? " ORDER BY ".$orderby : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $n = "";
            if($ID != -1)
                $w.=Connector::dataMinning($a, $n, $ID, "`ID`");
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            if($authorID != -1)
                $w.=Connector::dataMinning($a, $n, $authorID, "`authorID`");
            return Connector::newInstance()->query("SELECT * FROM `".self::$DATABASE."`".$w.$o.$l, $a);
        }
        public static function paginator($status = -1, $authorID = -1) {
            $h = $status != -1 || $authorID != -1;
            $w = $h ? " WHERE" : "";
            $a = $h ? array("") : NULL;
            $n = "";
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            if($authorID != -1)
                $w.=Connector::dataMinning($a, $n, $authorID, "`authorID`");
            $v = Connector::newInstance()->query("SELECT COUNT(`ID`) AS `count` FROM `".self::$DATABASE."`".$w, $a);
        }
        private static function prepare($authorID, &$image, &$subject, &$content, &$execution_date, &$status, &$emailIDs) {
            $author = $authorID > 0 ? User::load($authorID, '0,1') : array();
            if(empty($author))
                exit("Credenciais de administrador autor inválidas.");
            if(strlen(Format::toURL($subject)) < 2)
                exit("Digite um assunto mais extenso.");
            $content = Format::HTML($content);
            if(strlen(Format::toURL(strip_tags($content))) < 4)
                exit("Digite um conteúdo mais extenso.");
            $regex = "/^(\d{2})\/(\d{2})\/(\d{4})$/";
            $output = "$3-$2-$1";
            if($execution_date != "" && !preg_match($regex, $execution_date))
                exit("A data de execução deve seguir o formato 'dia/mês/ano' ou ficar em branco (para capturar a data atual).");
            $execution_date = $execution_date != "" ? preg_replace($regex, $output, $execution_date) : date("Y-m-d");
            $temp = explode(self::$SEPARATOR, $emailIDs);
            if($temp[0] == NULL)
                unset($temp[0]);
            $emailIDs = array();
            if(!empty($temp))
                foreach($temp as $tmp) if(intval($tmp) > 0) {
                    $email = Email::load($tmp, '0,1', NULL, 2.0);
                    if(empty($email)) {
                        exit("Um dos e-mails selecionados não existe no banco de dados ou foi excluído. Por favor, atualize a página ou tente identificá-lo para remover da lista e tentar novamente.");
                    } elseif($email[0]['status'] != 1) {
                        exit("O dono do e-mail '".$email[0]['value']."' desativou o recebimento de boletins. Por favor, remova-o da lista e tente novamente.");
                    }
                    $emailIDs[] = intval($tmp);
                }
            if(empty($emailIDs) && $status != self::$STATUS_DRAFT)
                exit("Selecione ao menos um e-mail ou coloque o status 'rascunho'.");
            if(isset($_FILES, $_FILES['img'], $_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != "") {
                $image = File::imageProcessing(self::$FOLDER, $_FILES['img']);
                if($image == "")
                    exit("Ocorreu uma falha inesperada ao tentar capturar essa imagem. Por favor, mude o formato, diminua a resolução ou selecione outra imagem e tente novamente.");
            }
            $status = intval($status)%(self::$MAX_STATUS+1);
        }
        public static function create($authorID, $subject, $content, $execution_date, $status, $emailIDs) {
            $image = "";
            self::prepare($authorID, $image, $subject, $content, $execution_date, $status, $emailIDs);
            $con = new Connector();
            $insert = $con->query(
                "INSERT INTO `".self::$DATABASE."` (`image`, `subject`, `content`, `execution_date`, `authorID`, `status`, `status_date`) VALUES (?, ?, ?, ?, ?, ?, NOW())",
                array("ssssii", $image."", $subject."", $content."", $execution_date."", intval($authorID), intval($status)),
                false
            );
            if($insert) {
                $values = $con->query(
                    "SELECT `ID` FROM `".self::$DATABASE."` WHERE `authorID`=? AND `status`=? ORDER BY `registry_date` DESC",
                    array("ii", intval($authorID), intval($status))
                );
                if(!empty($values)) {
                    QueueEmail::save($values[0]['ID'], $emailIDs);
                }
                exit(Display::Message("sc", "Boletim informativo cadastrado".($status == 1 ? ' e adicionado à fila' : '')." com sucesso."));
            }
            exit("Ocorreu uma falha inesperada ao tentar cadastrar esse boletim informativo. Por favor, tente novamente mais tarde.");
        }
        public static function update($ID, $authorID, $subject, $content, $execution_date, $status, $emailIDs) {
            $elem = $ID > 0 ? self::load($ID, '0,1', NULL, 2.0) : array();
            if(empty($elem))
                exit("Boletim informativo não encontrado.");
            $elem = $elem[0];
            $image = $elem['image'];
            if($elem['status'] != self::$STATUS_DRAFT && $elem['status'] != self::$STATUS_PENDENT)
                exit("Você não pode alterar boletins informativos que já estão sendo ou já foram processados.");
            self::prepare($authorID, $image, $subject, $content, $execution_date, $status, $emailIDs);
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `image`=?, `subject`=?, `content`=?, `execution_date`=?, `authorID`=?, `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ssssiii", $image."", $subject."", $content."", $execution_date."", intval($authorID), intval($status), intval($ID)),
                false
            );
            if($update) {
                QueueEmail::save($elem['ID'], $emailIDs);
                if($elem['image'] != $image && $elem['image'] != "") {
                    $base = "";
                    while(!file_exists($base."lib"))
                        $base.="../";
                    File::deleteImages($base, $elem['image'], NULL);
                }
                exit(Display::Message("sc", "Boletim informativo alterado".($status == 1 ? ' e adicionado à fila' : '')." com sucesso."));
            }
            exit("Ocorreu uma falha inesperada ao tentar alterar esse boletim informativo. Por favor, tente novamente mais tarde.");
        }
        public static function status($ID, $status = 2, $internal = false) {
            if(!$internal) {
                $status = intval($status)%(self::$MAX_STATUS+1);
                $elem = $ID > 0 ? self::load($ID, '0,1', NULL, 2.0) : array();
                if(empty($elem))
                    exit("Boletim informativo não encontorado.");
                $elem = $elem[0];
                $ID = $elem['ID'];
                if($status == 2 && $elem['status'] == self::$STATUS_STARTED)
                    exit("Este boletim está sendo processado e não pode ser excluído agora.");
            }
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ii", intval($status), intval($ID)),
                false
            );
            if(!$internal && $status == 2) {
                if($update)
                    exit(Display::Message("sc", "Boletim informativo excluído com sucesso."));
                exit("Ocorreu uma falha inesperada ao tentar excluir esse boletim informativo. Por favor, tente novamente mais tarde.");
            }
            return $update;
        }
        public static function toggle($ID) {
            $elem = $ID > 0 ? self::load($ID, '0,1', NULL, 2.0) : array();
            if(empty($elem))
                exit("Boletim informativo não encontorado.");
            $elem = $elem[0];
            if($elem['status'] != self::$STATUS_DRAFT && $elem['status'] != self::$STATUS_PENDENT)
                exit("Você só pode alternar o status de boletins rascunhos ou que ainda não foram iniciados.");
            elseif($elem['status'] == self::$STATUS_DRAFT) {
                $emails = QueueEmail::paginator(2.0, $elem['ID']);
                if($emails == 0)
                    exit("Você não pode retirar este boletim de rascunho pois não há e-mails selecionados para ele. Se deseja colocá-lo em fila, clique em 'Alterar dados', adicione e-mails e mude o status manualmente.");
            }
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=1-`status`, `status_date`=NOW() WHERE `ID`=? AND `status`<2",
                array("i", intval($elem['ID'])),
                false
            );
            if($update)
                exit(Display::Message("sc", "Status alternado com sucesso."));
            exit("Ocorreu uma falha inesperada ao tentar alternar esse status. Por favor, tente novamente mais tarde.");
        }
        public static function delete($args, $where = " WHERE `ID`=?") {
            $deleted = Connector::newInstance()->delete(self::$DATABASE, $where, $args);
            if(!empty($deleted)) {
                $where= " WHERE";
                $args = array("");
                $or = "";
                foreach($deleted as $d) {
                    $where.=$or." `queueID`=?";
                    $args[0].="i";
                    $args[] = intval($d['ID']);
                    $or = " OR";
                    
                }
                QueueEmail::delete($args, $where);
                return true;
            }
            return false;
        }
    }
?>