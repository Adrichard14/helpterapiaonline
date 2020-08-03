<?php
	session_start();
	require_once("../lib/classes/Package.php");
	$package = new Package();
	Page::pushBase();
	if(!User::restrict($absolute = true)) {
		header("location: login.php");
		exit();
	}
	$page = isset($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) : 1;
	$limit = 25;
	$ready = false;
	while(!$ready) {
		$page_limit = (($page-1)*$limit).",".$limit;
		$list = Queue::load(-1, $page_limit, "`registry_date` DESC", 2.0);
		$ready = !empty($list) || $page == 1;
		if(!$ready) $page--;
	}
	$paginator = new Paginator(Queue::paginator(2.0), "queues.php?page=", $page, $limit);
	$headers = array(
		array("value" => "#", "class" => "text-center"),
		array("value" => "ID", "class" => "text-center"),
		array("value" => "status", "class" => "text-center"),
		array("value" => "assunto", "class" => "text-center"),
		array("value" => "agendamento", "class" => "text-center"),
		array("value" => "data de envio", "class" => "text-center"),
		array("value" => "registro", "class" => "text-center")
	);
	$table = new Table($headers, 1, $paginator);
    $sts = array('rascunho', 'em fila', 'excluído', 'processando', 'enviado');
    function dateoutput($dt) {
        return $dt == Format::$DEFAULT_DATE ? '-' : Format::toDate($dt);
    }
	if(empty($list))
		$table->addRow(
			array(
				array("value" => 'Não há conteúdo para exibir. <a href="write-queue.php">Clique aqui</a> para cadastrar agora.', "class" => "text-center", "colspan" => sizeof($headers))
			)
		);
	else foreach($list as $pos => $i) {
        $menu = array(
			'write-queue.php?ID='.$i["ID"] => '<i class="clip-pencil-3"></i> '.UPDATE,
			'javascript:window.toggle('.$i["ID"].')' => '<i class="icon-off"></i> '.TOGGLE,
			'javascript:window.delete('.$i["ID"].')' => '<i class="icon-remove"></i> '.DELETE
		);
		$row = array(
			array("value" => Format::getMenu($menu), "class" => "text-center"),
			array("value" => '#'.$i['ID'], "class" => "text-center"),
			array("value" => $sts[$i['status']], "class" => "text-center"),
			array("value" => $i['subject'], "class" => "text-center"),
			array("value" => dateoutput($i['execution_date']), "class" => "text-center"),
			array("value" => $i['status'] == 4 ? Format::toDateTime($i['status_date']) : '-', "class" => "text-center"),
			array("value" => Format::toDateTime($i["registry_date"]), "class" => "text-center")
		);
		$table->addRow($row);
	}
	$nav = "list-queues";
	$page_title = LIST_OF.'boletins informativos <a href="write-queue.php"><i class="clip-plus-circle-2 text-success clickable" title="'.INSERT.'"></i></a> <a href="#" onclick="window.run_service();"><i class="clip-paperplane text-warning"></i></a>';
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
								<h1><?php echo $page_title?><?php echo $page_desc != NULL ? " <small>".$page_desc."</small>" : ""; ?></h1>
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
		<!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php"); Page::script("assets/js/in/queues.js?v=1.0"); ?>
	</body>
	<!-- end: BODY -->
</html>