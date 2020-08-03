<?php
	require("../../../lib/classes/Package.php");
	$package = new Package(array("_essential", "basic"));
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
?>
<form method="post" id="userform" >
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_NAME); ?></label>
        <input type="text" name="name" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_NICKNAME); ?></label>
        <input type="text" name="nickname" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_LOGIN); ?></label>
        <input type="text" name="login" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_PASSWORD); ?></label>
        <input type="password" name="password" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_PASSWORD2); ?></label>
        <input type="password" name="password2" class="form-control" required />
    </div>
    <div class="form-group">
        <label><?php echo ucfirst(VAR_RECOVERY_EMAIL); ?></label>
        <input type="email" name="mail" class="form-control" />
    </div>
	<div class="form-group">
    	<button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>