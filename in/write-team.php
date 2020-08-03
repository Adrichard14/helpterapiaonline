<?php
	session_start();
	require_once("../lib/classes/Package.php");
	$package = new Package();
	Page::pushBase();
	if(!User::restrict($absolute = true)) {
		header("location: login.php");
		exit();
	}
    $elem = array(
        'thumb' => '',
        'thumb_tablet' => '',
        'thumb_mobile' => '',
        'title' => '',
        'init_date' => '',
        'end_date' => '',
        'link' => '',
        'content' =>'',
        'CRM'=>'',
        'status' => 1
    );
    $img = 'Imagem';
    $req = ' required';
    $alt = isset($_GET, $_GET['ID']) && intval($_GET['ID']) > 0;
    if($alt) {
        $elem = Team::load($_GET['ID'], '0,1', NULL, 2.0);
        if(empty($elem)) {
            Display::Message("err", SLIDE_NOT_FOUND);
            header("location: team.php");
            exit();
        }
        $elem = $elem[0];
        $regex = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';
        $output = '$3/$2/$1 $4:$5';
        $elem['init_date'] = $elem['init_date'] == Format::$DEFAULT_DATETIME ? "" : preg_replace($regex, $output, $elem['init_date']);
        $elem['end_date'] = $elem['end_date'] == Format::$DEFAULT_DATETIME ? "" : preg_replace($regex, $output, $elem['end_date']);
        $img = 'Trocar imagem';
        $req = '';
    }
	$nav = ($alt ? 'alt' : 'add')."-teams";
	$page_title = WRITER_OF.'equipe';
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
                    <form id="wform" enctype="multipart/form-data">
                        <?php if($alt) { ?>
                        <input type="hidden" name="ID" value="<?php echo $elem['ID']; ?>" />
                        <?php } ?>
                        <div class="form-group">
                            <label>Imagem</label>
                            <input type="hidden" name="thumb" value="<?php echo $elem['thumb']; ?>" />
                            <div class="slim slim-slide" data-service="responses/slim.php" data-ratio="<?php echo Format::ratio(Exam::$DESKTOP[0], Exam::$DESKTOP[1]); ?>" data-min-size="<?php echo implode(",", Exam::$DESKTOP); ?>">
                                <input type="file" name="slim[]" class="form-control" />
                                <?php if($elem['thumb'] != "") { ?>
                                <img src="<?php echo PUBLIC_URL.$elem['thumb']; ?>" alt="" />
                                <?php } ?>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label>Imagem para tablet</label>
                                    <input type="hidden" name="thumb_tablet" value="<?php echo $elem['thumb_tablet']; ?>" />
                                    <div class="slim slim-slide" data-service="responses/slim.php" data-ratio="<?php echo Format::ratio(Slide::$TABLET[0], Slide::$TABLET[1]); ?>" data-min-size="<?php echo implode(",", Slide::$TABLET); ?>" data-fieldname="thumb_tablet">
                                        <input type="file" name="slim[]" class="form-control" />
                                        <?php if($elem['thumb_tablet'] != "") { ?>
                                        <img src="<?php echo PUBLIC_URL.$elem['thumb_tablet']; ?>" alt="" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Imagem para celular</label>
                                    <input type="hidden" name="thumb_mobile" value="<?php echo $elem['thumb_mobile']; ?>" />
                                    <div class="slim slim-slide" data-service="responses/slim.php" data-ratio="<?php echo Format::ratio(Slide::$MOBILE[0], Slide::$MOBILE[1]); ?>" data-min-size="<?php echo implode(",", Slide::$MOBILE); ?>" data-fieldname="thumb_mobile">
                                        <input type="file" name="slim[]" class="form-control" />
                                        <?php if($elem['thumb_mobile'] != "") { ?>
                                        <img src="<?php echo PUBLIC_URL.$elem['thumb_mobile']; ?>" alt="" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $elem['title']; ?>" />
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" class="form-control" value="<?php echo $elem['link']; ?>" />
                        </div>
                        <div class="form-group">
                            <label>CRM</label>
                            <input type="text" class="form-control"name="CRM" value="<?php echo $elem['CRM']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Salvar como</label>
                            <select name="status" class="form-control" onchange="document.getElementById('sdates').style.display = this.value == 1 ? 'block' : 'none';">
                                <option value="0"<?php echo $elem['status'] == 0 ? ' selected' : '';?>>rascunho</option>
                                <option value="1"<?php echo $elem['status'] == 1 ? ' selected' : '';?>>publicado</option>
                            </select>
                        </div>
                        <div id="sdates"<?php echo $elem['status'] == 0 ? ' style="display: none;"' : ''?>>
                            <div class="form-group">
                                <label>Início</label>
                                <input type="text" name="init_date" id="init" class="form-control" value="<?php echo $elem['init_date']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>Término</label>
                                <input type="text" name="end_date" id="end" class="form-control" value="<?php echo $elem['end_date']; ?>" />
                            </div>
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
                "assets/js/in/write-team.js"
            ));
        ?>
	</body>
	<!-- end: BODY -->
</html>