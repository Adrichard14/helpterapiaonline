<?php
    if(!isset($_POST, $_POST['login'], $_POST['recovery_token']))
        exit("Comando inválido.");
    require_once("../../../lib/classes/Package.php");
    new Package(array("_essential", "basic"));
    if(User::restrict($absolute = true))
        exit(USER_ALREADY_LOGGED_IN);
    User::verify_recovery_token($_POST['login'], $_POST['recovery_token']);
?>
<form class="form-login" id="form_recover2">
    <fieldset>
        <div class="form-group">
            <span class="input-icon">
                <input type="password" class="form-control password" name="password" placeholder="<?php echo ucfirst(VAR_PASSWORD); ?>">
                <i class="icon-lock"></i> </span>
        </div>
        <div class="form-group form-actions">
            <span class="input-icon">
                <input type="password" class="form-control password" name="password2" placeholder="<?php echo ucfirst(VAR_PASSWORD2); ?>">
                <i class="icon-unlock"></i> </span>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-brick pull-right">
                <?php echo RECOVER; ?> <i class="icon-circle-arrow-right"></i>
            </button>
        </div>
    </fieldset>
</form>