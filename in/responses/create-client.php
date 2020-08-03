<?php
	if(!isset($_POST, $_POST['name'], $_POST['nickname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['mail'], $_POST['cpf'], $_POST['telefone'], $_POST['data_nasc'], $_POST['sexo'])) exit("Comando inválido.");
	session_start();
	require("../../lib/classes/Package.php");
	$package = new Package(array("_essential", "basic"));
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
	$thumb = "";
	if(Client::create($_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'], $thumb, $_POST['telefone'], $_POST['data_nasc'], $_POST['sexo'], $_POST['cpf']))
        exit(USER_INSERTED);
	exit(USER_INSERTION_FAILED);
