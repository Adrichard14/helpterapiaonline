<?php
if (!isset($_POST, $_POST['ID'])) exit("Comando inválido.");
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!User::restrict($absolute = true))
    exit(ACCESS_DENIED);
$author = $_SESSION[Psychologist::$SESSION]['ID'] == $_POST['ID'];
if (Psychologist::delete(array("i", intval($_POST['ID'])))) {
    if ($author) {
        unset($_SESSION[Psychologist::$SESSION]);
        exit(Display::Message("sc", USER_SELF_DELETED));
    }
    exit(USER_DELETED);
}
exit($author ? USER_SELF_DELETE_FAILED : USER_DELETE_FAILED);
