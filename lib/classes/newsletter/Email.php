<?php
    class Email {
        private $ID;
        private $status;
        private $name;
        private $value;
        private $status_date;
        private $registry_date;
        public $PUBLIC_VARS = array("ID", "status", "name", "value", "status_date", "registry_date");
        public static $DATABASE = "newsletter_email";
        public function __construct(array $data) {
            if(!empty($data)) {
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS)) {
                        $this->{$v} = $value;
                    }
            }
        }
        public function get($var) {
            return $this->{$var};
        }
        public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1) {
            $h = $ID != -1 || $status != -1;
            $w = $h ? " WHERE" : "";
            $a = $h ? array("") : NULL;
            $o = $orderby != NULL ? " ORDER BY ".$orderby : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $n = "";
            if($ID != -1)
                $w.=Connector::dataMinning($a, $n, $ID, "`ID`");
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            return Connector::newInstance()->query("SELECT * FROM `".self::$DATABASE."`".$w.$o.$l, $a);
        }
        public static function paginator($status = -1) {
            $h = $status != -1;
            $w = $h ? " WHERE" : "";
            $a = $h ? array("") : NULL;
            $n = "";
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            $v = Connector::newInstance()->query("SELECT COUNT(`ID`) AS `count` FROM `".self::$DATABASE."`".$w, $a);
            return empty($v) ? 0 : intval($v[0]['count']);
        }
        private static function prepareValues(Connector $con, $input, &$output) {
            $vars = array(/*"name", */"value");
            foreach($vars as $var) {
                if(!isset($input[$var]))
                    exit(INVALID_COMMAND);
                $output[$var] = $input[$var];
            }
            if(!isset($input['ID']))
                $input['ID'] = 0;
            $output['name'] = "";
//            $output["name"] = trim(strip_tags($output["name"]));
//            if(strlen(Format::toURL($output["name"])) < 2)
//                exit("Digite seu nome por extenso.");
            $output["value"] = trim(strtolower($output["value"]));
            if(!Format::isMail($output["value"]))
                exit("Por favor, informe um e-mail válido.");
            $values = $con->query(
                "SELECT `ID` FROM `".self::$DATABASE."` WHERE `value`=? AND `ID`!=?",
                array("si", $output["value"]."", intval($input['ID']))
            );
            if(!empty($values))
                exit("Este e-mail já está registrado em nosso sistema. Por favor, altere-o e tente novamente.");
        }
        public static function create($FAKE_POST = NULL) {
            $output = array();
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            $con = new Connector();
            self::prepareValues($con, $input, $output);
            $insert = $con->query(
                "INSERT INTO `".self::$DATABASE."` (`name`, `value`, `status`, `status_date`) VALUES (?, ?, 1, NOW())",
                array("ss", $output["name"]."", $output["value"].""),
                false
            );
            if($insert)
                return "E-mail cadastrado com sucesso.";
            exit("Ocorreu uma falha inesperada ao tentar cadastrar esse e-mail. Por favor, tente novamente mais tarde.");
        }
        public static function update($FAKE_POST) {
            $output = array();
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            if(!isset($input['ID']) || intval($input['ID']) <= 0)
                exit(INVALID_COMMAND);
            $elem = self::load($input['ID'], '0,1', NULL, 2.0);
            if(empty($elem))
                exit("E-mail não encontrado no sistema. Por favor, atualize a página.");
            $elem = $elem[0];
            $con = new Connector();
            self::prepareValues($con, $input, $output);
            $update = $con->query(
                "UPDATE `".self::$DATABASE."` SET `name`=?, `value`=? WHERE `ID`=?",
                array("ssi", $output["name"]."", $output["value"]."", intval($input["ID"])),
                false
            );
            if($update)
                return "E-mail alterado com sucesso.";
            exit("Ocorreu uma falha inesperada ao tentar alterar esse e-mail. Por favor, tente novamente mais tarde.");
        }
        public static function status($ID, $status = 2) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ii", intval($status)%3, intval($ID)),
                false
            );
            if($status == 2) {
                if($update)
                    return "E-mail excluído com sucesso.";
                exit("Ocorreu uma falha inesperada ao tentar excluir esse e-mail. Por favor, tente novamente mais tarde.");
            }
            return $update;
        }
        public static function toggle($ID) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=1-`status`, `status_date`=NOW() WHERE `ID`=? AND `status`<2",
                array("i", intval($ID)),
                false
            );
            if($update) {
                return "Status alternado com sucesso.";
            }
            exit("Ocorreu uma falha inesperada ao tentar alternar esse status. Por favor, tente novamente mais tarde.");
        }
        public static function delete($args, $where = " WHERE `ID`=?") {
            return Connector::newInstance()->delete(self::$DATABASE, $where, $args, false);
        }
    }
?>