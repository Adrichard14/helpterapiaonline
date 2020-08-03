<?php
$page = StaticPost::load(7, null, null, -1, null);
$page1 = StaticPost::load(8, null, null, -1, null);
$page = $page[0];
$page1 = $page1[0];
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('inc/head.php') ?>

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
        <a href="<?php echo PUBLIC_URL ?>index" class="text-white rounded d-inline-block text-center defaultBtnColor"><i class="mdi mdi-home "></i></a>
    </div>

    <!-- Hero Start -->
    <section class="vh-100" style="background: #FFF;">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="login_page bg-white shadow rounded p-4">
                                <div class="text-center">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help-dark.png" alt="" class="logo-login logo-light" height="48" />
                                    <h4 class="mb-4">Cadastrar-se</h4>
                                </div>
                                <form class="login-form" id="userform" method="POST">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Nome <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Nome" name="name" required="">
                                            </div>
                                        </div>
                                        <input type="hidden" name="nickname">
                                        <!-- <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Sobrenome<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="apelido" name="nickname" required="">
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Login<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Login" name="login" required="">
                                            </div>
                                        </div> -->
                                        <input type="hidden" name="login">
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Seu e-mail (esse será o seu login na plataforma)<span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" placeholder="Email" name="mail" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Telefone<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Telefone" name="telefone" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Data de nascimento<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Data de nascimento" name="data_nasc" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sexo<span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <label class="form-check-label" for="masculino">
                                                        Masculino
                                                    </label>
                                                    <input class="form-group" required type="radio" name="sexo" id="masculino" value="masculino">
                                                    <label class="form-check-label" for="feminino">
                                                        Feminino
                                                    </label>
                                                    <input class="form-group" required type="radio" name="sexo" id="feminino" value="feminino">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>CPF<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="CPF" name="cpf" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Senha <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" placeholder="Senha" name="password" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Confirmar senha <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" placeholder="Confirmar senha" name="password2" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="custom-control m-0 custom-checkbox">
                                                    <input checked type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Eu aceito os <a data-toggle="modal" data-target="#exampleModal" href="#" class="text-primary">Termos e condições</a></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" onclick="javascript:newPatient()" class="btn defaultBtnColor btn-primary w-100">Registrar</button>
                                        </div>
                                        <!-- <div class="col-lg-12 mt-4 text-center">
                                            <h6>Ou cadastre-se com</h6>
                                            <ul class="list-unstyled social-icon mb-0 mt-3">
                                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i class="mdi mdi-facebook" title="Facebook"></i></a></li>
                                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i class="mdi mdi-google-plus" title="Google"></i></a></li>
                                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i class="mdi mdi-github-circle" title="Github"></i></a></li>
                                            </ul>
                                        </div> -->
                                        <div class="mx-auto">
                                            <p class="mb-0 mt-3"><small class="text-dark mr-2">Já tem uma conta?</small> <a href="login.php" class="text-dark font-weight-bold">Faça login</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
    <!-- MODAL TERMS AND CONDITIONS -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-contact">
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="col-sm-9 col-lg-9 flex-center align-center mt-4">
                    <h5 class="text-center normal">Termos e condições</h5>
                </div>
                <div style="height: 530px; overflow: auto; padding: 19px;">

                    <div class="job-detail-desc">
                        <p class="text-muted f-14 mb-3"><?= $page['content'] ?></p>
                    </div>
                    <div class="job-detail-desc">
                        <p class="text-muted f-14 mb-3"><?= $page1['content'] ?></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- MODAL TERMS AND CONDITIONS -->
    <!-- javascript -->
    <?php include('inc/scripts.php') ?>
    <?php
    Page::script(array(
        'out/js/cadastrar.js',
    )); ?>
</body>

</html>