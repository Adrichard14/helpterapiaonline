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
        'subject' => '',
        'content' => '',
        'execution_date' => date("d/m/Y"),
        'status' => 1,
        'emailIDs' => '',
        'image' => ''
    );
    $alt = isset($_GET, $_GET['ID']) && intval($_GET['ID']) > 0;
    if($alt) {
        $elem = Queue::load($_GET['ID'], '0,1', NULL, array(0,1));
        if(empty($elem)) {
            Display::Message("err", 'Boletim informativo não encontrado ou não pode ser mais alterado.');
            header("location: queues.php");
            exit();
        }
        $elem = $elem[0];
        $regex = '/^(\d{4})-(\d{2})-(\d{2})$/';
        $output = '$3/$2/$1';
        $elem['execution_date'] = preg_replace($regex, $output, $elem['execution_date']);
        $emails = QueueEmail::load(-1, NULL, NULL, 1, $elem['ID']);
        $elem['emailIDs'] = array();
        if(!empty($emails))
            foreach($emails as $email) {
                $elem['emailIDs'][] = $email['emailID'];
            }
        $elem['emailIDs'] = implode(Queue::$SEPARATOR, $elem['emailIDs']);
    }
	$nav = ($alt ? 'alt' : 'add')."-queues";
	$page_title = WRITER_OF.'boletins informativos';
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
                        <input type="hidden" name="authorID" value="<?php echo $_SESSION[User::$SESSION]['ID']; ?>" />
                        <?php if($alt) { ?>
                        <input type="hidden" name="ID" value="<?php echo $elem['ID']; ?>" />
                        <?php } ?>
                        <input type="hidden" name="emailIDs" id="emailIDs_output" data-separator="<?php echo Queue::$SEPARATOR; ?>" value="<?php echo $elem['emailIDs']; ?>" />
                        <div class="panel panel-default">
                            <div class="panel-heading" style="padding-top: 3px; padding-left">
                                Alvos
                                <select id="emailIDs_input" class="form-control input-sm" style="display: inline-block; width: 320px; max-width: 70%;">
                                    <option value="<?php echo $elem['emailIDs']; ?>" selected>Carregando...</option>
                                </select>
                                <span><i class="email-select init clip-checkbox-unchecked" title="Selecionar e-mail"></i></span>
                                <span><i class="email-refresh init text-info clip-refresh" title="Atualizar lista"></i></span>
                                <span><i class="email-add init text-success icon-plus-sign-alt" title="Cadastrar e-mail"></i></span>
                            </div>
                            <div class="panel-body" id="emailIDs_draw">
                            </div>
                        </div>
                        <?php if($elem['image'] != "") { ?>
                        <div class="form-group">
                            <label>Imagem de topo atual</label>
                            <img src="<?php echo PUBLIC_URL.$elem['image']; ?>" class="img-responsive" />
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Imagem de topo (opcional)</label>
                            <input type="file" name="img" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Assunto</label>
                            <input type="text" name="subject" class="form-control" value="<?php echo $elem['subject']; ?>" />
                        </div>
                        <div class="form-group">
                            <label>Conteúdo</label>
                            <textarea class="editor" name="content"><?php echo $elem['content']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Data de execução</label>
                            <small><br/>Esta será a data que o sistema tentará enviar todos os e-mails.</small>
                            <input type="text" name="execution_date" id="execution_date" class="form-control" value="<?php echo $elem['execution_date']; ?>" />
                            <small><strong>NOTA:</strong> por haver limites de envios por hora, não há garantias de que todos os e-mails receberão no mesmo dia. Da mesma forma, pode haver outros boletins informativos configurados para o mesmo dia cadastrados previamente. O sistema respeitará a fila dando preferência aos primeiros cadastros.</small>
                        </div>
                        <div class="form-group">
                            <label>Salvar como</label>
                            <select name="status" class="form-control">
                                <option value="0"<?php echo $elem['status'] == 0 ? ' selected' : '';?>>rascunho</option>
                                <option value="1"<?php echo $elem['status'] == 1 ? ' selected' : '';?>>em fila</option>
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
		<!-- end: MAIN CONTAINER --><?php include_once("inc/footer.php"); ?>
        <?php
            Page::script(array(
                "assets/js/in/email-ctrl.js",
                "assets/js/in/write-queue.js"
            )); ?>
	</body>
	<!-- end: BODY -->
</html>