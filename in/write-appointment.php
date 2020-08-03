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
        'name' => '',
        'email' => '',
        'telephone'=>'',
        'doctorID'=>'',
        'date'=>'',
        'type'=>'0',
        'covenantID'=>'',
        'obs'=>'',
        'status' => 1
    );
    $alt = isset($_GET, $_GET['ID']) && intval($_GET['ID']) > 0;
    if($alt) {
        $elem = Appointment::load($_GET['ID'], '0,1', NULL, 2.0);
        if(empty($elem)) {
            Display::Message("err", ' consulta não encontrada.');
            header("location: appointments.php");
            exit();
        }
        $elem = $elem[0];
    }
	$nav = ($alt ? 'alt' : 'add')."-appointments";
	$page_title = WRITER_OF.'consultas';
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
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $elem['name']; ?>" />
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="email" value="<?php echo $elem['email']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <input class="form-control" name="telephone" value="<?php echo $elem['telephone']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Médico</label>
                            <select name="doctorID" class="form-control"> 
                                <option value="<?php echo $elem['doctorID'] ?>" selected>Carregando...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Escolha a data da sua consulta</label>
                            <input class="form-control"  name="date" value="<?php echo $elem['date']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Tipo de consulta</label>
                            <select name="type" class="form-control"> 
                                <?php foreach (Appointment::$TYPES as $t => $tipo) { 
                                    $selected = "";
                                    if($t==$elem['type']){
                                        $selected= " selected";
                                    }
                                    ?>
                                   
                               
                                <option value="<?php echo $t ?>"<?php echo $selected ?>><?php echo $tipo ?></option>
                           <?php } ?> 
                       </select>
                        </div>
                        <div class="form-group" id="covenants">
                            <label>Escolha seu convênio</label>
                            <select name="covenantID" class="form-control"> 
                                <option value="<?php echo $elem['covenantID'] ?>" selected>Carregando...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Observação</label>
                            <textarea class="form-control" name="obs"><?php echo $elem['obs']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Salvar como</label>
                            <select name="status" class="form-control">
                                <option value="0"<?php echo $elem['status'] == 0 ? ' selected' : '';?>>rascunho</option>
                                <option value="1"<?php echo $elem['status'] == 1 ? ' selected' : '';?>>publicado</option>
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
                "assets/js/in/autoform.js",
                "assets/js/in/autoctrl.js",
                "assets/js/in/doctor-ctrl.js",
                "assets/js/in/covenant-ctrl.js",
                "assets/js/in/write-appointment.js"
            ));
        ?>
	</body>
	<!-- end: BODY -->
</html>