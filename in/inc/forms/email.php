<?php
	session_start();
	require_once("../../../lib/classes/Package.php");
	$package = new Package();
	Page::pushBase();
	if(!User::restrict($absolute = true)) {
		exit("ACESSO NEGADO.");
	}
    $elem = array(
        'name' => '',
        'value' => ''
    );
    $alt = isset($_POST, $_POST['ID']) && intval($_POST['ID']) > 0;
    if($alt) {
        $elem = Email::load($_POST['ID'], '0,1', NULL, 2.0);
        if(empty($elem)) {
            exit('E-mail não encontrado.');
        }
        $elem = $elem[0];
    }
?>
<form id="mform" enctype="multipart/form-data">
    <?php if($alt) { ?>
    <input type="hidden" name="ID" value="<?php echo $elem['ID']; ?>" />
    <?php } ?>
<!--
    <div class="form-group">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="<?php echo $elem['name']; ?>" />
    </div>
-->
    <div class="form-group">
        <label>E-mail</label>
        <input type="text" name="value" class="form-control" value="<?php echo $elem['value']; ?>" />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><?php echo SEND; ?></button>
    </div>
</form>