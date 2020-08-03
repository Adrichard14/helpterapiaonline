<?php 
//Classe de médicos / doutores
	class Doctor {
		private $doctorID; //Int
		private $status;
		private $URL ;
		private $name;//Var char
		private $specialty; 
		private $status_date;// date
		private $registry_date; //timestamp() current_timestamp
		public $PUBLIC_VARS = array("doctorID", "status", "URL", "name", "specialty", "status_date", "registry_date");
		public static $DATABASE = "basic_doctor";
	
        public function __construct(array $data) {
            if(!empty($data))
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS))
                        $this->{$v} = $value;
        }
        public function get($var) {
            return $this->{$var};
        }
        private static function prepareSearch(&$w, &$a, $doctorID, $limit, $orderby, $status, $URL) {
            $h = $doctorID != -1 || $status != -1 || $URL != NULL;
            $w = $h ? " WHERE" : "";
            $o = $orderby != NULL ? " ORDER BY ".$orderby  : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $a[0] = $n = "";
            if($doctorID != -1)
                $w.=Connector::dataMinning($a, $n, $doctorID, "`doctorID`");
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            if($URL != NULL)
                $w.=Connector::dataMinning($a, $n, $URL, "`URL`", "str");
            $w.=$o.$l;
        }
            public static function load($doctorID = -1, $limit = NULL, $orderby = NULL, $status = -1, $URL = NULL){
            $w = $a = NULL;
            self::prepareSearch($w, $a, $doctorID, $limit, $orderby, $status, $URL);

            return Connector::newInstance()->query("SELECT * FROM `".self::$DATABASE."`".$w, $a);
        }
        public static function paginator($status = -1, $URL = NULL) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, -1, NULL, NULL, $status, $URL);
            $v = Connector::newInstance()->query("SELECT COUNT(`doctorID`) AS `count` FROM `".self::$DATABASE."`".$w, $a);
            return empty($v) ? 0 : intval($v[0]['count']);
        }
        private static function prepareValues(Connector $con, &$input, &$output) {
            $vars = array("name", "specialty", "status");
            foreach($vars as $var) {
                if(!isset($input[$var]))
                    exit(INVALID_COMMAND);
                $output[$var] = $input[$var];
            }
            if(!isset($input['ID']))
            $input['ID'] = 0;
            $input['doctorID'] = $input['ID'];
            $output["name"] = trim($output["name"]);
            $output["specialty"] = trim($output["specialty"]);
            $output["URL"] = Format::toURL($output['name']);
            if(strlen($output['name']) < 3)
                exit("Por favor, informe um nome completo.");
            $values = $con->query(
                "SELECT `doctorID` FROM `".self::$DATABASE."` WHERE `URL`=? AND `status`!=2 AND `doctorID`!=?",
                array("si", $output['URL']."", intval($input['doctorID']))
            );
            if(!empty($values))
                exit("Este nome gerou uma URL já existente no sistema. Por favor, altere-o e tente novamente.");
            $output["status"] = intval($output["status"])%2;
        }
        public static function create($FAKE_POST = NULL) {
            $output = array();
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            $con = new Connector();
            self::prepareValues($con, $input, $output);
            $insert = $con->query(
                "INSERT INTO `".self::$DATABASE."` ( `URL`, `name`,`specialty`,`status`,`status_date`) VALUES (?, ?, ?, ?, NOW())",
                array("sssi", $output['URL']."", $output["name"]."", $output["specialty"]."", intval($output["status"])),
                false
            );
            if($insert)
                return "Registro cadastrado com sucesso.";
            exit("Ocorreu uma falha inesperada ao tentar cadastrar. Por favor, tente novamente mais tarde.");
        }
        public static function update($FAKE_POST = NULL) {
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            if(!isset($input['ID']) || intval($input['ID']) <= 0)
                exit(INVALID_COMMAND);
            $input['ID'] = intval($input['ID']);
            $elem = self::load($input['ID'], "0,1", NULL, 2.0);
            if(empty($elem))
                exit("Registro não encontrado.");
            $elem = $elem[0];
            $output = array();
            $con = new Connector();

            self::prepareValues($con, $input, $output);
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `URL`=?, `name`=?, `specialty`=?, `status`=?, `status_date`=NOW() WHERE `doctorID`=?",
                array("sssii", $output["URL"]."", $output["name"]."", $output["specialty"]."", intval($output["status"]), intval($input['doctorID'])),
                false
            );
            if($update) {
                return "Registro alterado com sucesso.";
            }
            exit("Ocorreu uma falha inesperada ao tentar alterar esse registro. Por favor, tente novamente mais tarde.");
        }
        public static function status($doctorID, $status = 2) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `doctorID`=?",
                array("ii", intval($status)%3, intval($doctorID)),
                false
            );
            if($status == 2) {
                if($update) {
                    return "Registro excluído com sucesso.";
                }
                exit("Ocorreu uma falha inesperada ao tentar excluir esse registro. Por favor, tente novamente mais tarde.");
            }
            return $update;
        }
        public static function toggle($doctorID) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=1-`status` WHERE `doctorID`=? AND `status`<2",
                array("i", intval($doctorID)),
                false
            );
            if($update)
                return STATUS_TOGGLED;
            exit(STATUS_TOGGLE_FAILED);
        }
        public static function delete($args, $where = " WHERE `doctorID`=?") {
            return Connector::newInstance()->delete(self::$DATABASE, $where, $args, false);
        }
    }
        
















	?>