<?php
session_start();
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!Psychologist::restrict($absolute = true))
    exit(ACCESS_DENIED);
// exit(var_dump($_POST));
if (EventLink::update($FAKE_POST = NULL));
    exit('Link inserido com sucesso!');
exit('Ocorreu uma falha ao inserir o link');
