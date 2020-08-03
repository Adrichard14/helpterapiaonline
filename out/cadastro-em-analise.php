<?php
session_start();
if (isset($_SESSION['l@#$@e@#r2'])) {
    session_destroy();
};
if (Client::restrict()) {
    header("location: index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

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

    <div class="back-to-home rounded d-none d-sm-block">
        <a href="<?php echo PUBLIC_URL ?>index" class="text-white rounded d-inline-block text-center"><i class="mdi mdi-home"></i></a>
    </div>

    <!-- Hero Start -->
    <section class="vh-100" style="background: #FFF">

        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-9">
                            <div class="login-page bg-white shadow rounded p-4">
                                <div class="text-center">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help-dark.png" alt="" class="logo-login logo-light" height="48" />
                                    <h4 class="mb-4">Seu perfil está sendo analisado pela HELP! Após a aprovação do seu perfil iremos te enviar um e-mail e você poderá realizar o login!</h4>
                                </div>
                            </div>
                            <!---->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end container-->
            </div>
        </div>
    </section>
    <!--end section-->
    <!-- Hero End -->

    <?php require_once('inc/scripts.php') ?>
    <?php
    Page::script(array(
        'assets/js/modal_constructor.js',
        'out/js/login.js'
    )); ?>
</body>

</html>