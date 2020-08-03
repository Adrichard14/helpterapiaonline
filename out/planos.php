<?php session_start();
if (!Psychologist::restrict()) {
    header("location: index");
    exit();
}
$ID = $_SESSION[Psychologist::$SESSION]['ID'];
$psicologo = Psychologist::load($ID)[0];

$planos = Plans::load(-1);
// exit(var_dump(Workhours::load(-1, NULL, "date DESC", 1, $tomorrow, NULL, $ID)));
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

<nav class="navbar navbar-expand navbar-dark fixed-top bg-verde"> <a href="#menu-toggle" id="menu-toggle" class="navbar-brand"><span class="navbar-toggler-icon"></span></a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse container" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
            <div>
                <a href="<?php echo PUBLIC_URL ?>index" class="logo">
                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-light" height="48" />
                </a>
            </div>
        </ul>
        <form class="form-inline my-2 my-md-0"> </form>
    </div>
</nav>
<div id="wrapper" class="toggled">
    <!-- Sidebar -->
    <?php include_once('inc/sidebar.php') ?>
    <!-- Page Content -->
    <div id="page-content" style="direction: initial">
        <section class="section" id="psi" style="background: #ccc;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center text-white mb-4 pb-2">
                            <h2 class="normal mb-4">Sua agenda</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if (isset($planos[1])) { ?>
                        <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0">
                            <div class="pricing-box border plan-1 rounded-price pt-4 pb-4">
                                <div class="pl-2 pr-2">
                                    <h6 class="text-center text-white text-uppercase font-weight-bold">Plano Trimestral</h6>
                                    <p class="text-white text-center mb-5 price mt-3 p-1"><span class="text-white font-weight-normal h1"><sup class="h5">R$</sup><?= $planos[1]['price'] ?> </span></p>
                                    <div class="pricing-plan-item pd-textPlan text-center">
                                        <ul class="list-unstyled mb-4">
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i>Trimestral - Valor Integral</li>
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i><?= Format::toMoney(substr(($planos[1]['price'] / 2), 0, 4)) ?>/<sup>mês</sup></li>
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i>Parcela única</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="text-center  p-4">
                                    <a href="<?php PUBLIC_URL ?>confirmar-pagamento/&planID=<?= $planos[1]['ID'] ?>" class="btn border-23 btnColor2 text-white">Assinar</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($planos[0])) { ?>
                        <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0 price-box-effect">
                            <div class="pricing-box border plan-2 rounded-price pt-4 pb-4">
                                <div class="pl-2 pr-2">
                                    <h6 class="text-center text-white text-uppercase font-weight-bold">Plano Semestral</h6>
                                    <p class="text-white text-center mb-5 price mt-3 p-1"><span class="text-white font-weight-normal h1"><sup class="h5">R$</sup><?= $planos[0]['price'] ?> </span></p>
                                    <div class="pricing-plan-item pd-textPlan text-center">
                                        <ul class="list-unstyled mb-4">
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i>Trimestral - Valor Integral</li>
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i><?= Format::toMoney(substr(($planos[0]['price'] / 6), 0, 4)); ?>/<sup>mês</sup></li>
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i>Parcela única</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="text-center  p-4">
                                    <a href="<?php PUBLIC_URL ?>confirmar-pagamento/&planID=<?= $planos[0]['ID'] ?>" class="btn border-23 btnColor2 text-white">Assinar</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($planos[2])) { ?>
                        <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0">
                            <div class="pricing-box border plan-dark rounded-price pt-4 pb-4">
                                <div class="pl-2 pr-2">
                                    <h6 class="text-center text-white text-uppercase font-weight-bold">Plano Anual</h6>
                                    <p class="text-white text-center mb-5 price mt-3 p-1"><span class="text-white font-weight-normal h1"><sup class="h5">R$</sup><?= $planos[2]['price'] ?> </span></p>
                                    <div class="pricing-plan-item pd-textPlan text-center">
                                        <ul class="list-unstyled mb-4">
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i>Trimestral - Valor Integral</li>
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i><?= Format::toMoney(substr(($planos[2]['price'] / 12), 0, 4)) ?>/<sup>mês</sup></li>
                                            <li class="text-white mb-2"><i class="mdi mdi-minus mr-2"></i>Parcela única</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="text-center  p-4">
                                    <a href="<?php PUBLIC_URL ?>confirmar-pagamento/&planID=<?= $planos[2]['ID'] ?>" class="btn border-23 btnColor2 text-white">Assinar</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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