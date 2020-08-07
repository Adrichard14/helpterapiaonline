<?php
include_once("pagseguro/PagSeguroLibrary.php");

class TransactionAppointment
{
    private $ID;
    private $pagseguroURL;
    private $status;
    private $payment_status;
    private $clientID;
    private $eventID;
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
        "clientID",
        "eventID",
        "cost",
        "status_date",
        "registry_date",
        "cancel_cause",
    ];
    public static $DATABASE = "transactions_appointment";
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
        $clientID = -1,
        $eventID = -1
    ) {
        $h = $ID != -1 || $status != -1 || $clientID != -1 || $eventID != -1;
        $w = $h ? " WHERE" : "";
        $a = $h ? [""] : null;
        $o = $orderby != null ? " ORDER BY " . $orderby : "";
        $l = $limit != null ? " LIMIT " . $limit : "";
        $n = $query = "";
        if ($ID != -1) {
            $w .= Connector::dataMinning($a, $n, $ID, "`transaction_appointment`.`ID`");
        }
        if ($status != -1) {
            $w .= Connector::dataMinning($a, $n, $status, "`transaction_appointment`.`status`");
        }
        if ($payment_status != -1) {
            $w .= Connector::dataMinning($a, $n, $payment_status, "`transaction_appointment`.`payment_status`");
        }
        if ($clientID != -1) {
            $w .= Connector::dataMinning($a, $n, $clientID, "`transaction_appointment`.`clientID`");
        }
        if ($eventID != -1) {
            $w .= Connector::dataMinning($a, $n, $eventID, "`transaction_appointment`.`eventID`");
        }
        $obj = new self([]);
        foreach ($obj->PUBLIC_VARS as $i => $v) {
            $query .= ($i > 0 ? ', ' : '') . '`transaction_appointment`.`' . $v . '`';
        }
        $obj = new Client([]);
        foreach ($obj->get("PRIVATE_VARS") as $v) {
            $query .= ', `clients`.`' . $v . '` AS `client_' . $v . '`';
        }
        $obj = new WorkEvents([]);
        foreach ($obj->PUBLIC_VARS as $v) {
            $query .= ', `event`.`' . $v . '` AS `event_' . $v . '`';
        }
        // exit(var_dump($query));
        return Connector::newInstance()->query(
            "SELECT " . $query . " FROM `" . self::$DATABASE . "` AS `transaction_appointment`" .
            " LEFT JOIN `" . Client::$DATABASE . "` AS `clients` ON `transaction_appointment`.`clientID`=`clients`.`ID`" .
            " LEFT JOIN `" . WorkEvents::$DATABASE . "` AS `event` ON `transaction_appointment`.`eventID`=`event`.`ID`" .
            $w . $o . $l, $a
        );
    }

    public static function paginator($status = -1, $payment_status = -1, $clientID = -1, $eventID = -1)
    {
        $h = $status != -1 || $clientID != -1 || $eventID != -1;
        $w = $h ? " WHERE" : "";
        $a = $h ? [""] : null;
        $n = "";
        if ($status != -1) {
            $w .= Connector::dataMinning($a, $n, $status, "`transaction_appointment`.`status`");
        }
        if ($payment_status != -1) {
            $w .= Connector::dataMinning($a, $n, $payment_status, "`transaction_appointment`.`payment_status`");
        }

        if ($clientID != -1) {
            $w .= Connector::dataMinning($a, $n, $clientID, "`transaction_appointment`.`clientID`");
        }
        if ($eventID != -1) {
            $w .= Connector::dataMinning($a, $n, $eventID, "`transaction_appointment`.`eventID`");
        }
        $v = Connector::newInstance()->query(
            "SELECT COUNT(`transaction_appointment`.`ID`) AS `count` FROM `" . self::$DATABASE . "` AS `transaction_appointment`" .
            $w, $a
        );
        return empty($v) ? 0 : intval($v[0]['count']);
    }

    public static function create($clientID, $eventID, $payment_status = 0, $status = 1)
    {
        $client = $clientID > 0 ? Client::load($clientID, "0,1", null, null, false, -1) : [];

        if (empty($client)) {
            return "Dados do psicólogo não encontrados. Por favor, tente novamente.";
        }
        $client = $client[0];
        $evento = WorkEvents::load($eventID);
        $evento = $evento[0];
        $psychologist = Psychologist::load($evento['workerID']);
        $psychologist = $psychologist[0];
        $cost = $psychologist['valor_consulta'];
        $con = new Connector();
        $insert = $con->query(
            "INSERT INTO `" . self::$DATABASE . "` (`cost`, `clientID`, `eventID`, `payment_status`, `status`, `status_date`) VALUES (?, ?, ?, ?, ?, NOW())",
            [
                "diiii",
                floatval($cost),
                intval($clientID),
                intval($eventID),
                intval($payment_status),
                intval($status) % 2,
            ],
            false
        );
        if ($insert) {
            $values = $con->query(
                "SELECT * FROM `" . self::$DATABASE . "` WHERE `clientID`=? AND `eventID`=? ORDER BY `registry_date` DESC LIMIT 0,1",
                ["ii", intval($clientID), intval($eventID)]
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
        $buyer = Client::load($elem['clientID']);
        $event = WorkEvents::load($elem['eventID']);
        $psicologo = Psychologist::load($event[0]['workerID']);
        $psicologo = $psicologo[0];
        if ($elem['pagseguroURL'] == "") {
            $request = new PagSeguroPaymentRequest();
            $request->addItem(
                $event[0]['ID'],
                'Consulta #' . $event[0]['ID'],
                1,
                $psicologo['valor_consulta']
            );
        }
        $request->setSender(
            $buyer[0]['name'],
            $buyer[0]['mail'],
            '79',
            '998187587',
            'CPF',
            $buyer[0]['cpf']
        );

        $request->setCurrency('BRL');
        $request->setReference("REF" . $elem['ID'] . "_EVENT");
        $request->setRedirectUrl(PUBLIC_URL);
        $request->addParameter(
            'notificationURL',
            PUBLIC_URL . 'transaction-notify-appointment.php?transactionId=' . $elem['ID'] . '&eventId=' . $elem['eventID'] . '&clientId=' . $elem['clientID']
        );
        $checkoutURL = null;
        try {
            $credentials = new PagSeguroAccountCredentials(
                PAGSEGURO_TRANSACTION_APPOINTMENT_EMAIL,
                PAGSEGURO_TRANSACTION_APPOINTMENT_TOKEN
            );
            $checkoutURL = $request->register($credentials);
            $subject = 'Compra do plano HELP!';
            $content = '<p><h1 style="text-align: center;">Solicitação de consulta com o psicólogo' . $psicologo['name'] . '</h1></p><table style="width: 100%;margin-bottom: 1rem;color: #212529;>';
            $content .= '<tbody>
                                        <tr style="border: 1px solid #000000; color: #fff; background-color: #383838;">
                                            <th>Hora</th>
                                            <th>Data</th>
                                            <th>Psicólogo</th>
                                            <th>Valor</th>
                                        </tr>
                                        <tr style="border: 1px solid #000000;">
                                            <td>' . $event[0]['hour'] . '</td>
                                            <td>' . $event[0]['date'] . '</td>
                                            <td>' . $psicologo['name'] . '</td>
                                            <td>' . $psicologo['valor_consulta'] . '</td>
                                        </tr>
                                    </tbody>';
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
            $content .= "<br/><p>Att.,<br/>Help Terapia Online</p>";
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
     * @param PagSeguroWebhookHandler $handler
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
     * @param PagSeguroWebhookHandler $handler
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
