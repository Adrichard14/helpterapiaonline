<?php
    require_once("lib/classes/Package.php");
    new Package();
    Newsletter::queue();
?>