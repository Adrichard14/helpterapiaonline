<?php
require("../../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!Psychologist::restrict($absolute = true))
    exit(ACCESS_DENIED);
// exit(var_dump($_POST));
?>
<form method="post" id="linkform">
    <input type="hidden" name="eventID" value="<?php echo $_POST['eventID']?>">   
        <div class="form-group">
            <label>Link</label>
            <input type="text" name="link" class="form-control" required />
        </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>