<?php
isset($_SESSION) or session_start();
$base = "";
while (!file_exists($base . "lib")) $base .= "../";
require_once($base . "lib/classes/Package.php");
$package = new Package(array('basic/Psychologist', '_essential/Display'), false);
Display::Message('sc', str_replace('{USER}', $_SESSION[Psychologist::$SESSION]['name'], GOOD_BYE));
unset($_SESSION[Psychologist::$SESSION]);
header("location: " . PUBLIC_URL . "login-psicologo");
