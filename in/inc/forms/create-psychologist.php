<?php
require("../../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
if (!User::restrict($absolute = true))
    exit(ACCESS_DENIED);
$planos = Plans::load(-1);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<form method="post" id="userform">
    <input type="hidden" name="nickname">
    <input type="hidden" name="login">
    <div class="form-group">
        <label><?php echo ucfirst(VAR_NAME); ?></label>
        <input type="text" name="name" class="form-control" required />
    </div>
    <div class="form-group">
        <label>Sexo<span class="text-danger">*</span></label>
        <div class="form-check">
            <label class="form-check-label" for="masculino">
                Masculino
            </label>
            <input class="form-group" type="radio" name="genero" id="masculino" value="masculino">
            <label class="form-check-label" for="feminino">
                Feminino
            </label>
            <input class="form-group" type="radio" name="genero" id="feminino" value="feminino">
        </div>
    </div>
    <div class="form-group position-relative">
        <label>Data de nascimento <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_nasc" required="">
    </div>
    <div class="form-group position-relative">
        <label>Telefone</label>
        <input type="text" class="form-control" placeholder="Telefone" name="telefone" required="">
    </div>
    <div class="form-group position-relative">
        <label>CPF<span class="text-danger">*</span></label>
        <input type="text" class="form-control cpf" placeholder="Seu CPF" name="cpf" required="">
    </div>
    <div class="form-group position-relative">
        <label>CRP<span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Seu CRP" name="crp" required="">
    </div>
    <div class="form-group">
        <label>Possui E-PSI?<span class="text-danger">*</span></label>
        <div class="form-check">
            <label class="form-check-label" for="exampleRadios2">
                Sim
            </label>
            <input class="form-group" type="radio" name="e_psi" id="sim" value="sim">
            <label class="form-check-label" for="exampleRadios1">
                Não
            </label>
            <input class="form-group" type="radio" name="e_psi" id="nao" value="não">
        </div>
    </div>
    <div class="form-group position-relative">
        <label>Seu e-mail (esse será o login da sua plataforma)<span class="text-danger">*</span></label>
        <input type="email" class="form-control" placeholder="Email" autocomplete="new-password" name="mail" required="">
    </div>

    <div class="form-group position-relative">
        <label>Formação<span class="text-danger">*</span></label>
        <select class="form-control" name="formacao" required="">
            <option>Graduação</option>
            <option>Curso</option>
            <option>Pós-graduação</option>
            <option>Extensão</option>
            <option>Especialização</option>
            <option>MBA</option>
            <option>Mestrado</option>
            <option>Doutorado</option>
            <option>Pós-dotourado</option>
        </select>
    </div>
    <div class="form-group position-relative">
        <label>Instituição de Ensino <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Ex: Universidade de São Paulo" autocomplete="new-password" name="instituicao" required="">
    </div>
    <div class="form-group position-relative">
        <label>Curso<span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Ex: Psicologia" autocomplete="new-password" name="curso" required="">
    </div>
    <div class="form-group position-relative">
        <label>Ano de início<span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Ex: 2010" autocomplete="new-password" name="ano_inicio" required="">
    </div>
    <div class="form-group position-relative">
        <label>Ano de conlusão<span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Ex: 2016" autocomplete="new-password" name="ano_conclusao" required="">
    </div>
    <div class="form-group position-relative">
        <label for="mini_curriculo">Seu mini currículo<span class="text-danger">*</span></label>
        <textarea class="form-control" name="mini_curriculo" id="mini_curriculo" rows="3"></textarea>
    </div>
    <div class="form-group position-relative">
        <label for="abordagens_principais">Abordagens terapêuticas principais<span class="text-danger">*</span>
        </label>
        <textarea class="form-control" name="abordagens_principais" id="abordagens_principais" placeholder="Psicanálise,  Terapia Cognitiva-Comportamental, Psicologia Sistêmica" rows="3"></textarea>
    </div>
    <div class="form-group position-relative">
        <label for="abordagens_secundarias">Abordagens terapêuticas secundárias<span class="text-danger">*</span>
        </label>
        <textarea class="form-control" name="abordagens_secundarias" id="abordagens_secundarias" placeholder="Separadas por vírgula, ex: Psicanálise,  Terapia Cognitiva-Comportamental, Psicologia Sistêmica" rows="3"></textarea>
    </div>
    <div class="form-group position-relative">
        <label for="especialidades">Ofereço ajuda para: <span class="text-danger">*</span>
        </label>
        <textarea class="form-control" name="especialidades" id="especialidades" placeholder="Separadas por vírgula, ex:Abuso, Acompanhamento Psicólogico" rows="3"></textarea>
    </div>
    <div class="form-group position-relative">
        <label for="idiomas">Idiomas <span class="text-danger">*</span>
        </label>
        <textarea class="form-control" name="idiomas" id="idiomas" placeholder="Separadas por vírgula, ex: Inglês, Português, Espanhol" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Já respondeu alguma ação disciplinar por falha ética?<span class="text-danger">*</span></label>
        <div class="form-check">
            <label class="form-check-label" for="sim">
                Sim
            </label>
            <input class="form-group" required type="radio" name="acao_etica" id="sim" value="sim">
            <label class="form-check-label" for="não">
                Não
            </label>
            <input class="form-group" required type="radio" name="acao_etica" id="nao" value="não">
        </div>
    </div>
    <div class="form-group">
        <label>Tipo: <span class="text-danger">*</span></label>
        <div class="form-check">
            <label class="form-check-label" for="psicologo">
                Psicólogo(a)
            </label>
            <input class="form-group" required type="radio" name="tipo" id="psicologo" value="psicologo">
            <label class="form-check-label" for="sexologo">
                Sexólogo(a)
            </label>
            <input class="form-group" required type="radio" name="tipo" id="sexologo" value="sexologo">
        </div>
    </div>
    <div class="form-group position-relative">
        <label>Plano<span class="text-danger">*</span></label>
        <select class="form-control" name="plano" required="">
            <?php foreach ($planos as $plano) { ?>
                <option class="form-control" value="<?= $plano['ID'] ?>"><?= $plano['title'] ?></option>
            <?php } ?>
        </select>
    </div>
    <input type="hidden" name="status" value="3">
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