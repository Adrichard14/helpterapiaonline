<?php
    class About {
        private $ID; //Int
        private $status;
        private $URL;
        private $title; //Varchar
        private $content; //Text
        private $status_date; //Date time
        private $registry_date; //Time stamp
        public $PUBLIC_VARS = array("ID", "status", "URL", "title", "content", "status_date", "registry_date");
        public static $DATABASE         = "basic_staticpost";
        public function __construct(array $data) {
            if(!empty($data))
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS))
                        $this->{$v} = $value;
        }
        public function get($var) {
            return $this->{$var};
        }
        private static function prepareSearch(&$w, &$a, $ID, $limit, $orderby, $status, $URL) {
            $h = $ID != -1 || $status != -1 || $URL != NULL;
            $w = $h ? " WHERE" : "";
            $o = $orderby != NULL ? " ORDER BY ".$orderby  : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $a[0] = $n = "";
            if($ID != -1)
                $w.=Connector::dataMinning($a, $n, $ID, "`ID`");
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            if($URL != NULL)
                $w.=Connector::dataMinning($a, $n, $URL, "`URL`", "str");
            $w.=$o.$l;
        }
        public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1, $URL = NULL) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, $ID, $limit, $orderby, $status, $URL);
            return Connector::newInstance()->query("SELECT * FROM `".self::$DATABASE."`".$w, $a);
        }
        public static function paginator($status = -1, $URL = NULL) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, -1, NULL, NULL, $status, $URL);
            $v = Connector::newInstance()->query("SELECT COUNT(`ID`) AS `count` FROM `".self::$DATABASE."`".$w, $a);
            return empty($v) ? 0 : intval($v[0]['count']);
        }
        private static function prepareValues(Connector $con, $input, &$output) {
            $vars = array("title", "content", "status");
            foreach($vars as $var) {
                if(!isset($input[$var]))
                    exit(INVALID_COMMAND);
                $output[$var] = $input[$var];
            }
            if(!isset($input['ID']))
                $input['ID'] = 0;
            $output["title"] = trim($output["title"]);
            $output["URL"] = Format::toURL($output['title']);
            if(strlen($output['URL']) < 3)
                exit("Por favor, informe um título mais extenso.");
            $values = $con->query(
                "SELECT `ID` FROM `".self::$DATABASE."` WHERE `URL`=? AND `status`!=2 AND `ID`!=?",
                array("si", $output['URL']."", intval($input['ID']))
            );
            if(!empty($values))
                exit("Este título gerou uma URL já existente no sistema. Por favor, altere-o e tente novamente.");
            $output["status"] = intval($output["status"])%2;
        }
        public static function create($FAKE_POST = NULL) {
            $output = array();
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            $con = new Connector();
            self::prepareValues($con, $input, $output);
            $insert = $con->query(
                "INSERT INTO `".self::$DATABASE."` (`URL`, `title`, `content`, `status`, `status_date`) VALUES (?, ?, ?, ?, NOW())",
                array("sssi", $output['URL']."", $output["title"]."", $output["content"]."", intval($output["status"])),
                false
            );
            if($insert)
                return "Página cadastrada com sucesso.";
            exit("Ocorreu uma falha inesperada ao tentar cadastrar essa página. Por favor, tente novamente mais tarde.");
        }
        public static function update($FAKE_POST = NULL) {
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            if(!isset($input['ID']) || intval($input['ID']) <= 0)
                exit(INVALID_COMMAND);
            $input['ID'] = intval($input['ID']);
            $elem = self::load($input['ID'], "0,1", NULL, 2.0);
            if(empty($elem))
                exit("Página não encontrada.");
            $elem = $elem[0];
            $output = array();
            $con = new Connector();
            self::prepareValues($con, $input, $output);
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `URL`=?, `title`=?, `content`=?, `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("sssii", $output["URL"]."", $output["title"]."", $output["content"]."", intval($output["status"]), intval($input['ID'])),
                false
            );
            if($update) {
                return "Página alterada com sucesso.";
            }
            exit("Ocorreu uma falha inesperada ao tentar alterar essa página. Por favor, tente novamente mais tarde.");
        }
        public static function status($ID, $status = 2) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ii", intval($status)%3, intval($ID)),
                false
            );
            if($status == 2) {
                if($update) {
                    return "Página excluída com sucesso.";
                }
                exit("Ocorreu uma falha inesperada ao tentar excluir essa página. Por favor, tente novamente mais tarde.");
            }
            return $update;
        }
        public static function toggle($ID) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=1-`status` WHERE `ID`=? AND `status`<2",
                array("i", intval($ID)),
                false
            );
            if($update)
                return STATUS_TOGGLED;
            exit(STATUS_TOGGLE_FAILED);
        }
        public static function delete($args, $where = " WHERE `ID`=?") {
            return Connector::newInstance()->delete(self::$DATABASE, $where, $args, false);
        }
    }
?>