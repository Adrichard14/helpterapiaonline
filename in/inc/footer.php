
<?php if($nav != "login" && isset($app_author) && $app_author != "") { ?>
<!-- start: FOOTER -->

<!-- end: FOOTER -->
<?php }
	$assets = 'assets/js/';
	$plugins = 'lib/plugins/';
	$scripts = array(
		$assets.'jquery.min.js',
		$plugins.'jquery-ui/jquery-ui-1.10.2.custom.min.js',
		$plugins.'bootstrap/js/bootstrap.min.js',
		$plugins.'blockUI/jquery.blockUI.js',
		$plugins.'iCheck/jquery.icheck.min.js',
		$plugins.'perfect-scrollbar/src/jquery.mousewheel.js',
		$plugins.'perfect-scrollbar/src/perfect-scrollbar.js',
//		$assets.'tiny_mce/tiny_mce.js?v=1.0.0.1',
//		$assets.'tiny_mce/plugins/tinybrowser/tb_tinymce.js.php?v=1.0.0.1',
		$assets.'main.js',
		$assets.'modal_constructor.js',
		$assets.'jquery.datetimepicker.js',
		$assets.'jquery.imgareaselect.pack.js',
		$assets.'jquery.priceformat.min.js',
        $plugins.'gritter/js/jquery.gritter.min.js',
        $plugins.'jquery-ui-1.12.1.custom/jquery-ui.min.js',
        $plugins.'select2/select2.min.js',
        $plugins.'summernote/summernote.min.js',
        $plugins.'summernote/lang/summernote-pt-BR.min.js',
        $plugins.'summernote/summernote-cleaner.js?v=1.0',
		$assets.'jquery.inputmask.bundle.min.js',
		$assets.'in/confirm.js?v=1.04',
        $plugins.'slim/slim.jquery.min.js',
        $assets."slim-ctrl.js?v=1.0"//,
        //$assets.'in/notification.js?v=1.04'
	);
	Page::script($scripts);
?>
<style type="text/css">
    .modal-dialog {
        width: 90%;
        max-width: 90%;
    }
    .input-group-addon label {
        width: 155px !important;
    }
</style>
<?php
	if($nav != "login") {
		$fancybox = $plugins."fancybox/source/jquery.fancybox.";
		Page::script($fancybox.'js?v=2.1.5');
		Page::script($fancybox.'css?v=2.1.5" media="screen','css');
?>
<script type="text/javascript">
    Element.prototype.remove = function() { this.parentElement.removeChild(this); }
    function function_exists(f) { return typeof f == "function"; }
    $(document).ready(function() {
        if($('.fancybox') != null) $('.fancybox').fancybox({height: '100%', width: '90%'});
    });
</script>
<style type="text/css">
    .fancybox-custom, .fancybox-skin {
        box-shadow: 0 0 50px #222;
        border-radius: 15px;
    }
    .fancybox-close {
        top: 0;
        right: 0;
    }
</style>
<?php } ?>
<script>
    jQuery(document).ready(function() { Main.init();<?php Display::ModalMessages(); ?>});
</script>