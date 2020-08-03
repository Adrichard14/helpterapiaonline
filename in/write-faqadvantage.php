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
    'question' => '',
    'answer' => '',
    'status' => 1
);
$img = 'Imagem';
$req = ' required';
$alt = isset($_GET, $_GET['ID']) && intval($_GET['ID']) > 0;
if ($alt) {
    $elem = FaqAdvantage::load($_GET['ID'], '0,1', NULL, 2.0);
    if (empty($elem)) {
        Display::Message("err", SLIDE_NOT_FOUND);
        header("location: news.php");
        exit();
    }
    $elem = $elem[0];
    $img = 'Trocar imagem';
    $req = '';
}
$nav = ($alt ? 'alt' : 'add') . "-advantage";
$page_title = WRITER_OF . 'perguntas';
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
                <form id="wform" enctype="multipart/form-data">
                    <?php if ($alt) { ?>
                        <input type="hidden" name="ID" value="<?php echo $elem['ID']; ?>" />
                    <?php } ?>
                    <div class="form-group">
                        <label>Pergunta</label>
                        <input type="text" name="question" class="form-control" value="<?php echo $elem['question']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Conteúdo</label>
                        <textarea class="editor" name="answer"><?php echo $elem['answer']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Salvar como</label>
                        <select name="status" class="form-control" onchange="document.getElementById('sdates').style.display = this.value == 1 ? 'block' : 'none';">
                            <option value="0" <?php echo $elem['status'] == 0 ? ' selected' : ''; ?>>rascunho</option>
                            <option value="1" <?php echo $elem['status'] == 1 ? ' selected' : ''; ?>>publicado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><?php echo SEND; ?></button>
                    </div>
                </form>
                <!-- end: PAGE CONTENT-->
            </div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
    <?php
    include_once("inc/footer.php");
    Page::script(array(
        "assets/js/in/write-faqadvantage.js"
    ));
    ?>
</body>
<!-- end: BODY -->

</html>