<?php
include_once("pagseguro/PagSeguroLibrary.php");

class Transaction
{
    private $ID;
    private $pagseguroURL;
    private $status;
    private $payment_status;
    private $customerID;
    private $planID;
    private $cost;
    private $status_date;
    private $registry_date;
    # 19/06/2017
    private $cancel_cause;

    public $PUBLIC_VARS = [
        "ID",
        "pagseguroURL",
        "status",
        "payment_status",
        "customerID",
        "planID",
        "cost",
        "status_date",
        "registry_date",
        "cancel_cause",
    ];
    public static $DATABASE = "transactions";
    public static $PAYMENT_STATUS_LIST = ["pendente", "aprovado", "em disputa", "estornado", "cancelado"];
    public static $SHIP_STATUS_LIST = ["aguardando pagamento", "confirmada", "consulta cancelada"];
    public static $CANCEL_STATUS = 4;
    public static $IGNORED_SHIP_STATUS = -1;

    public function __construct(array $data)
    {
        if (!empty($data)) {
            foreach ($data as $v => $value) {
                if (in_array($v, $this->PUBLIC_VARS)) {
                    $this->{$v} = $value;
                }
            }
        }
    }

    public function get($var)
    {
        return $this->{$var};
    }

    public static function load(
        $ID = -1,
        $limit = null,
        $orderby = null,
        $status = -1,
        $payment_status = -1,
        $customerID = -1,
        $planID = -1
    ) {
        $h = $ID != -1 || $status != -1 || $customerID != -1 || $planID != -1;
        $w = $h ? " WHERE" : "";
        $a = $h ? [""] : null;
        $o = $orderby != null ? " ORDER BY " . $orderby : "";
        $l = $limit != null ? " LIMIT " . $limit : "";
        $n = $query = "";
        if ($ID != -1) {
            $w .= Connector::dataMinning($a, $n, $ID, "`transaction`.`ID`");
        }
        if ($status != -1) {
            $w .= Connector::dataMinning($a, $n, $status, "`transaction`.`status`");
        }
        if ($payment_status != -1) {
            $w .= Connector::dataMinning($a, $n, $payment_status, "`transaction`.`payment_status`");
        }
        if ($customerID != -1) {
            $w .= Connector::dataMinning($a, $n, $customerID, "`transaction`.`customerID`");
        }
        if ($planID != -1) {
            $w .= Connector::dataMinning($a, $n, $planID, "`transaction`.`planID`");
        }
        $obj = new self([]);
        foreach ($obj->PUBLIC_VARS as $i => $v) {
            $query .= ($i > 0 ? ', ' : '') . '`transaction`.`' . $v . '`';
        }
        $obj = new Psychologist([]);
        foreach ($obj->get("PRIVATE_VARS") as $v) {
            $query .= ', `psychologists`.`' . $v . '` AS `psy_' . $v . '`';
        }
        $obj = new Plans([]);
        foreach ($obj->PUBLIC_VARS as $v) {
            $query .= ', `plans`.`' . $v . '` AS `plan_' . $v . '`';
        }
        // exit(var_dump($query));
        return Connector::newInstance()->query(
            "SELECT " . $query . " FROM `" . self::$DATABASE . "` AS `transaction`" .
            " LEFT JOIN `" . Psychologist::$DATABASE . "` AS `psychologists` ON `transaction`.`customerID`=`psychologists`.`ID`" .
            " LEFT JOIN `" . Plans::$DATABASE . "` AS `plans` ON `transaction`.`planID`=`plans`.`ID`" .
            $w . $o . $l, $a
        );
    }

    public static function paginator($status = -1, $payment_status = -1, $customerID = -1, $planID = -1)
    {
        $h = $status != -1 || $customerID != -1 || $planID != -1;
        $w = $h ? " WHERE" : "";
        $a = $h ? [""] : null;
        $n = "";
        if ($status != -1) {
            $w .= Connector::dataMinning($a, $n, $status, "`transaction`.`status`");
        }
        if ($payment_status != -1) {
            $w .= Connector::dataMinning($a, $n, $payment_status, "`transaction`.`payment_status`");
        }

        if ($customerID != -1) {
            $w .= Connector::dataMinning($a, $n, $customerID, "`transaction`.`customerID`");
        }
        if ($planID != -1) {
            $w .= Connector::dataMinning($a, $n, $planID, "`transaction`.`planID`");
        }
        $v = Connector::newInstance()->query(
            "SELECT COUNT(`transaction`.`ID`) AS `count` FROM `" . self::$DATABASE . "` AS `transaction`" .
            $w, $a
        );
        return empty($v) ? 0 : intval($v[0]['count']);
    }

    public static function create($customerID, $planID, $payment_status = 0, $status = 1)
    {
        $customer = $customerID > 0 ? Psychologist::load($customerID, "0,1", null, null, false, -1) : [];

        if (empty($customer)) {
            return "Dados do psicólogo não encontrados. Por favor, tente novamente.";
        }
        $customer = $customer[0];
        $plan = Plans::load($planID);
        $cost = $plan[0]['price'];
        $con = new Connector();
        $insert = $con->query(
            "INSERT INTO `" . self::$DATABASE . "` (`cost`, `customerID`, `planID`, `payment_status`, `status`, `status_date`) VALUES (?, ?, ?, ?, ?, NOW())",
            [
                "diiii",
                floatval($cost),
                intval($customerID),
                intval($planID),
                intval($payment_status),
                intval($status) % 2,
            ],
            false
        );
        if ($insert) {
            $values = $con->query(
                "SELECT * FROM `" . self::$DATABASE . "` WHERE `customerID`=? AND `planID`=? ORDER BY `registry_date` DESC LIMIT 0,1",
                ["ii", intval($customerID), intval($planID)]
            );
            if (!empty($values)) {
                $ID = $values[0]['ID'];
                $pagseguroURL = self::set_on_pagseguro($values[0]);
                if ($pagseguroURL === null) {
                    $con->query(
                        "UPDATE `" . self::$DATABASE . "` SET `status`=2, `status_date`=NOW() WHERE `ID`=?",
                        ["i", intval($ID)],
                        false
                    );
                    return "Ocorreu uma falha inesperada ao tentar registrar esta transação no PagSeguro. Por favor, tente novamente em alguns insitantes.";
                }
                $con->query(
                    "UPDATE `" . self::$DATABASE . "` SET `pagseguroURL`=? WHERE `ID`=?",
                    ["si", $pagseguroURL . "", intval($ID)],
                    false
                );
                return ["URL" => $pagseguroURL, "transactionID" => $ID, "status" => 1];
            }
        }
        return "Ocorreu uma falha inesperada ao tentar finalizar o seu carrinho. Por favor, tente novamente mais tarde.";
    }

    public static function teste()
    {
        $request = new PagSeguroPaymentRequest();
        return $request;
    }

    public static function set_on_pagseguro(array $elem)
    {
        $buyer = Psychologist::load($elem['customerID']);
        $plan = Plans::load($elem['planID']);
        // exit(var_dump($plan[0]['title']));
        if ($elem['pagseguroURL'] == "") {
            $request = new PagSeguroPaymentRequest();
            $request->addItem(
                $plan[0]['ID'],
                $plan[0]['title'],
                1,
                $plan[0]['price']
            );
        }
        $request->setSender(
            $buyer[0]['name'],
            $buyer[0]['mail'],
            null,
            null,
            'CPF',
            $buyer[0]['cpf']
        );

        $request->setCurrency('BRL');
        $request->setReference("REF" . $elem['ID']);
        $request->setRedirectUrl(PUBLIC_URL);
        $request->addParameter('notificationURL',
            PUBLIC_URL . 'transaction-notify.php?ID=' . $elem['ID'] . '&pID=' . $elem['planID'] . '&uID=' . $elem['customerID']);
        // $request->addParameter('notificationURL', PUBLIC_URL.'transaction-notify.php?ID='.$elem['ID'].'&cID='.$elem['planID'].'&uID='.$elem['customerID']);
        $checkoutURL = null;
        try {
            $credentials = PagSeguroConfig::getAccountCredentials();
            $checkoutURL = $request->register($credentials);
            // exit(var_dump($checkoutURL));
            $subject = 'Compra do plano HELP!';
            $content = '<p><h1 style="text-align: center;">Solicitação do plano' . $plan[0]['title'] . '</h1></p><table>';
            $content .= '<tr><th>Plano/th><th>Valor</th><th>Total</th></tr><tr><td style="text-align: right">' . Format::toMoney($plan[0]['price']) . '</td></tr><tr><th colspan="3" style="text-align: right">TOTAL</th><td style="text-align: right">' . Format::toMoney($plan[0]['price']) . '</td></tr>';
            $content .= '</table>';
            $content .= '</p>';
            $content .= '<p><h1 style="text-align: center;"><a href="' . $checkoutURL . '" target="_blank">CLIQUE AQUI PARA IR À PÁGINA DE PAGAMENTO</a></h1></p><p>Caso o pedido já esteja pago, este e-mail tem apenas caráter informativo.</p><br/><p>Att.,<br/>HELP Terapia Online</p>';
            Newsletter::send($subject, $content, 'adrichard14@hotmail.com');
        } catch (PagSeguroServiceException $e) {
            var_dump($e->getMessage());
        }
        // exit(var_dump($checkoutURL));
        return $checkoutURL;

        //update current token
        return $elem['pagseguroURL'];
    }

    public static function update_status($ID, $payment_status, $cancel_cause = "")
    {
        $elem = $ID > 0 ? self::load($ID, "0,1", null, 2.0) : [];
        if (empty($elem)) {
            exit("Pedido não encontrado.");
        }
        $elem = $elem[0];
        if (($payment_status == self::$CANCEL_STATUS || $ship_status == self::$CANCEL_STATUS) && strip_tags($cancel_cause) == "") {
            exit("Digite o motivo do cancelamento.");
        }
        $cancel_cause = Format::HTML($cancel_cause);
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `cancel_cause`=?, `payment_status`=?, `status_date`=NOW() WHERE `ID`=? AND `status`=1",
            ["sii", $cancel_cause . "", intval($payment_status), intval($ID)],
            false
        );
        if ($update) {
            $elem['payment_status'] = $payment_status;
            self::notify_status($elem);
            exit(Display::Message("sc", "Status de transação atualizado com sucesso."));
        }
        exit("Ocorreu uma falha inesperada ao tentar atualizar o status desta transação.");
    }

    public static function notify_status(array $elem)
    {
        $email = strtolower($elem['customer_email']);
        if (Format::isMail($email)) {
            $name = $elem['customer_first_name'];
            $subject = "Status de pedido atualizado";
            $content = "<p>Caro(a) <strong>" . $name . "</strong>,<br/>alteramos o status do pedido #" . $elem['ID'] . ". Veja abaixo as novas informações.</p>";
            $content .= "<p><strong>Status de pagamento:</strong> " . self::$PAYMENT_STATUS_LIST[$elem['payment_status']] . "<br/><strong>Status de entrega:</strong> " . "</p>";
            if (($elem['payment_status'] == self::$CANCEL_STATUS) && strip_tags($elem['cancel_cause']) != "") {
                $content .= "<p><strong>Motivo do cancelamento:</strong></p>" . $elem['cancel_cause'];
            }
            $content .= "<br/><p>Att.,<br/>Pandoro Aracaju</p>";
            Newsletter::send($subject, $content, $name . ' <' . $email . '>');
        }
    }

    public static function status($ID, $status = 2)
    {
        $update = Connector::newInstance()->query(
            "UPDATE `" . self::$DATABASE . "` SET `status`=?, `status_date`=NOW() WHERE `ID`=?",
            ["ii", intval($status) % 3, intval($ID)],
            false
        );
        if ($status == 2) {
            if ($update) {
                exit(Display::Message("sc", "Transação excluída com sucesso."));
            }
            exit("Ocorreu uma falha inesperada ao tentar excluir essa transação.");
        }
    }

    public static function delete($args, $where = " WHERE `ID`=?")
    {
        return Connector::newInstance()->delete(self::$DATABASE, $where, $args, false);
    }

    /**
     * @param PagseguroWebhookHandler $handler
     * @return int
     */
    public static function convertWebhookStatus($handler)
    {
        if ($handler->isPaymentDone() || $handler->isPaymentAvailable()) {
            return TransactionStatusEnum::PAID;
        } elseif ($handler->isPaymentCancelled() || $handler->isPaymentRefunded()) {
            return TransactionStatusEnum::CANCELLED;
        } elseif ($handler->isPaymentInDispute()) {
            return TransactionStatusEnum::IN_DISPUTE;
        }
        return TransactionStatusEnum::PENDING;
    }

    /**
     * @param PagseguroWebhookHandler $handler
     * @return string
     */
    public static function getWebhookCancelCause($handler)
    {
        if ($handler->isPaymentCancelled()) {
            return "Entrega cancelada devido ao cancelamento do pagamento.";
        } elseif ($handler->isPaymentRefunded()) {
            return "Entrega cancelada devido à devolução do pagamento.";
        }
        return "";
    }
}
