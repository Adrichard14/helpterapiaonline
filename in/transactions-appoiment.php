<?php
session_start();
require_once("../lib/classes/Package.php");
$package = new Package();
Page::pushBase();
if (!User::restrict($absolute = true)) {
    header("location: login.php");
    exit();
}
$pagseguro_status_list =
    array("pendente", "aprovado", "em disputa", "estornado", "cancelado");
// exit(var_dump($pagseguro_status_list));
$page = isset($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) : 1;
$limit = 25;
$ready = false;
while (!$ready) {
    $page_limit = (($page - 1) * $limit) . "," . $limit;
    $list = TransactionAppointment::load(-1, $page_limit, "`order` ASC", 2.0);
    $ready = !empty($list) || $page == 1;
    if (!$ready) $page--;
}
$paginator = new Paginator(TransactionAppointment::paginator(2.0), "transactions.php?page=", $page, $limit);
$headers = array(
    array("value" => "#", "class" => "text-center"),
    array("value" => "ID", "class" => "text-center"),
    array("value" => "status", "class" => "text-center"),
    array("value" => "Nome", "class" => "text-center"),
    array("value" => "Plano", "class" => "text-center"),
    array("value" => "registro", "class" => "text-center")
);
$table = new Table($headers, 1, $paginator);
$sts = array('rascunho', 'publicado', 'excluído');
function dateoutput($dt)
{
    return $dt == Format::$DEFAULT_DATETIME ? '-' : Format::toDateTime($dt);
}
$first = $page != 1;
$last  = $paginator->overflow();
$l = sizeof($list) - 1;
if (empty($list))
    $table->addRow(
        array(
            array("value" => "Não há dados para exibir." . str_replace("{LINK}", 'write-transaction-appointment.php', ' ' . CLICK_HERE_TO_WRITE_ONE), "class" => "text-center", "colspan" => sizeof($headers))
        )
    );
else foreach ($list as $pos => $i) {
    $payment_status = $pagseguro_status_list[$i['payment_status']];
    $menu = array();
    $menu = array_merge($menu, array(
        'javascript:this.toggle(\'TransactionAppointment\',  ' . $i["ID"] . ')' => '<i class="icon-off"></i> ' . TOGGLE,
        'javascript:this.del(\'TransactionAppointment\', ' . $i["ID"] . ')' => '<i class="icon-remove"></i> ' . DELETE
    ));
    $row = array(
        array("value" => Format::getMenu($menu), "class" => "text-center"),
        array("value" => '#' . $i['ID'], "class" => "text-center"),
        array("value" => $payment_status, "class" => "text-center"),
        array("value" => Psychologist::load($i['customerID'])[0]['name'], "class" => "text-center"),
        array("value" => Plans::load($i['planID'])[0]['title'], "class" => "text-center"),
        array("value" => Format::toDateTime($i["registry_date"]), "class" => "text-center")
    );
    $table->addRow($row);
}
$nav = "list-appointments";
$page_title = LIST_OF . "transações de cosultas" . ' <a href="write-transaction-appointment.php"><i class="clip-plus-circle-2 text-success clickable" title="' . INSERT . '"></i></a>';
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
            <?php $paginator->getPrint() ?>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php");
                                Page::script("assets/js/in/transactions.js"); ?>
</body>
<!-- end: BODY -->

</html>