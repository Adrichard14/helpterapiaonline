<?php
    require_once("../../lib/classes/Package.php");
    new Package();
    User::restrict();
    if(!isset($_GET, $_GET['class'], $_POST) || !class_exists($_GET['class']))
        exit(INVALID_COMMAND);
    $class = $_GET['class'];
    $return = isset($_POST, $_POST['ID']) ? $class::update() : $class::create();
    if(isset($_GET['display']) && $_GET['display'] == 1)
        Display::Message("sc", $return);
    exit($return);
?>