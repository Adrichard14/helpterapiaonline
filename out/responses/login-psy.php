<?php
session_start();
if (!isset($_POST['login']) || !isset($_POST['password'])) exit("Comando inválido.");
isset($_SESSION) or session_start();
require_once("../../lib/classes/Package.php");
$package = new Package();
if (Psychologist::login($_POST['login'], $_POST['password']))
    exit(USER_LOGIN_SUCCESS);
exit(Psychologist::login($_POST['login'], $_POST['password']));