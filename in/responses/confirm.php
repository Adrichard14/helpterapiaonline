<?php
	if(!isset($_POST['password'])) exit("Comando inválido.");
	isset($_SESSION) or session_start();
	require_once("../../lib/classes/Package.php");
	$package = new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
	if(User::confirmPassword($_SESSION[User::$SESSION]["ID"], $_POST['password']))
        exit(PASSWORD_AUTHENTICATED);
	exit(PASSWORD_AUTHENTICATION_FAILED);
?>