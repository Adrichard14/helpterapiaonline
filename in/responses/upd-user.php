<?php
	if(!isset($_POST, $_POST['ID'], $_POST['name'], $_POST['nickname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['mail'])) exit("Comando inválido.");
	session_start();
	require("../../lib/classes/Package.php");
	$package = new Package(array("_essential", "basic"), true, false);
    if(!$package->import())
        exit("Falha ao importar biblioteca de execução.");
	if(!User::restrict()) exit("Você não pode realizar esta operação.");
	if(User::update($_POST['ID'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'])) exit("Super administrador alterado com sucesso!");
	exit("Falha ao alterar super administrador.");
