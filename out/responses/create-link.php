<?php
	session_start();
	require("../../lib/classes/Package.php");
	$package = new Package(array("_essential", "basic"));
	if(!Psychologist::restrict($absolute = true))
        exit(ACCESS_DENIED);
    $status = 1;
	if(EventLink::create2($status, $_POST['eventID'], $_POST['link']))
        exit('Link inserido com sucesso!');
	exit('Ocorreu uma falha ao inserir o link');
