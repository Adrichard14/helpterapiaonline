<?php
$perguntas = FaqAdvantage::load(-1, null, null, 1, null);
?>
<?php session_start(); ?>
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

    <!-- popular category start -->
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
    <section class="section low-padding bg-verde">
        <div class=" container">
            <div class="row row-icons">
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_01.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Confiável</h3>
                                <p class="mb-0 text-white rounded text-left">Prática profissional regulamentada pelo Conselho Federal de Psicologia através da <a target="_blank" style="text-decoration: underline !important;" href="https://site.cfp.org.br/wp-content/uploads/2018/05/RESOLU%C3%87%C3%83O-N%C2%BA-11-DE-11-DE-MAIO-DE-2018.pdf"><b>Resolução nº11/2018.</b></a></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_02.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Eficácia</h3>
                                <p class="mb-0 text-white rounded text-left">Em países que utilizam a modalidade online a muitos anos (EUA e Inglaterra) as pesquisas mostraram que a terapia online é tão eficaz quanto a presencial.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_03b.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Praticidade</h3>
                                <p class="mb-0 text-white rounded text-left">Você é atendido rapidamente, sem burocracia. A plataforma é intuitiva, tudo é simples, rápido e fácil.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_033.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Flexibilidade de Horários</h3>
                                <p class="mb-0 text-white rounded text-left">Escolha o dia e horário de sua preferência, atendemos nos turnos da manhã, tarde e noite.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_03.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Viabilidade Financeira</h3>
                                <p class="mb-0 text-white rounded text-left">Você economiza com deslocamento, estacionamento, oferecemos condições de pagamento facilitadas.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_04.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Sigilo Absoluto</h3>
                                <p class="mb-0 text-white rounded text-left">O consultório virtual da plataforma dispõe de certificados de segurança digital para garantir o sigilo total entre usuário e psicólogo.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_05.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Evita deslocamentos</h3>
                                <p class="mb-0 text-white rounded text-left">Você não precisa perder tempo preso no trânsito.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_06.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Comodiade</h3>
                                <p class="mb-0 text-white rounded text-left">Consulta audiovisual em tempo real com seu psicólogo no conforto do seu lar.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_07.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Psicólogos especializados</h3>
                                <p class="mb-0 text-white rounded text-left">Todos os nossos profissionais são habilitados pelo Conselho Federal de Psicologia para atender online.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- popular category end -->


    <!-- FAQ start -->
    <?php if (isset($perguntas[0])) { ?>
        <section class="section" id="faq">
            <div class="container">
                <div class="row row-icons">
                    <div class="col-lg-12">
                        <div class="faq-content">
                            <h4 class="text-dark">Perguntas frequentes</h4>
                            <div class="faq-content mt-3">
                                <div class="accordion" id="accordionExample">
                                    <?php foreach ($perguntas as $faq) { ?>
                                        <div class="card border rounded shadow mb-3">
                                            <a data-toggle="collapse" href="#collapse<?= $faq['ID'] ?>" class="faq position-relative" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="card-header bg-acordeon p-3" id="heading<?= $faq['ID'] ?>">
                                                    <h4 class="title text-white mb-0 faq-question"><?= $faq['question'] ?></h4>
                                                </div>
                                            </a>
                                            <div id="collapse<?= $faq['ID'] ?>" class="collapse" aria-labelledby="heading<?= $faq['ID'] ?>" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p class="text-muted mb-0 faq-ans"><?= $faq['answer'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    <!-- FAQ END -->


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