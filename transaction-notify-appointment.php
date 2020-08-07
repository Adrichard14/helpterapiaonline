<?php
require_once("lib/classes/Package.php");
new Package();

$handler = new PagSeguroWebhookHandler(
    PAGSEGURO_TRANSACTION_APPOINTMENT_EMAIL,
    PAGSEGURO_TRANSACTION_APPOINTMENT_TOKEN
);
$handler->setSupportEmail("adrichard14@hotmail.com");
try {
    $handler->load();

    $ID = intval(GET::transactionId());
    $eventId = intval(GET::eventId());
    $clientId = intval(GET::clientId());

    if ($ID <= 0 || $eventId <= 0 || $clientId <= 0) {
        throw new Exception("Dados de entrada inválidos.");
    }

    $transaction = TransactionAppointment::load($ID, "0,1", null, 2.0, -1, $clientId, $eventId);
    if (empty($transaction)) {
        throw new Exception("Transação não encontrada.");
    }
    $event = WorkEvents::load($eventId);
    if (empty($event)) {
        throw new Exception("Agendamento não encontrado.");
    }
    $psychologist = Psychologist::load($event['workerID']);
    if (empty($psychologist)) {
        throw new Exception("Psicólogo não encontrado.");
    }
    $client = Client::load($clientId);
    if (empty($client)) {
        throw new Exception("Cliente não encontrado.");
    }
    $transaction = $transaction[0];
    $event = $event[0];
    $client = $client[0];
    $psychologist = $psychologist[0];

    if ($handler->getReference() !== "REF{$transaction["ID"]}_EVENT") {
        throw new Exception("A referência da transação é diferente da referência da notificação do PagSeguro.");
    }

    $transaction["cancel_cause"] = TransactionAppointment::getWebhookCancelCause($handler);
    $newStatus = TransactionAppointment::convertWebhookStatus($handler);

    if ($newStatus === $transaction["status"]) {
        // nenhuma alteração necessária
        exit;
    }

    $transaction["status"] = $newStatus;

    $update = Connector::newInstance()->query(
        "UPDATE `" . TransactionAppointment::$DATABASE . "`
        SET
            `cancel_cause`='{$transaction["cancel_cause"]}',
            `payment_status`={$transaction["status"]},
            `status_date`=NOW()
        WHERE `ID`={$transaction['ID']}",
        null,
        false
    );

    if (!$update) {
        throw new Exception("Ocorreu uma falha durante a ativação da transação #{$transaction["ID"]} no banco de dados");
    } elseif ($transaction["status"] !== TransactionStatusEnum::PAID) {
        // não é uma ativação, logo pode ser encerrado aqui
        exit;
    }
    // ativação de compra
    $url = PUBLIC_URL;
    Newsletter::send(
        "Parabéns, {$client['name']}!",
        "<p>O pagamento da sua consulta com o psicólogo <strong>{$psychologist['name']}</strong>, no dia <strong>{$event['date']}</strong> às {$event['hour']} foi aprovado!</p></br><h5>Acesse: <a href='$url' target='_blank'>$url</a> e faça o seu login!</h5>",
        $client['mail']
    );
    Newsletter::send(
        "Agendamento confirmado",
        "<p>O pagamento da sua consulta com o cliente <strong>{$client['name']}</strong>, no dia <strong>{$event['date']}</strong> às {$event['hour']} foi aprovado!</p></br><h5>Acesse: <a href='$url' target='_blank'>$url</a> e faça o seu login!</h5>",
        $psychologist['mail']
    );
} catch (Exception $exception) {
    $handler->sendSupportEmail(PUBLIC_URL . " - Erro no gatilho de planos",
        "Ocorreu um erro durante o recebimento do gatilho {$handler->getNotificationCode()} da PagSeguro.<br/>Erro retornado: {$exception->getMessage()}.");
    exit;
}
