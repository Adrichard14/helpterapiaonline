<?php
    if(!isset($_POST, $_POST['ID']) || intval($_POST['ID']) <= 0)
        exit("Comando inválido.");
    require_once("../../lib/classes/Package.php");
    new Package();
    if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    exit(Email::status($_POST['ID']));
?>