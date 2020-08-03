<?php
    class Team {
        private $ID; //Int
        private $status;
        private $order;
        private $CRM;
        private $link; //Var char 
        private $thumb;
        private $thumb_tablet;
        private $thumb_mobile;
        private $title;
        
        private $init_date; //Date time
        private $end_date;
        private $status_date;
        private $registry_date; //Timestamp current_timestamp
        public $PUBLIC_VARS = array("ID", "status","order","CRM", "link", "thumb", "thumb_tablet", "thumb_mobile", "title", "status_date", "init_date", "end_date", "registry_date");
        public static $DATABASE         = "basic_team";
        public static $FOLDER           = "uploads/equipes";
        public static $DESKTOP          = array(1200,349);
        public static $TABLET           = array(980,349);
        public static $MOBILE           = array(767,560);
        public function __construct(array $data) {
            if(!empty($data))
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS))
                        $this->{$v} = $value;
        }
        public function get($var) {
            return $this->{$var};
        }
        public function publish() {
            return $this->desktop().$this->tablet().$this->mobile();
        }
        public function img($URL, $class) {
            return '<a href="'.self::get_link($this->link).'" class="'.$class.'"><img src="'.PUBLIC_URL.$URL.'" class="img-responsive" style="width: 100%;" /></a>';
        }
        public function desktop($class = "visible-lg visible-md") {
            return $this->img($this->thumb, $class);
        }
        public function tablet($class = "visible-sm") {
            return $this->thumb_tablet != "" ? $this->img($this->thumb_tablet, $class) : $this->desktop($class);
        }
        public function mobile($class = "visible-xs") {
            return $this->thumb_mobile != "" ? $this->img($this->thumb_mobile, $class) : $this->tablet($class);
        }
        private static function prepareSearch(&$w, &$a, $ID, $limit, $orderby, $status, $ondate) {
            $h = $ID != -1 || $status != -1 || $ondate != NULL ;
            $w = $h ? " WHERE" : "";
            $o = $orderby != NULL ? " ORDER BY ".$orderby  : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $a[0] = $n = "";
            if($ID != -1)
                $w.=Connector::dataMinning($a, $n, $ID, "`ID`");
            if($status != -1)
                $w.=Connector::dataMinning($a, $n, $status, "`status`");
            if($ondate != NULL) {
                $w.=$n." (`init_date`='".Format::$DEFAULT_DATETIME."' OR `init_date`<=?) AND (`end_date`='".Format::$DEFAULT_DATETIME."' OR `end_date`>?)";
                $a[0].="ss";
                $a[] = $ondate."";
                $a[] = $ondate."";
                $n = " AND";
            }
            $w.=$o.$l;
        }
        public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1, $ondate = NULL) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, $ID, $limit, $orderby, $status, $ondate);
            return Connector::newInstance()->query("SELECT * FROM `".self::$DATABASE."`".$w, $a);
        }
        public static function paginator($status = -1, $ondate = NULL) {
            $w = $a = NULL;
            self::prepareSearch($w, $a, -1, NULL, NULL, $status, $ondate);
            $v = Connector::newInstance()->query("SELECT COUNT(`ID`) AS `count` FROM `".self::$DATABASE."`".$w, $a);
            return empty($v) ? 0 : intval($v[0]['count']);
        }
        public static function get_link($link) {
            return $link != "" && Format::isLink($link) ? $link : "#";
        }
        private static function prepareValues($input, &$output) {
            $vars = array("thumb", "thumb_tablet", "thumb_mobile", "link", "title", "init_date", "end_date", "status","order","CRM");
            foreach($vars as $var) {
                if(!isset($input[$var]))
                    exit(INVALID_COMMAND.$var);
                $output[$var] = $input[$var];
            }
            if($output["thumb"] == "")
                exit("Selecione uma imagem para desktop (ela é a única obrigatória).");
            $output["link"] = strtolower($output["link"]);
            if($output["link"] != "" && !Format::isLink($output["link"]))
                exit("Digite um link por completo, desde http, ou deixe em branco.");
            $output["title"] = trim($output["title"]);
            $regin = "/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/";
            $regout = "$3-$2-$1 $4:$5:00";
            if($output["init_date"] != "" && !preg_match($regin, $output["init_date"]))
                exit(WRONG_INIT_DATE);
            if($output["end_date"] != "" && !preg_match($regin, $output["end_date"]))
                exit(WRONG_END_DATE);
            $output["init_date"] = $output["init_date"] != "" ? preg_replace($regin, $regout, $output["init_date"]) : Format::$DEFAULT_DATETIME;
            $output["end_date"] = $output["end_date"] != "" ? preg_replace($regin, $regout, $output["end_date"]) : Format::$DEFAULT_DATETIME;
            if($output["order"] <= 0)
                $output["order"] = self::last() + 1;
            $output["status"] = intval($output["status"])%2;
        }
        public static function create($FAKE_POST = NULL) {
            $output = array();
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            $input["order"] = 0;
            self::prepareValues($input, $output);
            $insert = Connector::newInstance()->query(
                "INSERT INTO `".self::$DATABASE."` (`thumb`, `thumb_tablet`, `thumb_mobile`, `title`,`init_date`, `end_date`, `link`, `status`, `order`,`CRM`,  `status_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW())",
                array("sssssssiii", $output["thumb"]."", $output["thumb_tablet"]."", $output["thumb_mobile"]."", $output["title"]."", $output["init_date"]."", $output["end_date"]."", $output["link"]."", intval($output["status"]), intval($output["order"]) ,intval($output["CRM"])),
                false
            );
            if($insert)
                return "Membro cadastrado com sucesso";
            exit("Erro ao cadastrar membro");
        }
        public static function update($FAKE_POST = NULL) {
            $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
            if(!isset($input['ID']) || intval($input['ID']) <= 0)
                exit(INVALID_COMMAND);
            $input['ID'] = intval($input['ID']);
            $elem = self::load($input['ID'], "0,1", NULL, 2.0);
            if(empty($elem))
                exit(SLIDE_NOT_FOUND);
            $elem = $elem[0];
            $input["order"] = $elem['order'];
            $output = array();
            self::prepareValues($input, $output);
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `thumb`=?, `thumb_tablet`=?, `thumb_mobile`=?, `title`=?, `init_date`=?, `end_date`=?, `link`=?, `status`=?,`CRM`=?, `status_date`=NOW() WHERE `ID`=?",
                array("sssssssiii", $output["thumb"]."", $output["thumb_tablet"]."", $output["thumb_mobile"]."", $output["title"]."", $output["init_date"]."", $output["end_date"]."", $output["link"]."", intval($output["status"]),intval($output['CRM']),intval($input['ID'])),
                false
            );
            if($update) {
                $base = "";
                while(!file_exists($base."lib"))
                    $base.="../";
                if($output["thumb"] != $elem['thumb'] && $elem['thumb'] != "")
                    File::deleteImages($base, $elem['thumb']);
                if($output["thumb_tablet"] != $elem['thumb_tablet'] && $elem['thumb_tablet'] != "")
                    File::deleteImages($base, $elem['thumb_tablet']);
                if($output["thumb_mobile"] != $elem['thumb_mobile'] && $elem['thumb_mobile'] != "")
                    File::deleteImages($base, $elem['thumb_mobile']);
                return "Membro atualizado com sucesso!";
            }
            exit("Erro ao atualizar membro");
        }
        public static function last() {
            $values = Connector::newInstance()->query(
                "SELECT `order` FROM `".self::$DATABASE."` WHERE `status`!=2 ORDER BY `order` DESC LIMIT 0,1"
            );
            return empty($values) ? 0 : intval($values[0]['order']);
        }
        public static function reorder($current = -1, $next = -1) {
            $targets = self::load(-1, NULL, "`order` ASC", 2.0);
            if(empty($targets))
                return true;
            $last = sizeof($targets);
            $move = $current > 0 && $next > 0 && $current != $next && $current <= $last && $next <= $last;
            if($move) {
                if($current > $next) {
                    $p  = 1;
                    $i  = $next;
                    $e  = $current-1;
                } else {
                    $p  = -1;
                    $i  = $current+1;
                    $e  = $next;
                }
            }
            $con = new Connector();
            foreach($targets as $order => $target) {
                $o = $order+1;
                if($o >= $i && $o <= $e)
                    $o+=$p;
                $con->query(
                    "UPDATE `".self::$DATABASE."` SET `order`=? WHERE `ID`=?",
                    array("ii", intval($o), intval($target["ID"])),
                    false
                );
            }
            return true;
        }
        public static function order($ID, $value, $diff = true, $move = true) {
            $elem = $ID > 0 ? self::load($ID, "0,1", NULL, 2.0) : array();
            if(empty($elem))
                exit(ORDERABLE_ELEMENT_NOT_FOUND);
            $elem = $elem[0];
            $current = $elem['order'];
            $next = $diff ? $current+$value : $value;
            if($next == $current)
                exit(ORDERABLE_ELEMENT_ALREADY_ON_POS);
            $last = self::last();
            $con = new Connector();
            if($next <= 0 || $next > $last)
                exit(ORDERABLE_ELEMENT_UNAVAILABLE);
            if($move)
                self::reorder($current, $next);
            else
                $con->query(
                    "UPDATE `".self::$DATABASE."` SET `order`=? WHERE `order`=? AND `status`!=2",
                    array("iii", intval($current), intval($next)),
                    false
                );
            $update = $con->query(
                "UPDATE `".self::$DATABASE."` SET `order`=? WHERE `ID`=?",
                array("ii", intval($next), intval($ID)),
                false
            );
            if($update)
                exit(ORDERABLE_ELEMENT_SUCCESS);
            exit(ORDERABLE_ELEMENT_FAILED);
        }
        public static function status($ID, $status = 2) {
            $update = Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ii", intval($status)%3, intval($ID)),
                false
            );
            if($status == 2) {
                if($update) {
                    self::reorder();
                    return "Membro deletado";
                }
                exit("Erro ao deletar membro");
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
            $deleted = Connector::newInstance()->delete(self::$DATABASE, $where, $args);
            if(!empty($deleted)) {
                $base = "";
                while(!file_exists($base."lib"))
                    $base.="../";
                $files = array("", "_tablet", "_mobile");
                foreach($deleted as $d) {
                    foreach($files as $f) {
                        if($d['thumb'.$f] != "")
                            File::deleteImages($base, $d['thumb'.$f]);
                    }
                }
                self::reorder();
                return true;
            }
            return false;
        }
    }
?>