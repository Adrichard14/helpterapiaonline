<?php
	session_start();
	require("../../lib/classes/Package.php");
	new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    $vars = array('name', 'value');
    foreach($vars as $var) {
        if(!isset($_POST, $_POST[$var]))
            exit(INVALID_COMMAND);
        $$var = $_POST[$var];
    }
    exit(Email::create($name, $value));
?>