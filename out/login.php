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
        <a href="<?php echo PUBLIC_URL ?>index" class="text-white rounded d-inline-block text-center defaultBtnColor"><i class="mdi mdi-home"></i></a>
    </div>

    <!-- Hero Start -->
    <section class="vh-100" style="background: #FFF">

        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="login-page bg-white shadow rounded p-4">
                                <div class="text-center">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help-dark.png" alt="" class="logo-login logo-light" height="48" />
                                    <h4 class="mb-4">Faça login e começe sua jornada!</h4>
                                </div>
                                <form class="login-form" method="post" data-id="experimente_gratis_login" id="form_login" data-name="">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                                <label>Seu e-mail <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" placeholder="Email" name="login" required="">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                                <label>Senha <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" placeholder="Password" name="password" required="">
                                            </div>
                                        </div>

                                        <div class=" col-lg-12">
                                            <p class="float-right forgot-pass"><a href="<?php echo PUBLIC_URL?>recuperar-senha-user" class="text-dark font-weight-bold">Esqueceu a senha?</a></p>
                                        </div>
                                        <div class="col-lg-12 mb-0">
                                            <button type="submit" class="btn btn-primary w-100 defaultBtnColor">Entrar</button>
                                        </div>
                                        <div class="col-12 text-center">
                                            <p class="mb-0 mt-3"><small class="text-dark mr-2">Não tem uma conta?</small> <a href="<?php echo PUBLIC_URL ?>cadastrar" class="text-dark font-weight-bold">Cadastre-se</a></p>
                                        </div>
                                    </div>
                                </form>
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