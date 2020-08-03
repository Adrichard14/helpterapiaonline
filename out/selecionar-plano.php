<?php session_start();
if (!Psychologist::restrict()) {
    header("location: index");
    exit();
}
$ID = $_SESSION[Psychologist::$SESSION]['ID'];
$psicologo = Psychologist::load($ID)[0];
$planos = Plans::load(-1);
$selected_plan = $psicologo['plano'];
// var_dump($planos);
?>
<!DOCTYPE html>
<html lang="pt-br" class="no-js">

<?php require_once('inc/head.php'); ?>

<body>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Loader -->

    <!-- Navigation Bar-->
    <header id="topnav" class="defaultscroll scroll-active">
        <!-- Tagline STart -->

        <div class="tagline">
            <div class="container">
                <div class="float-left">
                    <div class="phone">
                        <i class="mdi mdi-phone-classic"></i> +1 800 123 45 67
                    </div>
                    <div class="email">
                        <a href="#">
                            <i class="mdi mdi-email"></i> Support@mail.com
                        </a>
                    </div>
                </div>
                <div class="float-right">
                    <ul class="topbar-list list-unstyled d-flex" style="margin: 11px 0px;">
                        <li class="list-inline-item"><a href="javascript:void(0);"><i class="mdi mdi-account mr-2"></i>Benny Simpson</a></li>
                        <li class="list-inline-item">
                            <select id="select-lang" class="demo-default">
                                <option value="">Language</option>
                                <option value="4">English</option>
                                <option value="1">Spanish</option>
                                <option value="3">French</option>
                                <option value="5">Hindi</option>
                            </select>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Tagline End -->

        <!-- Menu Start -->
        <div class="container" style="width: 100% !important;">
            <!-- Logo container-->

            <div>
                <a href="<?php echo PUBLIC_URL ?>index" class="logo">
                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-light" height="48" />
                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-dark" height="48" />
                </a>



            </div>
            <!-- <div class="buy-button">
            <a href="post-a-job.html" class="btn btn-primary"><i class="mdi mdi-cloud-upload"></i> Post a Job</a>
        </div> -->
            <!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">

                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
            <div id="navigation">
            </div>
            <!--end navigation-->
        </div>
        <!--end container-->
        <!--end end-->
    </header>
    <!--end header-->

    <!-- Prices start -->
    <section class="section bg-verde" style="padding-bottom: 10px !important">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-white text-center mb-5 pb-3">
                        <h4 class="normal">ESCOLHA SEU <strong>PLANO</strong> E PROSSIGA PARA O PAGAMENTO </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section style="padding-top: 40px;">
        <div class="container">
        <div class="row">
            <?php if (isset($planos[1])) { ?>
                <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0 <?php echo $selected_plan == 2 ? 'price-box-effect' : '' ?>">
                    <div class="pricing-box border plan-1 rounded-price pt-4 pb-4">
                        <div class="pl-2 pr-2">
                            <h6 class="text-center text-white text-uppercase font-weight-bold"><?= $planos[1]['title'] ?></h6>
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
                <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0 <?php echo $selected_plan == 3 ? 'price-box-effect' : '' ?>">
                    <div class="pricing-box border plan-2 rounded-price pt-4 pb-4">
                        <div class="pl-2 pr-2">
                            <h6 class="text-center text-white text-uppercase font-weight-bold"><?= $planos[0]['title'] ?></h6>
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
                <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0 <?php echo $selected_plan == 4 ? 'price-box-effect' : '' ?>">
                    <div class="pricing-box border plan-dark rounded-price pt-4 pb-4">
                        <div class="pl-2 pr-2">
                            <h6 class="text-center text-white text-uppercase font-weight-bold"><?= $planos[2]['title'] ?></h6>
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

    <!-- footer start -->
    <?php require_once('inc/footer.php'); ?>
    <!-- footer end -->

    <!--end footer-->
    <!-- Footer End -->

    <!-- Back to top -->
    <a href="#" class="back-to-top rounded text-center" id="back-to-top">
        <i class="mdi mdi-chevron-up d-block"> </i>
    </a>
    <!-- Back to top -->
    <?php require_once('inc/scripts.php') ?>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

</body>

</html>