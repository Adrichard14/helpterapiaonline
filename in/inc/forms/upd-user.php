<?php
	if(!isset($_POST, $_POST['ID'])) exit("Comando inválido.");
	require("../../../lib/classes/Package.php");
	$package = new Package(array("_essential", "basic"));
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
	$user = User::load($_POST['ID']);
	if(empty($user))
        exit(USER_NOT_FOUND);
	$user = $user[0];
?>
<form method="post" id="userform">
	<input type="hidden" name="ID" value="<?php echo $_POST['ID']?>" />
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_NAME); ?></label>
        <input type="text" name="name" value="<?php echo $user["name"]?>" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_NICKNAME); ?></label>
        <input type="text" name="nickname" value="<?php echo $user["nickname"]?>" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_LOGIN); ?></label>
        <input type="text" name="login" value="<?php echo $user["login"]?>" class="form-control" required />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_NEW_PASSWORD." (".OPTIONAL.")"); ?></label>
        <input type="password" name="password" class="form-control" />
    </div>
    <div class="form-group">
    	<label><?php echo ucfirst(VAR_NEW_PASSWORD2); ?></label>
        <input type="password" name="password2" class="form-control" />
    </div>
    <div class="form-group">
        <label><?php echo ucfirst(VAR_RECOVERY_EMAIL); ?></label>
        <input type="email" name="mail" value="<?php echo $user['mail']?>" class="form-control" />
    </div>
	<div class="form-group">
    	<button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>