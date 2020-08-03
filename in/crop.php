<?php
	session_start();
	require_once("../lib/classes/Package.php");
	$package = new Package();
	Page::pushBase();
	if(!User::restrict($absolute = true)) {
		header("location: login.php");
		exit();
	}
    if(!isset($_GET, $_GET['URL'], $_GET['name'], $_GET['w'], $_GET['h']) || $_GET['URL'] == NULL || !file_exists("../".$_GET['URL']) || $_GET['name'] == NULL || intval($_GET['w']) <= 0 || intval($_GET['h']) <= 0) {
        Display::Message("err", IMAGE_CROP_PREPARE_FAILED);
		header("location: index.php");
		exit();
    }
    $URL = $_GET['URL'];
    $name = $_GET['name'];
    $width = intval($_GET['w']);
    $height = intval($_GET['h']);
	$nav = isset($_GET, $_GET['nav']) ? $_GET['nav'] : "crop";
	$page_title = CROPPER;
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
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" id="cropform">
                                <h3 class="text-center">
                                    <button type="submit" class="btn btn-success form-control">
                                        <i class="icon-save"></i>
                                    </button>
                                </h3>
                                <img id="cropimg" src="../<?php echo $URL?>" class="img-responsive" />
                            </form>
                        </div>
                    </div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
        <script>
            window.crop_info = {
                'url': '<?php echo $URL?>',
                'name': '<?php echo $name?>',
                'width': Number('<?php echo $width?>'),
                'height': Number('<?php echo $height?>')
            };
        </script>
		<!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php"); Page::script("assets/js/crop-external.js"); ?>
	</body>
	<!-- end: BODY -->
</html>