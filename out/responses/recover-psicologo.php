<?php
	if(!isset($_POST, $_POST['mail']))
        exit("Comando inválido.");
	require_once("../../lib/classes/Package.php");
	new Package(array('_essential', 'basic'));
    if(Psychologist::restrict($absolute = true))
        exit(USER_ALREADY_LOGGED_IN);
	Psychologist::generate_recovery_token($_POST['mail']);
