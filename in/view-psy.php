<?php
session_start();
require_once("../lib/classes/Package.php");
$package = new Package();
Page::pushBase();
if (!User::restrict($absolute = true)) {
    header("location: login.php");
    exit();
}
$elem = array(
    'name' => '',
    'mail' => '',
    'nickname' => '',
    'login' => '',
    'telefone' => '',
    'genero' => '',
    'data_nasc' => '',
    'cpf' => '',
    'crp' => '',
    'e_psi' => '',
    'formacao' => '',
    'instituicao' => '',
    'curso' => '',
    'ano_inicio' => '',
    'ano_conclusao' => '',
    'mini_curriculo' => '',
    'abordagens_principais' => '',
    'abordagens_secundarias' => '',
    'especialidades' => '',
    'acao_etica' => '',
    'plano' => '',
    'status' => 1
);
$img = 'Imagem';
$req = ' required';
$alt = isset($_GET, $_GET['ID']) && intval($_GET['ID']) > 0;
if ($alt) {
    $elem = Psychologist::load($_GET['ID'], '0,1', NULL, NULL, false, -1, NULL, NULL);
    if (empty($elem)) {
        Display::Message("err", SLIDE_NOT_FOUND);
        header("location: psychologists.php");
        exit();
    }
    $elem = $elem[0];
}
$nav = ($alt ? 'alt' : 'add') . "-psy";
$page_title = WRITER_OF . 'psicólogos';
$page_desc = NULL;
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="pt-br"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="pt-br"><![endif]-->
<!--[if !IE]><!-->
<html lang="pt-br" class="no-js">
<!--<![endif]-->

<head><?php include_once("inc/html_head.php"); ?></head>

<body><?php include_once("inc/header.php"); ?>
    <!-- start: MAIN CONTAINER -->
    <div class="main-container"><?php include_once("inc/sidebar.php"); ?>
        <!-- start: PAGE -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: PAGE TITLE -->
                        <div class="page-header">
                            <h1><?php echo $page_title ?><?php echo $page_desc != NULL ? " <small>" . $page_desc . "</small>" : ""; ?></h1>
                        </div>
                        <!-- end: PAGE TITLE -->
                    </div>
                </div>
                <!-- start: PAGE CONTENT -->
               
                    <?php if ($alt) { ?>
                        <input type="hidden" name="ID" value="<?php echo $elem['ID']; ?>" />
                    <?php } ?>
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $elem['name']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="mail" class="form-control" value="<?php echo $elem['mail']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Gênero</label>
                        <input type="text" name="genero" class="form-control" value="<?php echo $elem['genero']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Data de nascimento</label>
                        <input type="text" name="data_nasc" class="form-control" value="<?php echo $elem['data_nasc']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control" value="<?php echo $elem['telefone']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control" value="<?php echo $elem['cpf']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>CRP</label>
                        <input type="text" name="crp" class="form-control" value="<?php echo $elem['crp']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>E-PSI</label>
                        <input type="text" name="e_psi" class="form-control" value="<?php echo $elem['e_psi']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>E-PSI</label>
                        <input type="text" name="e_psi" class="form-control" value="<?php echo $elem['e_psi']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Formação</label>
                        <input type="text" name="formacao" class="form-control" value="<?php echo $elem['formacao']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Instituição</label>
                        <input type="text" name="instituicao" class="form-control" value="<?php echo $elem['instituicao']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Curso</label>
                        <input type="text" name="curso" class="form-control" value="<?php echo $elem['curso']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Instituição</label>
                        <input type="text" name="instituicao" class="form-control" value="<?php echo $elem['instituicao']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Ano de início</label>
                        <input type="text" name="ano_inicio" class="form-control" value="<?php echo $elem['ano_inicio']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Ano de conclusão</label>
                        <input type="text" name="ano_conclusao" class="form-control" value="<?php echo $elem['ano_conclusao']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Mini currículo</label>
                        <textarea class="form-control" rows="3" name="mini_curriculo" readonly="readonly"><?php echo $elem['mini_curriculo']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Abordagens principais</label>
                        <textarea class="form-control" rows="3" name="abordagens_principais" readonly="readonly"><?php echo $elem['abordagens_principais']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Abordagens secundárias</label>
                        <textarea class="form-control" rows="3" name="abordagens_secundarias" readonly="readonly"><?php echo $elem['abordagens_secundarias']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ofereço ajuda para:</label>
                        <textarea class="form-control" rows="3" name="especialidades" readonly="readonly"><?php echo $elem['especialidades']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Já respondeu alguma ação disciplinar por falha ética?</label>
                        <input type="text" name="acao_etica" class="form-control" value="<?php echo $elem['acao_etica']; ?>" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label>Plano</label>
                        <textarea class="form-control" rows="3" readonly="readonly" name="plano"><?php echo $elem['plano']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button onClick="javascript:aprovePsy(<?php echo $elem['ID']?>)" class="btn btn-success">Aprovar</button>
                    </div>
                
                <!-- end: PAGE CONTENT-->
            </div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
    <?php
    include_once("inc/footer.php");
    Page::script(array(
        "assets/js/in/aprove-psy.js"
    ));
    ?>
</body>
<!-- end: BODY -->

</html>