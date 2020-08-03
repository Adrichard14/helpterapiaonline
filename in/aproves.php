<?php
session_start();
require_once("../lib/classes/Package.php");
$package = new Package();
Page::pushBase();
if (!User::restrict($absolute = true)) {
    header("location: login.php");
    exit();
}
$page = isset($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) : 1;
$limit = 25;
$ready = false;
while (!$ready) {
    $page_limit = (($page - 1) * $limit) . "," . $limit;
    $list = Psychologist::load(-1, $page_limit, "`registry_date` DESC", NULL, false, 3);
    $ready = !empty($list) || $page == 1;
    if (!$ready) $page--;
}
$paginator = new Paginator(sizeof(Psychologist::load()), "psychologists.php?page=", $page, $limit);
$headers = array(
    array("value" => "#", "class" => "text-center"),
    array("value" => "ID", "class" => "text-center"),
    array("value" => VAR_NAME, "class" => "text-center"),
    array("value" => VAR_LOGIN, "class" => "text-center"),
    array("value" => VAR_REGISTRY_DATE, "class" => "text-center")
);
$table = new Table($headers, 1, $paginator);
if (empty($list))
    $table->addRow(
        array(
            array("value" => USER_EMPTY_TABLE . str_replace("{LINK}", '#" onclick="newPsy()', ' ' . CLICK_HERE_TO_WRITE_ONE), "class" => "text-center", "colspan" => sizeof($headers))
        )
    );
else foreach ($list as $i) {
    $menu = array(
        'javascript:updatePsy(' . $i["ID"] . ')' => '<i class="clip-pencil-3"></i> ' . UPDATE,
        'view-psy.php?ID=' . $i["ID"] => '<i class="clip-pencil-3"></i> ' . 'Ver dados',
        'javascript:deletePsy(' . $i["ID"] . ')' => '<i class="icon-remove"></i> ' . DELETE . ' ' . strtolower(USER)
    );
    $row = array(
        array("value" => Format::getMenu($menu), "class" => "text-center"),
        array("value" => '#' . $i["ID"], 'class' => 'text-center'),
        array("value" => $i["name"]),
        array("value" => $i["login"]),
        array("value" => Format::toDateTime($i["registry_date"]), "class" => "text-center")
    );
    $table->addRow($row);
}
$nav = "list-aprove";
$page_title = LIST_OF . 'psicólogos' . ' <i onClick="newPsy()" class="clip-plus-circle-2 text-success clickable" title="' . INSERT . ' ' . strtolower(USER) . '"></i>';
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
                <?php $table->show(); ?>
                <!-- end: PAGE CONTENT-->
            </div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php");
                                Page::script("assets/js/in/Psychologist.js"); ?>
</body>
<!-- end: BODY -->

</html>