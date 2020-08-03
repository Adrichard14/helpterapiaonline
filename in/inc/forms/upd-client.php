<?php
if (!isset($_POST, $_POST['ID'])) exit("Comando inválido.");
require("../../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!User::restrict($absolute = true))
    exit(ACCESS_DENIED);
$user = Client::load($_POST['ID']);
if (empty($user))
    exit(USER_NOT_FOUND);
$user = $user[0];
?>
<form method="post" id="userform">
    <input type="hidden" name="ID" value="<?php echo $_POST['ID'] ?>" />
    <div class="form-group">
        <label><?php echo ucfirst(VAR_NAME); ?></label>
        <input type="text" name="name" value="<?php echo $user["name"] ?>" class="form-control" required />
    </div>
    <input type="hidden" name="nickname" value="<?php echo $user['nickname'] ?>">
    <input type="hidden" name="login" value="<?php echo $user['login'] ?>">
    <!-- <div class="form-group">
        <label><?php echo ucfirst(VAR_NICKNAME); ?></label>
        <input type="text" name="nickname" value="<?php echo $user["nickname"] ?>" class="form-control" required />
    </div>
    <div class="form-group">
        <label><?php echo ucfirst(VAR_LOGIN); ?></label>
        <input type="text" name="login" value="<?php echo $user["login"] ?>" class="form-control" required />
    </div> -->
    <div class="form-group">
        <label>Telefone</label>
        <input type="text" name="telefone" class="form-control" value="<?php echo $user['telefone'] ?>" />
    </div>
    <div class="form-group">
        <label>Data de nascimento</label>
        <input type="text" name="data_nasc" class="form-control" value="<?php echo $user['data_nasc'] ?>" />
    </div>
    <div class="form-group">
        <label>CPF</label>
        <input type="text" name="cpf" class="form-control" value="<?php echo $user['cpf'] ?>" />
    </div>
    <input type="hidden" name="sexo" value="<?php echo $user['sexo'] ?>">
    <input type="hidden" name="thumb" value="<?php echo $user['thumb'] ?>">
    <div class="form-group">
        <label><?php echo ucfirst(VAR_NEW_PASSWORD . " (" . OPTIONAL . ")"); ?></label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label><?php echo ucfirst(VAR_NEW_PASSWORD2); ?></label>
        <input type="password" name="password2" class="form-control" />
    </div>
    <div class="form-group">
        <label><?php echo ucfirst(VAR_RECOVERY_EMAIL); ?></label>
        <input type="email" name="mail" value="<?php echo $user['mail'] ?>" class="form-control" />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>