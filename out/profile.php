<?php session_start();

// exit(var_dump(!Psychologist::restrict($absolute = true)));
// exit(var_dump(!Psychologist::restrict()));
// if (!Psychologist::restrict()) {
//     header("location: index");
//     exit();
// }
$user = Psychologist::load($_SESSION[Psychologist::$SESSION]['ID']);
$user = $user[0];
// exit(var_dump($user))

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
$nav = 'profile';
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
    <link href="<?php echo PUBLIC_URL ?>out/css/simple-sidebar.css" rel="stylesheet" id="bootstrap-css">
    <!-- Navigation Bar-->
    <?php include_once('inc/nav-psicologo.php') ?>
    <style>
        .slim[data-ratio*=':'] {
            border-radius: 50%;
        }
    </style>
    <!--end header-->
    <div id="wrapper" class="toggled">
        <!-- Sidebar -->
        <?php include_once('inc/sidebar.php') ?>
        <!-- Page Content -->
        <div id="page-content">
            <!-- SEARCH BAR -->
            <!-- <section class="section vantagens-sec">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="section-title text-center normal">
                                <h2 class="normal text-white  mb-4"><strong>PERFIL DO PSICÓLOGO</strong></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <!-- END SEARCH BAR -->

            <!-- TEAM START -->
            <section class="section" style="background: #F5F6F8;">
                <div class="container">
                    <div class="row justify-content-left">
                        <div class="col-12 mt-60">
                            <div class="section-title">
                                <h5 class="normal">Meu <strong>perfil</strong></h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="custom-form p-4 border rounde bg-white">
                                <form method="POST" id="userform">
                                    <div class="col-md-12 flex-center">
                                        <div class="col-md-4">
                                            <input type="hidden" name="e_psi" value="<?php echo $user['e_psi'] ?>">
                                            <input type="hidden" name="genero" value="<?php echo $user['genero'] ?>">
                                            <input type="hidden" name="data_nasc" value="<?php echo $user['data_nasc'] ?>">
                                            <input type="hidden" name="formacao" value="<?php echo $user['formacao'] ?>">
                                            <input type="hidden" name="instituicao" value="<?php echo $user['instituicao'] ?>">
                                            <input type="hidden" name="login" />
                                            <input type="hidden" name="nickname" />
                                            <input type="hidden" name="curso" value="<?php echo $user['curso'] ?>">
                                            <input type="hidden" name="ano_inicio" value="<?php echo $user['ano_inicio'] ?>">
                                            <input type="hidden" name="ano_conclusao" value="<?php echo $user['ano_conclusao'] ?>">
                                            <input type="hidden" name="plano" value="<?php echo $user['plano'] ?>">
                                            <input type="hidden" name="acao_etica" value="<?php echo $user['acao_etica'] ?>">
                                            <input type="hidden" name="idiomas" value="<?php echo $user['idiomas'] ?>">
                                            <input type="hidden" name="tipo" value="<?php echo $user['tipo'] ?>">
                                            <input type="hidden" name="especialidades" value="<?php echo $user['especialidades'] ?>">
                                            <input type="hidden" name="ID" value="">
                                            <div class="form-group">
                                                <input type="hidden" name="thumb" value="<?php echo $user['thumb']; ?>" />
                                                <div class="slim slim-slide" data-service="out/responses/slim.php" data-ratio="<?php echo Format::ratio(Psychologist::$RESOLUTIONS[0], Psychologist::$RESOLUTIONS[1]); ?>" data-min-size="<?php echo implode(",", Psychologist::$RESOLUTIONS); ?>">
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
                                        </div> -->
                                        <!-- <div class="col-md-4">
                                            <div class="form-group app-label">
                                                <label>Login:</label>
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
                                                <label>CRP<span class="required-field">*</span></label>
                                                <input name="crp" type="text" class="form-control resume" autocomplete="new-password" value="<?php echo $user['crp'] ?>">
                                                <span>Caso seja preciso mudar essa informação, contate um administrador.</span>
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
                                        <div class="col-md-4">
                                            <div class="form-group app-label">
                                                <label>Valor da consulta<span class="required-field">*</span></label>
                                                <input name="valor_consulta" type="text" class="form-control resume" autocomplete="new-password" value="<?php echo $user['valor_consulta'] ?>">
                                                <span>(Valor para cada consulta de 50 minutos)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="form-group app-label">
                                                <label>Seu mini currículo: </label>
                                                <textarea name="mini_curriculo" class="form-control resume"><?php echo $user['mini_curriculo'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group app-label">
                                                <label>Abordagens terapêuticas principais </label>
                                                <textarea name="abordagens_principais" class="form-control resume"><?php echo $user['abordagens_principais'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group app-label">
                                                <label>Abordagens terapêuticas secundárias</label>
                                                <textarea name="abordagens_secundarias" class="form-control resume"><?php echo $user['abordagens_secundarias'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Alterar senha: <span>(opcional)</span></h6>
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
                                        <button type="submit" onclick="javascript:updatePsychologist()" class="btn defaultBtnColor btn-primary w-100">Salvar perfil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- TEAM END -->

    <!-- footer start -->
    <?php //require_once('inc/footer.php'); 
    ?>
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
        array('out/js/alterar-psychologist.js')
    );
    ?>
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
</body>

</html>