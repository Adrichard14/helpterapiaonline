<?php
if (!isset($_POST, $_POST['ID'])) exit("Comando inválido.");
require("../../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!User::restrict($absolute = true))
    exit(ACCESS_DENIED);
$user = Psychologist::load($_POST['ID']);
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
    <!-- <div class="form-group">
        <label><?php echo ucfirst(VAR_NICKNAME); ?></label>
        <input type="text" name="nickname" value="<?php echo $user["nickname"] ?>" class="form-control" required />
    </div> -->
    <input type="hidden" name="nickname" value="<?php echo $user['nickname'] ?>">
    <input type="hidden" name="login" value="<?php echo $user['login'] ?>">
    <input type="hidden" name="data_nasc" value="<?php echo $user['data_nasc'] ?>">
    <input type="hidden" name="genero" value="<?php echo $user['genero'] ?>">
    <input type="hidden" name="telefone" value="<?php echo $user['telefone'] ?>">
    <input type="hidden" name="status" value="<?php echo $user['status'] ?>">
    <input type="hidden" name="cpf" value="<?php echo $user['cpf'] ?>">
    <input type="hidden" name="crp" value="<?php echo $user['crp'] ?>">
    <input type="hidden" name="e_psi" value="<?php echo $user['e_psi'] ?>">
    <input type="hidden" name="mini_curriculo" value="<?php echo $user['mini_curriculo'] ?>">
    <input type="hidden" name="acao_etica" value="<?php echo $user['acao_etica'] ?>">
    <input type="hidden" name="abordagens_principais" value="<?php echo $user['abordagens_principais'] ?>">
    <input type="hidden" name="abordagens_secundarias" value="<?php echo $user['abordagens_secundarias'] ?>">
    <input type="hidden" name="especialidades" value="<?php echo $user['especialidades'] ?>">
    <input type="hidden" name="plano" value="<?php echo $user['plano'] ?>">
    <input type="hidden" name="thumb" value="<?php echo $user['thumb'] ?>">
    <input type="hidden" name="valor_consulta" value="<?php echo $user['login'] ?>">
    <input type="hidden" name="tipo" value="<?php echo $user['tipo'] ?>">
    <input type="hidden" name="idiomas" value="<?php echo $user['idiomas'] ?>">
    <input type="hidden" name="formacao" value="<?php echo $user['formacao'] ?>">
    <input type="hidden" name="curso" value="<?php echo $user['curso'] ?>">
    <input type="hidden" name="acao_etica" value="<?php echo $user['acao_etica'] ?>">
    <input type="hidden" name="instituicao" value="<?php echo $user['instituicao'] ?>">
    <input type="hidden" name="ano_inicio" value="<?php echo $user['ano_inicio'] ?>">
    <input type="hidden" name="ano_conclusao" value="<?php echo $user['ano_conclusao'] ?>">
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