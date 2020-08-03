<?php
	if(!isset($_POST['URL'])) exit("Comando inválido.");
	session_start();
	require_once("../../../lib/classes/Package.php");
	$package = new Package();
	if(!User::restrict($absolute = true))
        exit(ACCESS_DENIED);
?>
<div class="row">
    <div class="col-xs-12">
        <form method="post" id="cropform">
            <h3 class="text-center">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="icon-save"></i>
                </button>
            </h3>
	        <img id="cropimg" src="../<?php echo $_POST['URL']?>" class="img-responsive" />
        </form>
    </div>
</div>