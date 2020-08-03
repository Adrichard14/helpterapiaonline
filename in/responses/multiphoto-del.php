<?php
    require_once("../../lib/classes/Package.php");
    new Package(array("_essential", "basic"));
    if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
    Multiphoto::delete();
?>