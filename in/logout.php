<?php
	isset($_SESSION) or session_start();
	$base = ""; while(!file_exists($base."lib")) $base.="../";
	require_once($base."lib/classes/Package.php");
	$package = new Package(array('basic/User', '_essential/Display'), false);
	Display::Message('sc', str_replace('{USER}', $_SESSION[User::$SESSION]['name'], GOOD_BYE));
	unset($_SESSION[User::$SESSION]);
	header("location: ".$base."in/login.php");
?>