<?php
	if(!isset($_POST, $_POST['mail'], $_POST['recovery_token'], $_POST['password'], $_POST['password2']))
        exit("Comando inválido.");
	require_once("../../lib/classes/Package.php");
	new Package(array('_essential', 'basic'));
    if(Psychologist::verify_recovery_token($_POST['mail'], $_POST['recovery_token'])){
        Psychologist::recovery($_POST['password'], $_POST['password2']);
    }