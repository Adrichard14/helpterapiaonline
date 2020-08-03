<?php
	session_start();
	require("../../lib/classes/Package.php");
	new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    $vars = array("thumb", "link", "title", "init_date", "end_date", "status");
    foreach($vars as $var) {
        if(!isset($_POST, $_POST[$var]))
            exit(INVALID_COMMAND);
        $$var = $_POST[$var];
    }
    if(isset($_POST, $_POST['ID']) && intval($_POST['ID']) > 0)
        Slide::update($_POST['ID'], $thumb, $link, $title, $init_date, $end_date, $status);
    Slide::create($thumb, $link, $title, $init_date, $end_date, $status);
    
?>