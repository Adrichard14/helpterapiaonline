<?php session_start();
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
    <style>
        .glider-contain {
            width: 100%;
            max-width: 1150px;
            margin: 0 auto;
        }

        .glider.draggable {
            padding: 15px 0
        }

        .glider-prev {
            left: -41px;
        }

        .glider-prev,
        .glider-next {
            /* left: -37px; */
            border: 0;
            top: 47%;
        }

        
    </style>
    <!-- Navigation Bar-->
    <?php require_once('inc/header.php'); ?>
    <!--end header-->
    <!-- Navbar End -->

    <!-- Start Home -->
    <div class="bg-verde">
        <section class="bg-home" style="background: url('<?php echo PUBLIC_URL ?>out/images/topo_home.png') center center; background-size: cover; background-repeat: no-repeat;">
            <!-- <div class="bg-overlay"></div> -->
            <div class="row" style="margin-right: 0 !important;">
                <div class="container text-white">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                        <h3>Terapia Online</h3>
                        <p>Sessões de terapia no conforto do seu lar.</p>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xs-12" id="divSearch">
                        <img src="<?php PUBLIC_URL ?>out/images/barra.png" id="imageSearch" />
                        <p id="textWritter">Marque um encontro consigo mesmo</p>
                    </div>
                    <button class="saibaBtn"><a href="#psi">Saiba mais</a></button>

                </div>
            </div>

        </section>
    </div>
    <!-- end home -->
    <!-- popular category start -->
    <section class="section" id="psi" style="background: #2caf7f;">
        <div class="container">
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
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_01.png" />
                            </div>
                            <div class="popu-category-content box-popu">
                                <h3 class="mb-2 text-white text-left">Escolha o psicólogo(a)</h3>
                                <p class="mb-0 text-white rounded text-left">Todos os profissionais são habilitados pelo Conselho Federal de Psicologia para atender online.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_02.png" />
                            </div>
                            <div class="popu-category-content box-popu">
                                <h3 class="mb-2 text-white text-left">Escolha o dia e horário</h3>
                                <p class="mb-0 text-white rounded text-left">Agende suas sessões por videochamada, horários flexíveis.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_03.png" />
                            </div>
                            <div class="popu-category-content box-popu">
                                <h3 class="mb-2 text-white text-left">Efetue o pagamento</h3>
                                <p class="mb-0 text-white rounded text-left"> Pronto! Agora é só começar sua jornada de transformação! É simples, rápido e fácil.</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 col-xs-12 text-center floating">
                    <a href="#search"> <span class="floating-text">Role para baixo e </br>escolha um psicólogo</span><br>
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
                    <?php include('components/search-bar.php'); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH BAR -->

    <!-- PROFESSIONALS -->

    <!-- <section class="section-professionals">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <center class="title-sec">
                <div class="col-sm-6 col-md-6 col-xs-6 text-center">
                    <h3 class="normal">CONHEÇA ALGUNS <strong>PSICÓLOGOS QUE FAZEM PARTE DO NOSSO TIME</strong></h3>
                </div>
            </center>
            <div class="glider-contain">
                <div class="glider">
                    <?php for ($i = 0; $i < 6; $i++) { ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 professionals-image-box" style="background-image:url(<?php echo PUBLIC_URL ?>out/images/profissional.png); background-size: cover;  border-radius: 12px;">
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
                <button class="slick-prev slick-arrow glider-prev" type="button" aria-disabled="false"></button>
                <button class="slick-next slick-arrow glider-next" type="button" aria-disabled="false"></button>
                <div id="dots"></div>
            </div>
            <div class="text-center col-md-12 col-sm-12 col-xs-12 spaceBtnBefore">
                <button class="allBtn">Ver todos</button>
            </div>
        </div>
    </section> -->
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
    <?php require_once('inc/scripts.php'); ?>
    <script type="text/javascript">
        const text = document.querySelector('#textWritter');
        typeWritter(text);
    </script>
    <script>
        //GLIDER SCRIPT
        // window.addEventListener('load', function() {
        //     document.querySelector('.glider').addEventListener('glider-slide-visible', function(event) {
        //         var glider = Glider(this);
        //         console.log('Slide Visible %s', event.detail.slide)
        //     });
        //     document.querySelector('.glider').addEventListener('glider-slide-hidden', function(event) {
        //         console.log('Slide Hidden %s', event.detail.slide)
        //     });
        //     document.querySelector('.glider').addEventListener('glider-refresh', function(event) {
        //         console.log('Refresh')
        //     });
        //     document.querySelector('.glider').addEventListener('glider-loaded', function(event) {
        //         console.log('Loaded')
        //     });

        //     window._ = new Glider(document.querySelector('.glider'), {
        //         slidesToShow: 1, //'auto',
        //         slidesToScroll: 1,
        //         itemWidth: 150,
        //         draggable: true,
        //         itemWidth: 240,
        //         scrollLock: false,
        //         rewind: true,
        //         arrows: {
        //             prev: '.glider-prev',
        //             next: '.glider-next'
        //         },
        //         responsive: [{
        //                 breakpoint: 800,
        //                 settings: {
        //                     slidesToScroll: 2,
        //                     itemWidth: 300,
        //                     slidesToShow: 3,
        //                     exactWidth: true
        //                 }
        //             },
        //             {
        //                 breakpoint: 700,
        //                 settings: {
        //                     slidesToScroll: 2,
        //                     slidesToShow: 2,
        //                     dots: false,
        //                     arrows: false,
        //                 }
        //             },
        //             {
        //                 breakpoint: 600,
        //                 settings: {
        //                     slidesToScroll: 2,
        //                     slidesToShow: 2
        //                 }
        //             },
        //             {
        //                 breakpoint: 500,
        //                 settings: {
        //                     slidesToScroll: 1,
        //                     slidesToShow: 1,
        //                     dots: false,
        //                     arrows: false,
        //                     scrollLock: true
        //                 }
        //             }
        //         ]
        //     });
        // });
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