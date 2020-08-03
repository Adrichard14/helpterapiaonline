<?php
    header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
    function xml2array($xmlObject, $out = array()) {
        foreach((array) $xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? xml2array($node) : $node;
        return $out;
    }
   
    // exit(var_dump($_GET));
    if(isset($_GET, $_GET['ID'], $_GET['pID'], $_GET['uID']) && intval($_GET['ID']) > 0 && intval($_GET['pID']) > 0 && intval($_GET['uID']) > 0 && isset($_POST, $_POST['notificationCode'], $_POST['notificationType']) && $_POST['notificationType'] == "transaction") {
        // exit(var_dump('Step1'));
        require_once("lib/classes/Package.php");
        new Package();
        define('NOTIFICATION_EMAIL', 'adrichard14@hotmail.com');
        $ID = intval($_GET['ID']);
        $planID = intval($_GET['pID']);
        $customerID = intval($_GET['uID']);
        $transaction = Transaction::load($ID, "0,1", NULL, 2.0, -1, $customerID, $planID);
        // exit(var_dump($transaction[0]['status']));
        if($transaction[0]['status'] == 1){
            Psychologist::setActivePlan($customerID, $planID);
        }
        $semestral = date('y/m/d', strtotime("+180 day"));
        $anual = date('y/m/d', strtotime("+360 day"));
        $trimestral = date('y/m/d', strtotime("+90 day"));
        // exit(var_dump($anual));
        if($planID == 2){
            Psychologist::setExpirePlanDate($semestral, $customerID);
        }
        if($planID == 3){
            Psychologist::setExpirePlanDate($anual, $customerID);
        }
        if($planID == 4){
            Psychologist::setExpirePlanDate($trimestral, $customerID);
        }
         if($transaction['payment_status'] == 1){
              Newsletter::send('Parabéns!', '<p>A compra do seu plano foi aprovada!</p></br><h5>Acesse: www.helpterapia.com.br faça o seu login!</h5>', 'adrichard14@hotmail.com');
        }
        if(empty($transaction)) {
            exit("Comando inválido.");
        } elseif($transaction[0]['payment_status'] == 1) {
            exit("Esta transação já foi paga.");
        }
        $elem = $transaction[0];
        $code = $_POST['notificationCode'];
        $email = PagSeguroConfigWrapper::PAGSEGURO_EMAIL;
        if(PagSeguroConfigWrapper::PAGSEGURO_ENV == "production") {
            $preURL = "https://ws.pagseguro.uol.com.br";
            $token = PagSeguroConfigWrapper::PAGSEGURO_TOKEN_PRODUCTION;
        } else {
            $preURL = "https://ws.sandbox.pagseguro.uol.com.br";
            $token = PagSeguroConfigWrapper::PAGSEGURO_TOKEN_SANDBOX;
        }
        $URL = $preURL."/v2/transactions/notifications/".$code."?email=".$email."&token=".$token;
        $curl = curl_init($URL);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $transaction = curl_exec($curl);
        if($transaction == 'Unauthorized') {
            var_dump($URL);
            Newsletter::send('Atualização de transação não-autorizada', '<p>Ocorreu uma atualização de status de transação do PagSeguro para a transação #'.$elem['ID'].' que retornou o erro "Não autorizado" no sistema. Favor rever a situação e implementar uma solução manual com urgência.</p>', NOTIFICATION_EMAIL);
            exit();
        }
        curl_close($curl);
        $transaction = xml2array(simplexml_load_string($transaction));
       
        $pagseguro_status_list = array(
            1 => 0, //aguardando pagamento => pendente
            2 => 0, //em análise => pendente
            3 => 1, //paga => paga
            4 => 1, //disponível => paga
            5 => 2, //em disputa => em disputa
            6 => 3, //devolvida => devolvida
            7 => 4 //cancelado => cancelado
        );
        $pagseguro_status_list2 = array(
            1 => 0, //aguardando pagamento => aguardando pagamento
            2 => 0, //em análise => aguardando pagamento
            3 => 1, //paga => à entregar
            4 => 1, //disponível => à entregar
            5 => 0, //em disputa => aguardando pagamento
            6 => 4, //devolvida => entrega cancelada
            7 => 4 //cancelado => entrega cancelada
        );
        if(!isset($pagseguro_status_list[$transaction['status']]) || $transaction['reference'] != "REF".$elem['ID'])
            exit();
        $payment_status = $pagseguro_status_list[$transaction['status']];
        // $ship_status = $pagseguro_status_list2[$transaction['status']];
        $cancel_cause = "";
        
        if($transaction['status'] == 6) {
            $cancel_cause = "Entrega cancelada devido à devolução do pagamento.";
        } elseif($transaction['status'] == 7) {
            $cancel_cause = "Entrega cancelada devido ao cancelamento do pagamento.";
        }
        $update = Connector::newInstance()->query(
            "UPDATE `".Transaction::$DATABASE."` SET `cancel_cause`=?, `payment_status`=?,  `status_date`=NOW() WHERE `ID`=?",
            array("sii", $cancel_cause."", intval($payment_status), intval($elem['ID'])),
            false
        );
        if(!$update) {
            Newsletter::send('Atualização de transação falhou', '<p>Ocorreu uma atualização de status de transação do PagSeguro para a transação #'.$elem['ID'].' que não atualizou o banco de dados. Favor rever a situação e implementar uma solução manual com urgência. Novo status: '.$status.'</p>', 'adrichard14@hotmail.com');
            exit();
        }
    }
