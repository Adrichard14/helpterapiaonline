<?php session_start();
// exit(var_dump($_VARS));
// $ID = implode("/", $_VARS);
// $event = WorkEvents::load($ID)[0];
// $psi = Psychologist::load($event['workerID']);
// $client = Client::load($event['clientID']);
// exit(var_dump($client));
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
    <?php require_once('inc/header.php'); ?>
    <!--end header-->
    <!-- Navbar End -->
    <section class="section vantagens-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center normal">
                        <h2 class="normal text-white  mb-4">VANTAGENS DO ATENDIMENTO <strong>DA HELP!</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- popular category start -->
    <section class="section sectionConsulta">
        <div class=" container">
            <div class="row">
                <div class="col-12 flex-center items-center direction-column">
                    <div class="col-md-6 col-sm-6 col-lg-4 col-xs-9" style="padding: 0; margin: 0;">
                        <div class="image-wrap">
                            <img alt="imagem" src="<?php echo PUBLIC_URL ?>out/images/teste.png" style="width: 100%; height: auto" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-4 col-xs-9 flex-center direction-column box-consulta items-center">
                        <div class="meta-consulta">
                            <h5>Adrian Richard</h5>
                            <h6>20 de maio</h6>
                        </div>
                        <div>
                            <a class="btn callBtn"><span class="mdi mdi-video icon-camera"></span>Realizar vídeo chamada agora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- popular category end -->
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