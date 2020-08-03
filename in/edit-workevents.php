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
    'date' => '',
    'hour' => '',
    'workerID' => '',
    'clientID' => ''
);
$img = 'Imagem';
$req = ' required';
$alt = isset($_GET, $_GET['ID']) && intval($_GET['ID']) > 0;
if ($alt) {
    $elem = WorkEvents::load($_GET['ID'], '0,1', NULL, -1);
    if (empty($elem)) {
        Display::Message("err", SLIDE_NOT_FOUND);
        header("location: workerevents.php");
        exit();
    }
    $elem = $elem[0];
    $regex = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';
    $output = '$3/$2/$1 $4:$5';
    $img = 'Trocar imagem';
    $req = '';
    $psicologo = Psychologist::load($elem['workerID']);
    $psicologo = $psicologo[0];
    $cliente = Client::load($elem['clientID']);
    $cliente = $cliente[0];
}
$nav = ($alt ? 'alt' : 'add') . "-plans";
$page_title = WRITER_OF . 'planos';
$page_desc = NULL;
// exit(var_dump($elem['ID']));
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
                        <label>Hora</label>
                        <input type="text" name="hour" class="form-control" value="<?php echo $elem['hour']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Data</label>
                        <input type="text" name="date" class="form-control" value="<?php echo $elem['date']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Psicólogo</label>
                        <input type="text" disabled class="form-control" value="<?php echo $psicologo['name']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Cliente</label>
                        <input type="text" disabled class="form-control" value="<?php echo $cliente['name']; ?>" />
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
        "assets/js/in/edit-workevents.js"
    ));
    ?>
</body>
<!-- end: BODY -->

</html>