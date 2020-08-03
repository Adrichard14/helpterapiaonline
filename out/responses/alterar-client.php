<?php
session_start();
// exit(var_dump($_POST));
if (!isset($_POST, $_POST['name'], $_POST['password'], $_POST['password2'], $_POST['mail'], $_POST['thumb'])) exit("Comando inválido.");
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (Client::update($_POST['ID'],$_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'], $_POST['thumb'], $_POST['telefone'], $_POST['data_nasc'], $_POST['sexo'], $_POST['cpf']))
    exit('Perfil alterado com sucesso!');
exit(USER_INSERTION_FAILED);
