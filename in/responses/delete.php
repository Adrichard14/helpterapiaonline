<?php
    require_once("../../lib/classes/Package.php");
    new Package();
    User::restrict();
    if(!isset($_POST, $_POST['class'], $_POST['ID']) || intval($_POST['ID']) <= 0 || !class_exists($_POST['class']))
        exit(INVALID_COMMAND);
    $class = $_POST['class'];
    $ID = intval($_POST['ID']);
    $return = $class::status($ID);
    if(isset($_POST['display']) && $_POST['display'] == 1)
        Display::Message("sc", $return);
    exit($return);
?>