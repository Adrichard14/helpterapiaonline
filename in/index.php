<?php
	session_start();
	require_once("../lib/classes/Package.php");
	$package = new Package();
	Page::pushBase();
	if(!User::restrict($absolute = true)) {
		header("location: login.php");
		exit();
	}
	$nav = "index";
	$page_title = HOME;
	$page_desc = NULL;
    $time = 9;
    $period = 'months';
    $periods = array('days', 'months', 'years');
    switch($period) {
        case $periods[0]:
            $periods_ = $time != 1 ? DAYS : DAY;
            break;
        case $periods[1]:
            $periods_ = $time != 1 ? MONTHS : MONTH;
            break;
        case $periods[2]:
            $periods_ = $time != 1 ? YEARS : YEAR;
            break;
    }
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
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <header class="panel-heading">
                                    <i class="clip-stats"></i>
                                    <?php echo str_replace('{PERIOD}', $periods_, str_replace('{TIME}', $time."", HOME_STATISTIC_TITLE)); ?>
                                </header>
                                <div class="panel-body">
                                    <div class="flot-container">
                                        <div id="statistic" class="flot-placeholder"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php"); ?>
        <?php
            $months = array("Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
            $pageviews = $visitors = array();
            for($i=$time-1;$i>=0;$i--) {
                $ctime = strtotime("-".$i.$period);
                $Y = date("Y", $ctime);
                $m = date("m", $ctime);
                $Yint = intval($Y);
                $mint = intval($m);
                $v = View::pageViews($m, $Y);
                $month = $months[$mint-1];
                if(empty($v)) {
                    $pageviews[] = array($month, 0);
                    $visitors[] = array($month, 0);
                } else {
                    $pageviews[] = array($month, $v[0]['pageviews']);
                    $visitors[] = array($month, $v[0]['visits']);
                }
            }
        ?>
		<script type="text/javascript">
            var pageviews = <?php echo json_encode($pageviews); ?>;
            var visitors = <?php echo json_encode($visitors); ?>;
        </script>
        <?php
			$flot = 'lib/plugins/flot/jquery.flot.';
			$scripts = array(
				$flot.'js',
				$flot.'resize.js',
				$flot.'categories.js',
				$flot.'pie.js',
				'assets/js/in/Index.js?v=1.0'
			);
			Page::script($scripts);
		?>
	</body>
	<!-- end: BODY -->
</html>