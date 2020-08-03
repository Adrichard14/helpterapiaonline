<?php
session_start();
// exit(var_dump(!C::restrict()));
if (!Client::restrict()) {
    header("location: index");
    exit();
}
$user = Client::load($_SESSION['l@#$@e@#r']['ID']);
$user = $user[0];

?>
<!DOCTYPE html>
<html lang="pt-br" class="no-js">

<?php require_once('inc/head.php'); ?>
<?php
$css = 'assets/css/';
$fonts = 'assets/fonts/';
$plugins = 'lib/plugins/';
$scripts = array(
    $css . 'main-responsive.css',
    $css . 'imgareaselect-default.css',
    $plugins . 'jquery-ui-1.12.1.custom/jquery-ui.min.css',
    $plugins . 'select2/select2.css',
    $plugins . 'select2/select2-bootstrap.css',
    $plugins . 'summernote/summernote.css',
    $plugins . 'slim/slim.min.css'
);
Page::script($scripts, "css");
?>

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
    <style>
        .slim[data-ratio*=':'] {
            border-radius: 50%;
        }
    </style>
    <!--end header-->
    <!-- SEARCH BAR -->
    <section class="section vantagens-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center normal">
                        <h2 class="normal text-white  mb-4">SEU <strong>PERFIL</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH BAR -->

    <!-- TEAM START -->
    <section class="section" style="background: #F5F6F8;">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="custom-form p-4 border rounded bg-white">
                        <form method="POST" id="userform">
                            <div class="col-md-12 flex-center">
                                <div class="col-md-4">
                                    <input type="hidden" name="ID" value="<?= $_SESSION['l@#$@e@#r']['ID'] ?>">
                                    <input type="hidden" name="sexo" value="<?= $user['sexo'] ?>">
                                    <input type="hidden" name="nickname" value="<?= $user['nickname'] ?>">
                                    <input type="hidden" name="login" value="<?= $user['login'] ?>">
                                    <div class="form-group">
                                        <input type="hidden" name="thumb" value="<?php echo $user['thumb']; ?>" />
                                        <div class="slim slim-slide" data-service="out/responses/slim.php" data-ratio="<?php echo Format::ratio(Client::$RESOLUTIONS[0], Client::$RESOLUTIONS[1]); ?>" data-min-size="<?php echo implode(",", Client::$RESOLUTIONS); ?>">
                                            <input type="file" name="slim[]" class="form-control" />
                                            <?php if ($user['thumb'] != NULL) { ?>
                                                <img src="<?php echo PUBLIC_URL . $user['thumb']; ?>" alt="" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group app-label">
                                        <label>Nome<span class="required-field">*</span></label>
                                        <input id="first-name" type="text" name="name" class="form-control resume" value="<?php echo $user['name']; ?>" placeholder="Nome">
                                    </div>
                                </div>
                                <input type="hidden" name="ID" value="<?php echo $user['ID'] ?>">
                                <!-- <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Sobrenome<span class="required-field">*</span></label>
                                        <input id="nickname" value="<?php echo $user['nickname']; ?>" name="nickname" type="text" class="form-control resume" placeholder="Apelido">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Login<span class="required-field">*</span></label>
                                        <input id="nickname" value="<?php echo $user['login']; ?>" name="login" type="text" class="form-control resume" placeholder="Login">
                                    </div>
                                </div> -->
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Email<span class="required-field">*</span></label>
                                        <input name="mail" type="email" class="form-control resume" autocomplete="new-password" value="<?php echo $user['mail'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Telefone<span class="required-field">*</span></label>
                                        <input name="telefone" type="text" class="form-control resume" autocomplete="new-password" value="<?php echo $user['telefone'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Data de nascimento<span class="required-field">*</span></label>
                                        <input name="data_nasc" type="text" class="form-control resume" autocomplete="new-password" value="<?php echo $user['data_nasc'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>CPF<span class="required-field">*</span></label>
                                        <input name="cpf" type="text" class="form-control resume" autocomplete="new-password" value="<?php echo $user['cpf'] ?>">
                                    </div>
                                </div>
                            </div>
                            <h6>Alterar senha <span>(opcional)</span></h6>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Nova senha:</label>
                                        <input name="password" type="password" class="form-control resume" placeholder="Nova senha" autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group app-label">
                                        <label>Repita a nova senha:</label>
                                        <input name="password2" type="password" class="form-control resume" placeholder="Repita a nova senha">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" onclick="javascript:updateClient()" class="btn defaultBtnColor btn-primary w-100">Salvar perfil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM END -->

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
    <?php require_once('inc/scripts.php');
    Page::script(
        array(
            'out/js/alterar-client.js'
        )
    );
    ?>
</body>

</html>