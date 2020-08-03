<?php
class EventLink
{
    private $ID; //Int
    private $status;
    private $title;
    private $eventID;
    private $link;
    private $registry_date; // Timestamp - current_timestamp

    public $PUBLIC_VARS = array("ID", "status", "title", "registry_date", "eventID", "link");
    public static $DATABASE         = "basic_eventlinks";
    public static $DESKTOP          = array(1200, 889);
    public function __construct(array $data)
    {
        if (!empty($data))
            foreach ($data as $v => $value)
                if (in_array($v, $this->PUBLIC_VARS))
                    $this->{$v} = $value;
    }
    public function get($var)
    {
        return $this->{$var};
    }
    private static function prepareSearch(&$w, &$a, $ID, $limit, $orderby, $status, $eventID)
    {
        $h = $ID != -1 || $status != -1 ||  $eventID != -1;
        $w = $h ? " WHERE" : "";
        $o = $orderby != NULL ? " ORDER BY " . $orderby  : "";
        $l = $limit != NULL ? " LIMIT " . $limit : "";
        $a[0] = $n = "";
        if ($ID != -1)
            $w .= Connector::dataMinning($a, $n, $ID, "`ID`");
        if ($status != -1)
            $w .= Connector::dataMinning($a, $n, $status, "`status`");
        if ($eventID != -1)
            $w .= Connector::dataMinning($a, $n, $eventID, "`eventID`");
        // if($ondate != NULL) {
        //     $w.=$n." (`init_date`='".Format::$DEFAULT_DATETIME."' OR `init_date`<=?) AND (`end_date`='".Format::$DEFAULT_DATETIME."' OR `end_date`>?)";
        //     $a[0].="ss";
        //     $a[] = $ondate."";
        //     $a[] = $ondate."";
        //     $n = " AND";
        // }
        $w .= $o . $l;
    }
    public static function load($ID = -1, $limit = NULL, $orderby = NULL, $status = -1, $eventID = -1)
    {
        $w = $a = NULL;
        self::prepareSearch($w, $a, $ID, $limit, $orderby, $status, $eventID);
        return Connector::newInstance()->query("SELECT * FROM `" . self::$DATABASE . "`" . $w, $a);
    }
    public static function paginator($status = -1)
    {
        $w = $a = NULL;
        self::prepareSearch($w, $a, -1, NULL, NULL, $status, NULL, NULL, -1);
        $v = Connector::newInstance()->query("SELECT COUNT(`ID`) AS `count` FROM `" . self::$DATABASE . "`" . $w, $a);
        return empty($v) ? 0 : intval($v[0]['count']);
    }
    private static function prepareValues($input, &$output)
    {
        $vars = array("ID", "link");
        foreach ($vars as $var) {
            if (!isset($input[$var]))
                exit(INVALID_COMMAND);
            $output[$var] = $input[$var];
        }
        $output["link"] = strtolower($output["link"]);
    }
    public static function create2($status, $eventID, $link)
    {
        $insert = Connector::newInstance()->query(
            "INSERT INTO `" . self::$DATABASE . "` (`status`, `eventID`, `link`) VALUES (?, ?, ?)",
            array("iis", intval($status) % 2, intval($eventID), $link . ""),
            false
        );
        if ($insert) {
            return "Sucesso";
        }
        exit("Ocorreu uma falha ao cadastrar o link da vídeo chamada");
    }
    public static function create($FAKE_POST = NULL)
    {
        $output = array();
        $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
        self::prepareValues($input, $output);
        $insert = Connector::newInstance()->query(
            "INSERT INTO `" . self::$DATABASE . "` (`title`, `eventID`) VALUES ( ?, ?)",
            array("ii", intval($output["status"]), intval($output["eventID"])),
            false
        );
        if ($insert)
            return "Agenda cadastrada com sucesso!";
        exit("Erro ao cadastrar noticia, por favor tente novamente.");
    }
    public static function update($FAKE_POST = NULL)
    {
        $input = $FAKE_POST !== NULL ? $FAKE_POST : $_POST;
        
        if (!isset($input['ID']) || intval($input['ID']) <= 0)
            exit(INVALID_COMMAND);
        $input['ID'] = intval($input['ID']);
        $elem = self::load($input['ID'], null, null, -1, $input['eventID']);
        
        if (empty($elem))
            exit(SLIDE_NOT_FOUND);
        $elem = $elem[0];
        $output = array();
        self::prepareValues($input, $output);
        // exit(var_dump(self::prepareValues($input, $output)));
        // exit(var_dump($input));
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `link`=? WHERE `ID`=?",
            array("si", $output["link"] . "", intval($input['ID'])),
            false
        );
        // exit(var_dump($update));
        if ($update) {
            return "Noticia alterada com sucesso!";
        }
        exit("Erro ao atualizar noticia, por favor tente novamente.");
    }
    // public static function update($ID, $link){
    //     $con = new Connector();
    //     $values = $con->query(
    //         "SELECT `ID` FROM `" . self::$DATABASE . "` WHERE `ID`!=?",
    //         array("i", intval($ID))
    //     );
    //     $set = " SET link=?";
    //     $args = array("s", $link . "");
    //     $set .= " WHERE ID=?";
    //     $args[0] .= "i";
    //     $args[] = intval($ID);
    //     if ($con->query(
    //         "UPDATE `" . self::$DATABASE . "`" . $set,
    //         $args,
    //         false
    //     )) {
    //         return true;
    //     }
    //     return false;
    // }
    public static function last()
    {
        $values = Connector::newInstance()->query(
            "SELECT `order` FROM `" . self::$DATABASE . "` WHERE `status`!=2 ORDER BY `order` DESC LIMIT 0,1"
        );
        return empty($values) ? 0 : intval($values[0]['order']);
    }
    public static function reorder($current = -1, $next = -1)
    {
        $targets = self::load(-1, NULL, "`order` ASC", 2.0);
        if (empty($targets))
            return true;
        $last = sizeof($targets);
        $move = $current > 0 && $next > 0 && $current != $next && $current <= $last && $next <= $last;
        if ($move) {
            if ($current > $next) {
                $p  = 1;
                $i  = $next;
                $e  = $current - 1;
            } else {
                $p  = -1;
                $i  = $current + 1;
                $e  = $next;
            }
        }
        $con = new Connector();
        foreach ($targets as $order => $target) {
            $o = $order + 1;
            if ($o >= $i && $o <= $e)
                $o += $p;
            $con->query(
                "UPDATE `" . self::$DATABASE . "` SET `order`=? WHERE `ID`=?",
                array("ii", intval($o), intval($target["ID"])),
                false
            );
        }
        return true;
    }
    public static function order($ID, $value, $diff = true, $move = true)
    {
        $elem = $ID > 0 ? self::load($ID, "0,1", NULL, 2.0) : array();
        if (empty($elem))
            exit(ORDERABLE_ELEMENT_NOT_FOUND);
        $elem = $elem[0];
        $current = $elem['order'];
        $next = $diff ? $current + $value : $value;
        if ($next == $current)
            exit(ORDERABLE_ELEMENT_ALREADY_ON_POS);
        $last = self::last();
        $con = new Connector();
        if ($next <= 0 || $next > $last)
            exit(ORDERABLE_ELEMENT_UNAVAILABLE);
        if ($move)
            self::reorder($current, $next);
        else
            $con->query(
                "UPDATE `" . self::$DATABASE . "` SET `order`=? WHERE `order`=? AND `status`!=2",
                array("iii", intval($current), intval($next)),
                false
            );
        $update = $con->query(
            "UPDATE `" . self::$DATABASE . "` SET `order`=? WHERE `ID`=?",
            array("ii", intval($next), intval($ID)),
            false
        );
        if ($update)
            exit(ORDERABLE_ELEMENT_SUCCESS);
        exit(ORDERABLE_ELEMENT_FAILED);
    }
    public static function status($ID, $status = 2)
    {
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `status`=? WHERE `ID`=?",
            array("ii", intval($status) % 3, intval($ID)),
            false
        );
        if ($status == 2) {
            if ($update) {
                return "Horário reservado com sucesso!";
            }
            exit("Erro!");
        }
        return $update;
    }
    public static function toggle($ID)
    {
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `status`=1-`status` WHERE `ID`=? AND `status`<2",
            array("i", intval($ID)),
            false
        );
        if ($update)
            return STATUS_TOGGLED;
        exit(STATUS_TOGGLE_FAILED);
    }
    public static function delete($args, $where = " WHERE `ID`=?")
    {
        $deleted = Connector::newInstance()->delete(self::$DATABASE, $where, $args);
        if (!empty($deleted)) {
            $base = "";
            while (!file_exists($base . "lib"))
                $base .= "../";
            $files = array("");
            foreach ($deleted as $d) {
                foreach ($files as $f) {
                    if ($d['thumb' . $f] != "")
                        File::deleteImages($base, $d['thumb' . $f]);
                }
            }
            self::reorder();
            return true;
        }
        return false;
    }
}
