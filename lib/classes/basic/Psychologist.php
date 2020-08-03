<?php
class Psychologist
{
    private $ID;
    private $login;
    private $password;
    private $name;
    private $nickname;
    private $mail;
    private $access_token;
    private $recovery_token;
    private $recovery_validation;
    private $registry_date;
    private $status;
    private $genero;
    private $data_nasc;
    private $telefone;
    private $cpf;
    private $crp;
    private $e_psi;
    private $formacao;
    private $instituicao;
    private $curso;
    private $ano_inicio;
    private $ano_conclusao;
    private $mini_curriculo;
    private $abordagens_principais;
    private $abordagens_secundarias;
    private $especialidades;
    private $acao_etica;
    private $plano;
    private $thumb;
    private $valor_consulta;
    private $tipo;
    private $idiomas;
    private $plan_date_expire;
    private $active_plan;
    private $PRIVATE_VARS = array('ID', 'login', 'password', 'name', 'nickname', 'mail', 'access_token', 'recovery_token', 'recovery_validation', 'registry_date');
    public $PUBLIC_VARS = array('ID', 'name', 'nickname', 'access_token', 'status', 'genero', 'data_nasc', 'telefone', 'cpf', 'crp', 'e_psi', 'formacao', 'instituicao', 'curso', 'ano_inicio', 'ano_conclusao', 'mini_curriculo', 'abordagens_principais', 'abordagens_secundarias', 'especialidades', 'acao_etica', 'plano', 'thumb', 'valor_consulta', 'tipo', 'idiomas');
    public static $ABSOLUTE_USERS   = array(1, 2);
    public static $DATABASE         = "psychologists";
    public static $SESSION          = "l@#$@e@#r2";
    public static $FOLDER           = "uploads/psicologos";
    public static $RESOLUTIONS          = array(400, 400);

    public function __construct(array $vars)
    {
        if (!empty($vars))
            foreach ($vars as $v => $value)
                if (in_array($v, $this->PRIVATE_VARS))
                    $this->{$v} = $value;
    }
    public function get($var)
    {
        return $this->{$var};
    }

    private static function prepareSearch(&$w, &$a, $ID, $limit, $orderby, $search, $equal, $status, $tipo, $especialidades)
    {
        $h = $ID != -1 || $search != NULL || $status != -1 || $tipo != NULL || $especialidades != NULL;
        $w = $h ? " WHERE" : "";
        $a = $h ? array("") : NULL;
        $o = $orderby != NULL ? " ORDER BY " . $orderby : "";
        $l = $limit != NULL ? " LIMIT " . $limit : "";
        if ($status != -1)
            $w .= Connector::dataMinning($a, $n, $status, "`status`");
        if ($tipo != NULL)
            $w .= Connector::dataMinning($a, $n, $tipo, "`tipo`");
        if ($especialidades != NULL)
            $w .= Connector::dataMinning($a, $n, $especialidades, "`especialidades`");
        $n = "";
        $pairs = array(
            array($ID, "`ID`"),
            array($search, array("`login`", "`name`", "`nickname`"), NULL, $equal ? "str" : "strike")
        );
        $w .= Connector::getData($a, $n, $pairs) . $o . $l;
    }
    public static function load($ID = -1, $limit = NULL, $orderby = "name ASC", $search = NULL, $equal = false, $status = -1, $tipo = NULL, $especialidades = NULL)
    {
        $w = $a = NULL;
        self::prepareSearch($w, $a, $ID, $limit, $orderby, $search, $equal, $status, $tipo, $especialidades);
        return Connector::newInstance()->query("SELECT * FROM `" . self::$DATABASE . "`" . $w, $a);
    }
    public static function paginator($search = NULL, $equal = false)
    {
        $w = $a = NULL;
        self::prepareSearch($w, $a, -1, NULL, NULL, $search, $equal, -1, NULL, NULL);
        $v = Connector::newInstance()->query("SELECT COUNT(`ID`) AS `count` FROM `" . self::$DATABASE . "`" . $w, $a);
        return empty($v) ? 0 : intval($v[0]['count']);
    }

    public static function create($login, $password, $password2, $name, $nickname, $mail, $status, $genero, $data_nasc, $telefone, $cpf, $crp, $e_psi, $formacao, $instituicao, $curso, $ano_inicio, $ano_conclusao, $mini_curriculo, $abordagens_principais, $abordagens_secundarias, $especialidades, $acao_etica, $plano, $thumb, $valor_consulta, $tipo, $idiomas)
    {
        // if (!Format::isLogin($login))
        //     exit(INVALID_LOGIN);
        if (!Format::isPassword($password))
            exit(INVALID_PASSWORD);
        if ($password !== $password2)
            exit(PASSWORDS_NOT_EQUAL);
        if ($name == NULL)
            exit(INVALID_NAME);
        $mail = strtolower($mail);
        if (!Format::isMail($mail))
            exit(INVALID_EMAIL);
        $con = new Connector();
        $values = $con->query(
            "SELECT * FROM `" . self::$DATABASE . "` WHERE mail=?",
            array("s", $mail . "")
        );
        if (!empty($values)) {
            exit('Esse e-mail já está sendo utilizado, por favor digite outro e-mail!');
        }
        if($status == NULL){
            $status = 1;
        }
        $password = self::encrypt($password);
        if ($con->query(
            "INSERT INTO `" . self::$DATABASE . "` (login, password, name, nickname, `mail`, status, genero, data_nasc, telefone, cpf, crp, e_psi, formacao, instituicao, curso, ano_inicio, ano_conclusao, mini_curriculo, abordagens_principais, abordagens_secundarias, especialidades, acao_etica, plano, thumb, valor_consulta, tipo, idiomas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            array("sssssisssssssssssssssssssss", $login . "", $password . "", $name . "", $nickname . "", $mail . "", intval($status), $genero . "", $data_nasc . "", $telefone. "", $cpf . "", $crp . "", $e_psi . "", $formacao . "", $instituicao . "", $curso . "", $ano_inicio . "", $ano_conclusao . "", $mini_curriculo . "", $abordagens_principais . "", $abordagens_secundarias . "", $especialidades . "", $acao_etica . "", $plano . "", $thumb . "", $valor_consulta . "", $tipo . "", $idiomas . ""),
            false
        )) {
            $u = $con->query(
                "SELECT ID FROM `" . self::$DATABASE . "` WHERE login=?",
                array("s", $login . "")
            );
            return $u[0]["ID"];
        }
        return false;
    }

    public static function update($ID, $login, $password, $password2, $name, $nickname, $mail, $status, $genero, $data_nasc, $telefone, $cpf, $crp, $e_psi, $formacao, $instituicao, $curso, $ano_inicio, $ano_conclusao, $mini_curriculo, $abordagens_principais, $abordagens_secundarias, $especialidades, $acao_etica, $plano, $thumb, $valor_consulta, $tipo, $idiomas)
    {
        if (!isset($_SESSION)) session_start();
        $session = $ID == $_SESSION[self::$SESSION]["ID"];
        // if (!Format::isLogin($login))
        //     exit(INVALID_LOGIN);
        if ($name == NULL)
            exit(INVALID_NAME);
        // if ($nickname == NULL)
        //     exit(INVALID_NICKNAME);
        $mail = strtolower($mail);
        if (!Format::isMail($mail))
            exit(INVALID_EMAIL);
        $con = new Connector();
        $values = $con->query(
            "SELECT `ID`, `mail` FROM `" . self::$DATABASE . "` WHERE `ID`!=? AND mail=?",
            array("is", intval($ID), $mail . "")
        );
        if (!empty($values)) {
            if ($values[0]['mail'] == $mail)
                exit(USER_LOGIN_ALREADY_EXISTS);
            exit(USER_NICKNAME_ALREADY_EXISTS);
        }
        $set = " SET login=?, name=?, nickname=?, `mail`=?, `status`=?, `genero`=?, `data_nasc`=?, `telefone`=?, `cpf`=?, `crp`=?, `e_psi`=?, `formacao`=?, `instituicao`=?, `curso`=?, `ano_inicio`=?, `ano_conclusao`=?, `mini_curriculo`=?, `abordagens_principais`=?, `abordagens_secundarias`=?, `especialidades`=?, `acao_etica`=?, `plano`=?, `thumb`=?, `valor_consulta`=?, `tipo`=?, `idiomas`=?";
        $args = array("ssssisssssssssssssssssssss", $login . "", $name . "", $nickname . "", $mail . "", intval($status), $genero . "", $data_nasc . "", $telefone . "", $cpf . "", $crp . "", $e_psi . "", $formacao . "", $instituicao . "", $curso . "", $ano_inicio . "", $ano_conclusao . "", $mini_curriculo . "", $abordagens_principais . "", $abordagens_secundarias . "", $especialidades . "", $acao_etica . "", $plano . "", $thumb . "", $valor_consulta . "", $tipo . "", $idiomas . "");
        if ($password != "") {
            if (!Format::isPassword($password))
                exit(INVALID_PASSWORD);
            if ($password !== $password2)
                exit(PASSWORDS_NOT_EQUAL);
            $password = self::encrypt($password);
            $set .= ", password=?";
            $args[0] .= "s";
            $args[] = $password . "";
        }
        $set .= " WHERE ID=?";
        $args[0] .= "i";
        $args[] = intval($ID);
        if ($con->query(
            "UPDATE `" . self::$DATABASE . "`" . $set,
            $args,
            false
        )) {
            if ($session) self::updateSession();
            return true;
        }
        return false;
    }
    public static function setActivePlan($ID, $planID){
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `active_plan`=? WHERE `ID`=?",
            array("ii", intval($planID), intval($ID)),
            false
        );
        if($update){
            return "Plano ativado com sucesso";
        }
        return $update;
    }
    public static function setExpirePlanDate($plan_date_expire, $ID){    
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `plan_date_expire`=? WHERE `ID`=?",
            array("si", $plan_date_expire, intval($ID)),
            false
        );
            return "Expire date sucesseful updated";
    }
    public static function aprove($ID, $status = 1)
    {
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `status`=? WHERE `ID`=?",
            array("ii", intval($status) % 3, intval($ID)),
            false
        );
        if ($status == 1) {
            if ($update) {
                return "Usuário aprovado com sucesso!";
            }
            exit("Ocorreu um erro ao aprovar o usuário.");
        }
        return $update;
    }
    public static function delete($args, $where = " WHERE ID=?")
    {
        $deleted = Connector::newInstance()->delete(self::$DATABASE, $where, $args);
        if (!empty($deleted)) {
            foreach ($deleted as $u) {
                if ($u["ID"] == $_SESSION[self::$SESSION]["ID"]) unset($_SESSION[self::$SESSION]["ID"]);
            }
            return true;
        }
        return false;
    }

    public static function restrict($absolute = false)
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION[self::$SESSION])) return false;
        $user = self::load($_SESSION[self::$SESSION]["ID"]);
        $base = "";
        while (!file_exists($base . "lib")) $base .= "../";
        if (empty($user) || $_SESSION[self::$SESSION]['access_token'] != $user[0]["access_token"]) {
            Display::Message("err", USER_SESSION_VALIDATION_ERROR);
            unset($_SESSION[self::$SESSION]);
            header("location: " . $base . "in/login.php");
            exit();
        }
        //            if($absolute && !in_array($user[0]['ID'], self::$ABSOLUTE_USERS)) {
        //				header("location: ".$base."admin/index.php");
        //				exit();
        //            }
        return true;
    }

    public static function generate_recovery_token($mail)
    {
        if (!Format::isMail($mail))
            exit("Isto não é um e-mail válido.");
        $con = new Connector();
        $values = $con->query(
            "SELECT `ID`, `recovery_token`, `recovery_validation`, `mail` FROM `" . self::$DATABASE . "` WHERE `mail`=?",
            array("s", $mail . "")
        );
        if (!empty($values)) {
            $elem = $values[0];
            if (!Format::isMail($elem['mail']))
                exit("Sentimos muito, mas você não tem um e-mail válido cadastrado em sua conta e, portanto, não temos como enviar uma chave de recuperação. Por favor, peça que outro administrador mude a sua senha manualmente.");
            $now = date("Y-m-d H:i:s");
            $ndate = Format::date_to_seconds($now);
            if ($elem['recovery_token'] != "" && Format::date_to_seconds($elem['recovery_validation']) < $ndate)
                exit("Você já tem uma chave de recuperação ativa. Se ainda não o recebeu em seu e-mail, aguarde mais um pouco. A mensagem também pode estar na sua caixa anti-SPAM. A chave expirará em " . Format::toDateTime($elem['recovery_validation']));
            $recovery_token = sha1(rand(10000, 99999) . date('Ymd') . time());
            $recovery_validation = date("Y-m-d H:i:s", strtotime($now . " +4hours"));
            $update = $con->query(
                "UPDATE `" . self::$DATABASE . "` SET `recovery_token`=?, `recovery_validation`=? WHERE `ID`=?",
                array("ssi", $recovery_token . "", $recovery_validation . "", intval($elem['ID'])),
                false
            );
            $subject = "Recuperação de senha";
            $rURL = PUBLIC_URL . "nova-senha-psicologo";
            $content = "<p>Foi-nos solicitado uma chave de recuperação de senha. Se você não fez essa solicitação, <strong>desconsidere esse e-mail</strong>.</p><p>Segue a chave de recuperação para a conta <strong>" . $elem['mail'] . "</strong>:</p><h1 style='text-align: center; width: 100%;'>" . $recovery_token . "</h1><p>Para continuar o procedimento, acesse o link abaixo e informe seu e-mail e chave de recuperação:</p><a href='" . $rURL . "' target='_blank' style='text-align: center; width: 100%;'>" . $rURL . "</a><p>Sua chave de recuperação será válida até " . Format::toDateTime($recovery_validation) . ".</p>";
            Newsletter::send($subject, $content, $elem['mail']);
            exit("Enviamos um e-mail para seu e-mail de recuperação. Copie a chave, acesse o link na mensagem e cole no devido campo para que possa gerar uma nova senha.");
        }
        exit("Nenhuma conta encontrada com esse e-mail");
    }
    public static function verify_recovery_token($mail, $recovery_token)
    {
        if (!Format::isMail($mail))
            exit(INVALID_LOGIN);
        $con = new Connector();
        $values = $con->query(
            "SELECT `ID` FROM `" . self::$DATABASE . "` WHERE `mail`=? AND `recovery_token`=? AND `recovery_validation`>NOW()",
            array("ss", $mail . "", $recovery_token . "")
        );
        if (empty($values))
            exit(USER_RECOVERY_NOT_FOUND);
        if (!isset($_SESSION))
            session_start();
        $_SESSION['urecover'] = array($mail, $recovery_token);
        return true;
    }
    public static function recovery($password, $password2)
    {
        if (!isset($_SESSION))
            session_start();
        if (!isset($_SESSION['urecover']) || sizeof($_SESSION['urecover']) != 2)
            exit(USER_RECOVERY_CORRUPTED);
        list($mail, $recovery_token) = $_SESSION['urecover'];
        if (!Format::isPassword($password))
            exit(INVALID_PASSWORD);
        if ($password !== $password2)
            exit(PASSWORDS_NOT_EQUAL);
        $password = self::encrypt($password);
        $con = new Connector();
        $values = $con->query(
            "SELECT `ID` FROM `" . self::$DATABASE . "` WHERE `mail`=? AND `recovery_token`=? AND `recovery_validation`>NOW()",
            array("ss", $mail . "", $recovery_token . "")
        );
        if (empty($values))
            exit(USER_RECOVERY_FORM_CORRUPTED);
        $update = $con->query(
            "UPDATE `" . self::$DATABASE . "` SET `password`=?, `recovery_token`='' WHERE `ID`=?",
            array("si", $password . "", intval($values[0]['ID'])),
            false
        );
        if ($update) {
            unset($_SESSION['urecover']);
            exit(Display::Message("sc", USER_RECOVERY_SUCCESS));
        }
        exit(USER_RECOVERY_FAILED);
    }

    public static function updateSession($u = NULL)
    {
        isset($_SESSION) or session_start();
        if (is_int($u)) {
            $us = self::load($u);
            if (empty($us))
                exit(SESSION_UPDATE_FAILED);
            $u = new self($us[0]);
        } else if (is_array($u))
            $u = new self($u);
        else if ($u == NULL && isset($_SESSION[self::$SESSION])) {
            $us = self::load($_SESSION[self::$SESSION]["ID"]);
            if (empty($us))
                exit(SESSION_UPDATE_FAILED);
            $u = new self($us[0]);
        } else
            exit(INVALID_FORMAT);
        $_SESSION[self::$SESSION] = Format::toArray($u);
    }

    public static function encrypt($p)
    {
        return hash("sha384", "#@@a23%%4V3%%4" . $p . "_#%@%$5X3%") . ":" . substr(sha1($p), 0, 5);
    }
    public static function token()
    {
        return sha1(rand(100000, 999999) . date('Ymd') . time());
    }

    public static function confirmPassword($ID, $password)
    {
        $password = self::encrypt($password);
        $u = Connector::newInstance()->query(
            "SELECT ID FROM `" . self::$DATABASE . "` WHERE ID=? AND password=?",
            array("is", intval($ID), $password . "")
        );
        return !empty($u);
    }
    public static function validate($ID){
        $ID = 1;
        $con = new Connector();
        $con->query(
            "UPDATE `" . self::$DATABASE . "` SET ID=? ",
            array("i", intval($ID)),
            false
        );

    }
    public static function login($email, $password)
    {
        $con = new Connector();
        if (!Format::isMail($email))
            exit(INVALID_LOGIN);
        $password = self::encrypt($password);
        $u = $con->query(
            "SELECT * FROM `" . self::$DATABASE . "` WHERE mail=? AND password=?",
            array("ss", $email . "", $password . "")
        );
        if (empty($u)) exit('Login e/ou senha incorreto(s).');
        $u = $u[0];
        if($u['status'] != 1){
            session_destroy();
            session_unset();
            exit('Cadastro em analise');
        }
        $access_token = self::token();
        $u["access_token"] = $access_token;
        self::updateSession($u); //showing PUBLIC_VARS only
        $con->query(
            "UPDATE `" . self::$DATABASE . "` SET access_token=? WHERE ID=?",
            array("si", $access_token . "", intval($u["ID"])),
            false
        );
        return true;
    }
    public static function busca($name, $tipo, $especi)
    {
       
        $values = array();
        $array = Connector::newInstance()->query(
            "SELECT * FROM `" . self::$DATABASE . "` WHERE  `name` LIKE ? OR `tipo` LIKE ? OR `especialidades` LIKE ? ORDER BY `name` ASC",
            array("sss", $name, $tipo, $especi)
        );
        $values = $values + $array;

        return $values;
    }
}
