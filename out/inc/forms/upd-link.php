<?php
if (!isset($_POST, $_POST['ID'])) exit("Comando inválido.");
require("../../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!Psychologist::restrict($absolute = true))
    exit(ACCESS_DENIED);
    // exit(var_dump($_POST));
$elem = EventLink::load($_POST['ID'], null, null, -1, $_POST['eventID']);

if (empty($elem))
    exit(USER_NOT_FOUND);
$elem = $elem[0];
// exit(var_dump($_POST));
?>
<form method="post" id="linkform">
    <input type="hidden" name="ID" value="<?php echo $_POST['ID'] ?>" />
    <input type="hidden" name="eventID" value="<?php echo $_POST['eventID'] ?>" />
    <div class="form-group">
        <label>Link</label>
        <input type="text" name="link" class="form-control" value="<?php echo $elem['link'] ?>" required />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>