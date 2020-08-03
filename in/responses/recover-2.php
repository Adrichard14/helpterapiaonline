<?php
	if(!isset($_POST, $_POST['password'], $_POST['password2']))
        exit("Comando inválido.");
	require_once("../../lib/classes/Package.php");
	new Package(array('_essential', 'basic'));
    if(User::restrict($absolute = true))
        exit(USER_ALREADY_LOGGED_IN);
	User::recovery($_POST['password'], $_POST['password2']);
?>