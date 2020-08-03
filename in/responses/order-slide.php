<?php
    require_once("../../lib/classes/Package.php");
    new Package();
    if(!isset($_POST, $_POST['ID'], $_POST['value'], $_POST['diff']) || intval($_POST['ID']) <= 0)
        exit(INVALID_COMMAND);
    if(!User::restrict())
        exit(ACCESS_DENIED);
    Slide::order($_POST['ID'], $_POST['value'], $_POST['diff'] == 1);
?>