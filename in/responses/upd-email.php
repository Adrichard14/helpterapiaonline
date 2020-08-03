<?php
	session_start();
	require("../../lib/classes/Package.php");
	new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    $vars = array('ID', 'name', 'value');
    foreach($vars as $var) {
        if(!isset($_POST, $_POST[$var]))
            exit(INVALID_COMMAND);
        $$var = $_POST[$var];
    }
    if(intval($ID) <= 0)
        exit(INVALID_COMMAND);
    exit(Email::update($ID, $name, $value));
?>