<?php
    require_once("../../../lib/classes/Package.php");
    new Package();
    if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
?>
<form id="form" role="form">
	<div class="form-group">
    	<label><?php echo PLEASE_INFORM_YOUR_PASSWORD; ?></label>
        <input type="password" name="password" value="" class="form-control" />
    </div>
    <div class="form-group">
    	<button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>