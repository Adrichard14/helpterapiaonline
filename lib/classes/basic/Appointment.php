<?php
	class Appointment {
		private $ID;
		private $status;
		private $name;
		private $email;
		private $telephone;
		private $doctorID;
		private $date;
		private $type;
		private $covenantID;
		private $obs;
		public static $TYPES = array("Particular - R$ 250,00","Convênio");
		public $PUBLIC_VARS = array("ID", "status","name", "email","telephone","doctorID","date","type","covenantID", "status_date", "registry_date");
		public static $DATABASE = "basic_appointment";
		public function __construct(array $data) {
            if(!empty($data))
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS))
                        $this->{$v} = $value;
        }
  	    public function get($var) {
            return $this->{$var};
        }
        private static function prepareSearch(&$w, &$a, $ID, $limit, $orderby, $status) {
            $h = $ID != -1 || $status != -1;
            $w = $h ? " WHERE" : "";
            $o = $orderby != NULL ? " ORDER BY ".$orderby  : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $a[0] = $n = "";
            if($ID != -1)
                $w.=Connector::dataMinning($a, $n, $dID, "`ID`");
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            $w.=$o.$l;
        }
         public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, $ID, $limit, $orderby, $status);
            return Connector::newInstance()->query("SELECT * FROM `".self::$DATABASE."`".$w, $a);
        }
        public static function paginator($status = -1, $URL = NULL) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, -1, NULL, NULL, $status, $URL);
            $v = Connector::newInstance()->query("SELECT COUNT(`covenantID`) AS `count` FROM `".self::$DATABASE."`".$w, $a);
            return empty($v) ? 0 : intval($v[0]['count']);
        }
        private static function prepareValues(Connector $con, &$input, &$output, &$doctor, &$covenant) {
            $vars = array("name", "status","email","telephone","doctorID","date","type","covenantID","obs");
            foreach($vars as $var) {
                if(!isset($input[$var]))
                    exit(INVALID_COMMAND);
                $output[$var] = $input[$var];
            }
            if(!isset($input['ID']))
            $input['ID'] = 0;
            $output["name"] = strip_tags(trim($output["name"]));
            $output['email'] = strtolower($output['email']);
            if(!Format::isMail($output["email"])){
            
              exit("Por favor informe um e-mail válido.");

        	}
        	$output['telephone'] = strip_tags($output['telephone']);
        	 if(!Format::isPhone($output["telephone"])){
            
              exit("Por favor informe um telefone válido.");

        	}
        	 if(!Format::isDate($output["date"])){
            
              exit("Por favor informe uma data válida.");

        	}
        	$output['date'] = Format::prepareDate($output['date']);
        	if(!isset(self::$TYPES[$output['type']])){
        		exit("Tipo de consulta inválido");
        	}
        	$doctor = $output['doctorID'] >0 ? Doctor::load($output['doctorID'],"0,1","",2.0) : array();
        	if(empty($doctor)){
        		exit("Médico não encontrado");
        	}
            $doctor = $doctor[0];
        	$covenant = $output['covenantID'] >0 ? Covenant::load($output['covenantID'],"0,1","",2.0) : array();
        	if(empty($covenant)){
        		exit("Convênio  não encontrado");
        	}
            $covenant = $covenant[0];
        	$output["obs"] = strip_tags($output["obs"]);
            $output["status"] = intval($output["status"])%2;
        }
        public static function create($FAKE_POST = NULL) {
            $output = array();
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            $con = new Connector();
            $doctor = $covenant = NULL;
            self::prepareValues($con, $input, $output, $doctor, $covenant);
            $insert = $con->query(
                "INSERT INTO `".self::$DATABASE."` (`name`,`email`,`date`,`telephone`,`doctorID`,`type`,`covenantID`,`status`,`status_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())",
                array("ssssiiii", $output['name']."",$output['email']."",$output['date']."", $output["telephone"]."", intval($output["doctorID"]),intval($output["type"]),intval($output["covenantID"]),intval($output["status"])),
                false
            );
            if($insert){
                $to = array("iocm.jardins@iocm.com.br","fabriciosouzabarreto@gmail.com");
               
                $subject = "Consulta solicitada via website IOCM Jardins";
                $content = "<p>Um visitante enviou uma mensagem do site iocm.com.br/jardins. Veja à seguir os dados preenchidos por ele: </p><p>";
                $content.="<b>Nome: </b>".$output['name']."<br>";
                $content.="<b>Email: </b>".$output['email']."<br>";
                $content.="<b>Telefone: </b>".$output["telephone"]."<br>";
                $content.="<b>Médico: </b>".$doctor["name"]."<br>";
                $content.="<b>Data da consulta: </b>".$output['date']."<br>";
                $content.="<b>Tipo de consulta: </b>".$covenant["name"]."<br>";
                $content.="<b>Observações: </b>".$output["obs"]."</p>";
                Newsletter::send($subject,$content,$to);
                return "Consulta cadastrada com sucesso.";
            }
            exit("Ocorreu uma falha inesperada ao tentar cadastrar essa consulta. Por favor, tente novamente mais tarde.");
        }
        public static function update($FAKE_POST = NULL) {
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            if(!isset($input['ID']) || intval($input['ID']) <= 0)
                exit(INVALID_COMMAND);
            $input['ID'] = intval($input['ID']);
            $elem = self::load($input['ID'], "0,1", NULL, 2.0);
            if(empty($elem))
                exit("Consulta não encontrada.");
            $elem = $elem[0];
            $output = array();
            $con = new Connector();
            $doctor = $covenant = NULL;
            self::prepareValues($con, $input, $output, $doctor, $covenant);
            $update = Connector::newInstance()->query(
				"UPDATE `".self::$DATABASE."` SET `name`=?,`email`=?,`date`=?,`telephone`=?,`doctorID=?`,`type`=?,`covenantID`=?,`status`=?,`status_date`=NOW() WHERE `ID`=?",
                array("ssssiiiii", $output['name']."",$output['email']."",$output['date']."", $output["telephone"]."", intval($output["doctorID"]),intval($output["type"]),intval($output["covenantID"]),intval($output["status"]), intval($input['ID'])),
                false
            );
            if($update) {
                return "Consulta alterada com sucesso.";
            }
            exit("Ocorreu uma falha inesperada ao tentar alterar essa consulta. Por favor, tente novamente mais tarde.");
        }
        public static function status($ID, $status = 2) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ii", intval($status)%3, intval($ID)),
                false
            );
            if($status == 2) {
                if($update) {
                    return "Consulta excluída com sucesso.";
                }
                exit("Ocorreu uma falha inesperada ao tentar excluir esse texto. Por favor, tente novamente mais tarde.");
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