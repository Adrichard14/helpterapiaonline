<?php
// exit(var_dump($_POST));
if (!isset($_POST, $_POST['name'], $_POST['nickname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['mail'])) exit("Comando inválido.");
session_start();
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));

// if(!User::restrict($absolute = true))
//     exit(ACCESS_DENIED);
if (Psychologist::create($_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail']))
    exit(USER_INSERTED);
exit(USER_INSERTION_FAILED);
