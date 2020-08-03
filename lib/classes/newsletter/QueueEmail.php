<?php
    class QueueEmail {
        private $ID;
        private $status;
        private $queueID;
        private $emailID;
        private $status_date;
        private $registry_date;
        public $PUBLIC_VARS = array("ID", "status", "queueID", "emailID", "status_date", "registry_date");
        public static $DATABASE = "newsletter_queueemail";
        public static $STATUS_PENDENT   = 0;
        public static $STATUS_SENT      = 1;
        public static $STATUS_DELETED   = 2;
        public function __construct(array $data) {
            if(!empty($data))
                foreach($data as $v => $value)
                    if(in_array($v, $this->PUBLIC_VARS))
                        $this->{$v} = $value;
        }
        public function get($var) {
            return $this->{$var};
        }
        public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1, $queueID = -1, $emailID = -1) {
            $h = $ID != -1 || $status != -1 || $queueID != -1 || $emailID != -1;
            $w = $h ? " WHERE" : "";
            $a = $h ? array("") : NULL;
            $o = $orderby != NULL ? " ORDER BY ".$orderby : "";
            $l = $limit != NULL ? " LIMIT ".$limit : "";
            $n = $q = "";
            $integers = array("ID", "status", "queueID", "emailID");
            foreach($integers as $int) {
                if($$int != -1)
                    $w.=Connector::dataMinning($a, $n, $$int, "`queueemail`.`".$int."`");
            }
            $obj = new self(array());
            foreach($obj->PUBLIC_VARS as $i => $v)
                $q.=($i>0?', ':'').'`queueemail`.`'.$v.'`';
            $obj = new Queue(array());
            foreach($obj->PUBLIC_VARS as $v)
                $q.=', `queue`.`'.$v.'` AS `queue_'.$v.'`';
            $obj = new Email(array());
            foreach($obj->PUBLIC_VARS as $v)
                $q.=', `email`.`'.$v.'` AS `email_'.$v.'`';
            return Connector::newInstance()->query(
                "SELECT ".$q." FROM `".self::$DATABASE."` AS `queueemail`".
                " LEFT JOIN `".Queue::$DATABASE."` AS `queue` ON `queueemail`.`queueID`=`queue`.`ID`".
                " LEFT JOIN `".Email::$DATABASE."` AS `email` ON `queueemail`.`emailID`=`email`.`ID`".
                $w.$o.$l, $a
            );
        }
        public static function paginator($status = -1, $queueID = -1, $emailID = -1) {
            $h = $status != -1 || $queueID != -1 || $emailID != -1;
            $w = $h ? " WHERE" : "";
            $a = $h ? array("") : NULL;
            $n = "";
            $integers = array("status", "queueID", "emailID");
            foreach($integers as $int) {
                if($$int != -1)
                    $w.=Connector::dataMinning($a, $n, $$int, "`queueemail`.`".$int."`");
            }
            $v = Connector::newInstance()->query(
                "SELECT COUNT(`queueemail`.`ID`) AS `count` FROM `".self::$DATABASE."` AS `queueemail`".
//                " LEFT JOIN `".Queue::$DATABASE."` AS `queue` ON `queueemail`.`queueID`=`queue`.`ID`".
//                " LEFT JOIN `".Email::$DATABASE."` AS `email` ON `queueemail`.`emailID`=`email`.`ID`".
                $w, $a
            );
            return empty($v) ? 0 : intval($v[0]['count']);
        }
        public static function save($queueID, array $emailIDs) {
            $con = new Connector();
            if(empty($emailIDs)) {
                $con->query(
                    "UPDATE `".self::$DATABASE."` SET `status`=2, `status_date`=NOW() WHERE `queueID`=? AND `status`!=2",
                    array("i", intval($queueID)),
                    false
                );
            } else {
                $current = array();
                $temp = $con->query(
                    "SELECT `ID`, `emailID` FROM `".self::$DATABASE."` WHERE `queueID`=? AND `status`!=2",
                    array("i", intval($queueID))
                );
                if(!empty($temp))
                    foreach($temp as $t)
                        $current[$t['ID']] = $t['emailID'];
                $toInsert = array();
                $insert = "INSERT INTO `".self::$DATABASE."` (`queueID`, `emailID`, `status`, `status_date`) VALUES";
                $insert_= " (?, ?, 0, NOW())";
                $insertn= "";
                $inserta= array("");
                foreach($emailIDs as $emailID) {
                    $ID = array_search($emailID, $current);
                    if($ID !== false) { // already exists
                        unset($current[$ID]);
                    } else { // insert
                        $insert.=$insertn.$insert_;
                        $inserta[0].= "ii";
                        $inserta[] = intval($queueID);
                        $inserta[] = intval($emailID);
                        $insertn = ",";
                    }
                }
                $inserted = $updated = -1;
                if($insertn != "") {
                    $inserted = $con->query($insert, $inserta, false);
                }
                if(!empty($current)) {
                    $update = "UPDATE `".self::$DATABASE."` SET `status`=2, `status_date`=NOW() WHERE ";
                    $update_= "`ID`=?";
                    $updaten= "";
                    $updatea= array("");
                    foreach($current as $ID => $emailID) {
                        $update.=$updaten.$update_;
                        $updatea[0].="i";
                        $updatea[] = intval($ID);
                        $updaten = " OR ";
                    }
                    $updated = $con->query($update, $updatea, false);
                }
            }
        }
        public static function status($ID, $status) {
            return Connector::newInstance()->query(
                "UPDATE `".self::$DATABASE."` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
                array("ii", intval($status)%3, intval($ID)),
                false
            );
        }
    }
?>