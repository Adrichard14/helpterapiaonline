<?php
	session_start();
	require("../../lib/classes/Package.php");
	new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    $vars = array("subject", "content", "execution_date", "status", "emailIDs");
    foreach($vars as $var) {
        if(!isset($_POST, $_POST[$var]))
            exit(INVALID_COMMAND);
        $$var = $_POST[$var];
    }
    if(isset($_POST, $_POST['ID']) && intval($_POST['ID']) > 0)
        Queue::update($_POST['ID'], $_SESSION[User::$SESSION]['ID'], $subject, $content, $execution_date, $status, $emailIDs);
    Queue::create($_SESSION[User::$SESSION]['ID'], $subject, $content, $execution_date, $status, $emailIDs);
?>