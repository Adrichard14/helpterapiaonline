<?php
$assets = 'assets/js/';
$plugins = 'lib/plugins/';
$scripts = array(
    $assets . 'jquery.min.js',
    $plugins . 'jquery-ui/jquery-ui-1.10.2.custom.min.js',
    $plugins . 'perfect-scrollbar/src/jquery.mousewheel.js',
    $plugins . 'perfect-scrollbar/src/perfect-scrollbar.js',
    //		$assets.'tiny_mce/tiny_mce.js?v=1.0.0.1',
    //		$assets.'tiny_mce/plugins/tinybrowser/tb_tinymce.js.php?v=1.0.0.1',
    $assets . 'main.js',
    $assets . 'modal_constructor.js',
    $assets . 'jquery.inputmask.bundle.min.js',
    $assets . 'in/confirm.js?v=1.04',
    $plugins . 'slim/slim.jquery.min.js',
    $assets . "slim-ctrl.js?v=1.0" //,
);
Page::script($scripts);
?>
<!-- javascript -->
<script src="<?php echo PUBLIC_URL ?>out/js/jquery.min.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/jquery.easing.min.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/plugins.js"></script>

<!-- selectize js -->
<script src="<?php echo PUBLIC_URL ?>out/js/selectize.min.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/jquery.nice-select.min.js"></script>

<script src="<?php echo PUBLIC_URL ?>out/js/owl.carousel.min.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/counter.int.js"></script>

<script src="<?php echo PUBLIC_URL ?>out/js/app.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/home.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/js/typeWritter.js"></script>
<script src="<?php echo PUBLIC_URL ?>out/glider/glider.js"></script>
<!-- Slick -->
<script src="<?php echo PUBLIC_URL ?>assets/js/modal_constructor.js"></script>
<script src="<?php echo PUBLIC_URL ?>assets/js/jquery.inputmask.js"></script>
<script>
    $(document).ready(function() {
        $('input[name="telefone"]').inputmask('99-99999-9999');
        // $('input[name="email"]').inputmask('999.999.999-99');
        $('input[name="cpf"]').inputmask('999.999.999-99');
        $('input[name="data_nasc"]').inputmask('99/99/9999', {
            reverse: true
        });
    });

    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
        // Valida 1o digito	
        add = 0;
        for (i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        // Valida 2o digito	
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }
</script>
<!-- <script src="js/slick.js">
    </script>
    <script src="js/slick.min.js"></script> -->