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
    <?php require_once('inc/header.php'); ?>
    <!--end header-->
    <!-- Navbar End -->

    <!-- Start Home -->
    <section class="bg-home" style="background: url('images/topo_help_terapia_online.png') center center; background-size: cover; background-repeat: no-repeat;">
        <!-- <div class="bg-overlay"></div> -->
        <div class="row">
            <div class="container text-white">
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <h3>Vendemos Transformação</h3>
                    <p>Terapia 100% ONLINE: simples, rápido e fácil. Todos os nossos psicólogos são habilitados pelo Conselho Federal de Psicologia para atender online.</p>
                </div>
                <button class="saibaBtn">Saiba mais</button>
            </div>
        </div>

    </section>
    <!-- end home -->
    <!-- popular category start -->
    <section class="section" style="background: #2caf7f;">
        <div class=" container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center text-white mb-4 pb-2">
                        <h2 class="normal mb-4">COMO AGENDAR MEU <strong>PSICÓLOGO(A) ONLINE</strong></h2>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 0 21px;">
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="images/icon_01.png" />
                            </div>
                            <div class="popu-category-content box-popu">
                                <h3 class="mb-2 text-white text-left">Escolha o psicólogo(a)</h3>
                                <p class="mb-0 text-white rounded text-left">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuad</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="images/icon_02.png" />
                            </div>
                            <div class="popu-category-content box-popu">
                                <h3 class="mb-2 text-white text-left">Escolha o dia e horário</h3>
                                <p class="mb-0 text-white rounded text-left">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuad</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="images/icon_03.png" />
                            </div>
                            <div class="popu-category-content box-popu">
                                <h3 class="mb-2 text-white text-left">Efetue o pagamento</h3>
                                <p class="mb-0 text-white rounded text-left">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuad</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 col-xs-12 text-center floating">
                    <a href="#search"> <span class="floating-text">Role para baixo e escolha um psicólogo</span><br>
                        <span id="search" class="floating-text"> </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- popular category end -->
    <!-- SEARCH BAR -->
    <section class="bg-search" style="background: #2caf7f;">
        <!-- <div class="bg-overlay"></div> -->
        <div class="home-center" id="search">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class=" text-center text-white">
                                <h2 class="normal mb-4">Escolher meu <strong>Psicólogo(a)</strong></h2>
                            </div>
                        </div>
                    </div>
                    <?php include('components/search-bar.php') ?>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH BAR -->

    <!-- PROFESSIONALS -->
    <section class="section-professionals">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <center class="title-sec">
                <div class="col-sm-6 col-md-6 col-xs-6 text-center">
                    <h3 class="normal">CONHEÇA ALGUNS <strong>PSICÓLOGOS QUE FAZEM PARTE DO NOSSO TIME</strong></h3>
                </div>
            </center>
            <div class="carousel box-professionals">
                <?php for ($i = 0; $i < 6; $i++) { ?>
                    <div class="col-md-12 col-lg-12 col-xs-12 professionals-image-box" style="background-image:url(./images/profissional.png); background-size: cover; height: 500px; width: 251; border-radius: 12px;">
                        <div class="mask1">
                            <div class="meta" style="position: relative;top: 81%; right: -7%;">
                                <h6 class="text-white">ZÉ CARLOS MACHADO</h6>
                                <span class="title-green">THEO CECATTO</span>
                                <div>
                                    <span class="text-white">55 anos, psicólogo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center col-md-12 col-sm-12 col-xs-12 spaceBtnBefore">
                <button class="allBtn">Ver todos</button>
            </div>
        </div>
    </section>
    <!-- END PROFESSIONALS -->

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
        $('.carousel').slick({
            slidesToShow: 4,
            slidesToScroll: 2,
            autoplay: false,
            autoplaySpeed: 3000,
            arrows: true,
            dots: false,
            centerPadding: 30,
            infinite: false,
            variableWidth: false,
            pauseOnHover: false,
            // customPaging: function(slick, index) {
            //     return $('.thumbnails').eq(index).find('img').prop('outerHTML');
            // },
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: false
                }
            }, {
                breakpoint: 580,
                settings: {
                    slidesToShow: 1,
                    arrows: false
                }
            }, {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 920,
                settings: {
                    slidesToShow: 2
                }
            }]
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <script>
        // $('.professionals-image-box').mouseenter(function() {
        //     $(this).addClass('mask1');
        //     $(this).mouseout(function() {
        //         $(this).removeClass('mask1');
        //     })
        // });
    </script>

</body>

</html>