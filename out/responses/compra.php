<?php
header("Content-type: application/json; charset=utf-8");
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic", "ecommerce", "newsletter", "ecommerce/pagseguro"));
$customerID = $_POST['customerID'];
$planID = $_POST['planID'];
$json = Transaction::create($customerID, $planID, $payment_status = 0);
    exit(json_encode($json));
?>