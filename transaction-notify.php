<?php
require_once("lib/classes/Package.php");
new Package();

$handler = new PagSeguroWebhookHandler(
    PAGSEGURO_TRANSACTION_EMAIL,
    PAGSEGURO_TRANSACTION_TOKEN
);
$handler->setSupportEmail("adrichard14@hotmail.com");
try {
    $handler->load();

    $ID = intval(GET::transactionId());
    $planID = intval(GET::planId());
    $customerID = intval(GET::customerId());

    if ($ID <= 0 || $planID <= 0 || $customerID <= 0) {
        throw new Exception("Dados de entrada inválidos.");
    }

    $transaction = Transaction::load($ID, "0,1", null, 2.0, -1, $customerID, $planID);
    if (empty($transaction)) {
        throw new Exception("Transação não encontrada.");
    }
    $buyer = Psychologist::load($customerID, '0,1');
    if (empty($buyer)) {
        throw new Exception("Dados de psicólogo não encontrados.");
    }
    $transaction = $transaction[0];
    $buyer = $buyer[0];

    if ($handler->getReference() !== "REF{$transaction["ID"]}_PLAN") {
        throw new Exception("A referência da transação é diferente da referência da notificação do PagSeguro.");
    }

    $transaction["cancel_cause"] = Transaction::getWebhookCancelCause($handler);
    $newStatus = Transaction::convertWebhookStatus($handler);

    if ($newStatus === $transaction["payment_status"]) {
        // nenhuma alteração necessária
        exit("no changes");
    }

    $transaction["payment_status"] = $newStatus;

    $update = Connector::newInstance()->query(
        "UPDATE `" . Transaction::$DATABASE . "`
        SET
            `cancel_cause`='{$transaction["cancel_cause"]}',
            `payment_status`={$transaction["payment_status"]},
            `status_date`=NOW()
        WHERE `ID`={$transaction['ID']}",
        null,
        false
    );

    if (!$update) {
        throw new Exception("Ocorreu uma falha durante a ativação da transação #{$transaction["ID"]} no banco de dados");
    } elseif ($transaction["payment_status"] !== TransactionStatusEnum::PAID) {
        // não é uma ativação, logo pode ser encerrado aqui
        exit("it's not paid");
    }
    // ativação
    Psychologist::setActivePlan($customerID, $planID);

    // TODO: criar campos na tabela de planos para identificar dinamicamente quantos dias o plano acrescenta de término
    $prizesPerPlanId = [
        2 => date('Y-m-d', strtotime("+180 day")), // semestral
        3 => date('Y-m-d', strtotime("+360 day")), // anual
        4 => date('Y-m-d', strtotime("+90 day")), // trimestral
    ];

    if (!isset($prizesPerPlanId[$planID])) {
        throw new Exception("O plano #$planID não tem definição de dias à aplicar no código e, por isso, o gatilho não atualizou a data de expiração!");
    }

    Psychologist::setExpirePlanDate($prizesPerPlanId[$planID], $customerID);

    $url = PUBLIC_URL;
    Newsletter::send(
        'Parabéns!',
        "<p>O pagamento do seu plano foi aprovado!</p></br><h5>Acesse: <a href='$url' target='_blank'>$url</a> faça o seu login!</h5>",
        $buyer['mail']
    );
    exit("OK");
} catch (Exception $exception) {
    $handler->sendSupportEmail(PUBLIC_URL . " - Erro no gatilho de planos",
        "Ocorreu um erro durante o recebimento do gatilho {$handler->getNotificationCode()} da PagSeguro.<br/>Erro retornado: {$exception->getMessage()}.");
    exit($exception->getMessage());
}
