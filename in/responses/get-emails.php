<?php
    header("content-type: application/json; charset=utf-8");
	session_start();
	require("../../lib/classes/Package.php");
	new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    $temp = Email::load(-1, NULL, NULL, 1);
    $emails = array();
    if(!empty($temp))
        foreach($temp as $t)
            $emails[$t['ID']] = $t['value'];
    exit(json_encode(array("status" => empty($emails) ? 0 : 1, "list" => $emails)));
?>