<?php
	if(!isset($_POST, $_POST['login']))
        exit("Comando inválido.");
	require_once("../../lib/classes/Package.php");
	new Package(array('_essential', 'basic'));
    if(User::restrict($absolute = true))
        exit(USER_ALREADY_LOGGED_IN);
	User::generate_recovery_token($_POST['login']);
?>