<?php
require("../../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!User::restrict($absolute = true))
    exit(ACCESS_DENIED);
?>
<form method="post" id="userform">
    <div class="form-group position-relative">
        <label>Nome</label>
        <input type="text" class="form-control" name="name" required="">
    </div>
    <input type="hidden" name="login">
    <input type="hidden" name="nickname">
    <div class="form-group">
        <label>E-mail</label>
        <input type="email" name="mail" class="form-control" />
    </div>
    <div class="form-group">
        <label>Telefone</label>
        <input type="telefone" name="telefone" class="form-control" required />
    </div>
    <div class="form-group">
        <label>Data de nascimento (dd/mm/yyyy)</label>
        <input type="data_nasc" name="data_nasc" class="form-control" required />
    </div>
    <div class="form-group">
        <label>Sexo<span class="text-danger">*</span></label>
        <div class="form-check">
            <label class="form-check-label" for="masculino">
                Masculino
            </label>
            <input class="form-group" required type="radio" name="sexo" id="masculino" value="masculino">
            <label class="form-check-label" for="feminino">
                Feminino
            </label>
            <input class="form-group" required type="radio" name="sexo" id="feminino" value="feminino">
        </div>
    </div>
    <div class="form-group position-relative">
        <label>CPF<span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="CPF" name="cpf" required="">
    </div>
    <div class="form-group">
        <label><?php echo ucfirst(VAR_PASSWORD); ?></label>
        <input type="password" autocomplete="new-password" name="password" class="form-control" required />
    </div>
    <div class="form-group">
        <label><?php echo ucfirst(VAR_PASSWORD2); ?></label>
        <input type="password" autocomplete="new-password" name="password2" class="form-control" required />
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"><?php echo SEND; ?></button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('input[name="telefone"]').inputmask('99-99999-9999');
        // $('input[name="email"]').inputmask('999.999.999-99');
        $('input[name="cpf"]').inputmask('999.999.999-99');
        $('input[name="data_nasc"]').inputmask('99/99/9999', {
            reverse: true
        });
    });
</script>