<?php session_start();
if (!Psychologist::restrict()) {
    header("location: index");
    exit();
}
$ID = $_SESSION[Psychologist::$SESSION]['ID'];
$psicologo = Psychologist::load($ID)[0];
$today = date('d/m/Y');
$tomorrow = date('d/m/Y', strtotime("+1 day"));
$day3 = date('d/m/Y', strtotime("+2 day"));
$day4 = date('d/m/Y', strtotime("+3 day"));
// exit(var_dump(Workhours::load(-1, NULL, "date DESC", 1, $tomorrow, NULL, $ID)));
$nav = 'agenda';
?>

<!DOCTYPE html>
<html lang="pt-br" class="no-js">
<?php require_once('inc/head.php'); ?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link href="<?php echo PUBLIC_URL ?>out/css/simple-sidebar.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="<?Php echo PUBLIC_URL ?>assets/css/jquery.datetimepicker.css" />

<?php include_once('inc/nav-psicologo.php'); ?>
<div id="wrapper" class="toggled">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <?php include_once('inc/sidebar.php') ?>
    <!-- Page Content -->
    <div id="page-content" style="direction: initial">
        <section class="section" style="background: #F5F6F8; padding: 150px 0; margin-bottom: 100px; height: 100vh;">
            <div class="container">
                <div class="row justify-content-left">
                    <div class="col-12">
                        <div class="section-title pl-4 mb-2 pb-2">
                            <h5 class="normal mb-4">Minha <strong>agenda</strong></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-sm-9 col-md-9 col-lg-5 bg-white mr-4 border-10" style="padding: 25px;">
                            <form method="POST" class="input_fields_wrap" id="wform" enctype="multipart/form-data" autocomplete="off">
                                <div class=" form-group pl-4">
                                    <h5 class="text-black">Clique no botão <strong>adicionar dia e horário</strong> para adicionar horários de atendimento</h5>
                                    <div class="flex-left" style="margin-left: 15px">
                                        <button class="add_field_button"> Adicionar horário <strong>+</strong></button>
                                        <button class="save_schedule" type="submit">Salvar</button>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" required autocomplete="new-password" class="form-control" name="agenda[]" autocomplete="off" />
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-9 col-md-9 col-lg-5 bg-white border-10 horarios" style="padding: 25px;">
                            <h5 class="text-black">Agenda de<strong> dia e horário</strong></h5>
                            <div class="col-sm-12 col-md-12 col-lg-12 table-schedules">

                                <div class="day1">
                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                        <a href="#" class="hour"><?php echo date('d/m') ?></a>
                                    </div>
                                    <?php $horario = Workhours::load(-1, NULL, "hour ASC", 1, $today, NULL, $ID);
                                    if ($horario != null) {
                                        foreach ($horario as $hor) {
                                    ?>
                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="day2">
                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                        <a href="#" class="hour"><?php echo date('d/m', strtotime("+1 day")) ?></a>
                                    </div>
                                    <?php $horario =  Workhours::load(-1, NULL, "hour ASC", 1, $tomorrow, NULL, $ID);
                                    foreach ($horario as $hor) {
                                    ?>
                                        <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                            <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                        </div>

                                    <?php } ?>
                                </div>

                                <div class="day3">
                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                        <a href="#" class="hour"><?php echo date('d/m', strtotime("+2 day")) ?></a>
                                    </div>

                                    <?php $horario = Workhours::load(-1, NULL, "hour ASC", 1, $day3, NULL, $ID);
                                    if ($horario != null) {
                                        foreach ($horario as $hor) {
                                    ?>
                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                            </div>

                                    <?php }
                                    } ?>
                                </div>

                                <div class="day4">
                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                        <a href="#" class="hour"><?php echo date('d/m', strtotime("+3 day")) ?></a>
                                    </div>
                                    <?php $horario =  Workhours::load(-1, NULL, "hour ASC", 1, $day4, NULL, $ID);
                                    if ($horario != null) {
                                        foreach ($horario as $hor) {
                                    ?>
                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                            </div>

                                    <?php }
                                    } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div> <!-- /#page-content-wrapper -->

<!-- Bootstrap core JavaScript -->
<!-- Back to top -->
<?php require_once('inc/scripts.php'); ?>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>assets/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>assets/js/in/write-agenda.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>out/js/bootbox/bootbox.all.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>out/js/bootbox/bootbox.all.min.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>out/js/bootbox/bootbox.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>out/js/bootbox/bootbox.locales.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>out/js/bootbox/bootbox.locales.min.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL ?>out/js/bootbox/bootbox.min.js"></script>
<script>
    $(document).ready(function() {
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-group col-md-12 flex-left"><input type="text" required class="form-control" name="agenda[]" autocomplete="off"/><button href="#" class="remove_field removeBtn" style="margin: 0; ">X</button></div>'); //add input box
                loadCalendar();
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
</script>
<script type="text/javascript">
    function loadCalendar() {
        $("[name='agenda[]']").datetimepicker({
            lang: 'pt-BR',
            format: 'd/m/Y H:i',
            allowBlank: false,
            minDate: '-1970/01/01',
            maxDate: '+1970/01/04',
            opened: false,
            inline: false,
            scrollMonth: false,
            onShow: function(ct) {
                jQuery(this).find('td[data-date="24"]')
                    .addClass('xdsoft_disabled');
            }
        });
    }
    $("[name='agenda[]']").datetimepicker({
        lang: 'pt-BR',
        format: 'd/m/Y H:i',
        allowBlank: false,
        minDate: '-1970/01/01',
        maxDate: '+1970/01/04',
        opened: false,
        inline: false,
        scrollMonth: false,
        onShow: function(ct) {
            jQuery(this).find('td[data-date="24"]')
                .addClass('xdsoft_disabled');
        }
    });
</script>
<script>
    $(function() {
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $(window).resize(function(e) {
            if ($(window).width() <= 768) {
                $("#wrapper").removeClass("toggled");
            } else {
                $("#wrapper").addClass("toggled");
            }
        });
    });
</script>

</html>