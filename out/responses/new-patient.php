<?php
// exit(var_dump($_POST));
	if(!isset($_POST, $_POST['name'], $_POST['nickname'], $_POST['password'], $_POST['password2'], $_POST['mail'])) exit("Comando inválido.");
	session_start();
	require("../../lib/classes/Package.php");
	$package = new Package(array("_essential", "basic"));
    
	// if(!User::restrict($absolute = true))
    //     exit(ACCESS_DENIED);
	$thumb = " ";
	if(Client::create($_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'], $thumb, $_POST['telefone'], $_POST['data_nasc'], $_POST['sexo'], $_POST['cpf']))
        exit('Cadastro efetuado com sucesso!');
	exit('Houve um erro ao efeutar o cadastro.');
