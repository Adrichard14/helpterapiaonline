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
		$list = Email::load(-1, $page_limit, "`registry_date` DESC", 2.0);
		$ready = !empty($list) || $page == 1;
		if(!$ready) $page--;
	}
	$paginator = new Paginator(Email::paginator(2.0), "emails.php?page=", $page, $limit);
	$headers = array(
		array("value" => "#", "class" => "text-center"),
		array("value" => "ID", "class" => "text-center"),
		array("value" => "status", "class" => "text-center"),
//		array("value" => "nome", "class" => "text-center"),
		array("value" => "e-mail", "class" => "text-center"),
		array("value" => "registro", "class" => "text-center")
	);
	$table = new Table($headers, 1, $paginator);
    $sts = array('desativado', 'ativo', 'excluído');
    function dateoutput($dt) {
        return $dt == Format::$DEFAULT_DATETIME ? '-' : Format::toDateTime($dt);
    }
	if(empty($list))
		$table->addRow(
			array(
				array("value" => 'Não há conteúdo para exibir. <a href="write-email.php">Clique aqui</a> para cadastrar agora.', "class" => "text-center", "colspan" => sizeof($headers))
			)
		);
	else foreach($list as $pos => $i) {
        $menu = array(
			'write-email.php?ID='.$i["ID"] => '<i class="clip-pencil-3"></i> '.UPDATE,
			'javascript:window.toggle('.$i["ID"].')' => '<i class="icon-off"></i> '.TOGGLE,
			'javascript:window.delete('.$i["ID"].')' => '<i class="icon-remove"></i> '.DELETE
		);
		$row = array(
			array("value" => Format::getMenu($menu), "class" => "text-center"),
			array("value" => '#'.$i['ID'], "class" => "text-center"),
			array("value" => $sts[$i['status']], "class" => "text-center"),
//			array("value" => $i['name'], "class" => "text-center"),
			array("value" => $i['value'], "class" => "text-center"),
			array("value" => Format::toDateTime($i["registry_date"]), "class" => "text-center")
		);
		$table->addRow($row);
	}
	$nav = "list-emails";
	$page_title = LIST_OF.'e-mails <a href="write-email.php"><i class="clip-plus-circle-2 text-success clickable" title="'.INSERT.'"></i></a>';
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
		<!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php"); Page::script("assets/js/in/emails.js"); ?>
	</body>
	<!-- end: BODY -->
</html>