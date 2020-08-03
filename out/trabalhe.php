<?php session_start();
$planos = Plans::load(-1);
$perguntas = Faq::load(-1, null, null, 1, null);
// exit(var_dump($perguntas));
?>
<!DOCTYPE html>
<html lang="pt-br" class="no-js">

<?php require_once('inc/head.php'); ?>

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v7.0" nonce="yMcrqhO6"></script>
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
    <div class="bg-roxo">
        <section class="bg-home" style="background: url('<?php echo PUBLIC_URL ?>out/images/topo_psi.png') center center; background-size: cover; background-repeat: no-repeat;">
            <!-- <div class="bg-overlay"></div> -->
            <div class="row">
                <div class="container text-white">
                    <div class="col-sm-6 col-md-5 col-xs-12">
                        <h3>Faça parte da rede de especialistas Help!</h3>
                        <p>Atenda pacientes de qualquer parte do mundo</p>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xs-12" id="divSearch">
                        <img src="<?php PUBLIC_URL ?>out/images/barra_roxa.png" id="imageSearch" />
                        <p id="textWritter">A Terapia Online veio para ficar</p>
                    </div>
                    <button class="saibaBtn font-bold"><a href="#comofazerparte">Quero atender na Help!</a></button>
                </div>
            </div>

        </section>
    </div>
    <!-- end home -->
    <!-- popular category start -->
    <section class="section bg-roxo" id="comofazerparte">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center text-white mb-4 pb-2">
                        <h3 class="normal mb-4">COMO FAZER PARTE DA EQUIPE DE <strong>PSICÓLOGOS(AS) DA HELP?</strong></h3>
                    </div>
                </div>
            </div>
            <div class="row row-icons">
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box hover_icon_roxo rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_trabalhe_01.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Cadastre seu currículo</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Cadastre seus dados pessoais e profissionais na plataforma. </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box hover_icon_roxo rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_trabalhe_02.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Pagamento do plano</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Escolha um plano de sua preferência e efetue o pagamento.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box hover_icon_roxo rounded text-center p-4">
                            <div class="popu-category-icon flex-left mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_trabalhe_03.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Validação do cadastro</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Verificaremos seus dados e se estiver tudo correto em até 24h você será integrado a nossa rede de especialistas!
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-12 flex-center col-xs-12 text-center float-left faleDiv">
                    <button class="saibaBtn left font-bold" data-toggle="modal" data-target="#exampleModal">Entre em contato</button>
                    <h6 class="textFale text-white">Ou fale direto pelo<a target="_blank" href="https://api.whatsapp.com/send?phone=554998279091&text=Ol%C3%A1%2C%20gostaria%20de%20atender%20na%20Plataforma%20Help!"><img class=" icon-whatsapp" src="<?php echo PUBLIC_URL ?>out/images/whatsapp.png" width="64"></a></h6>

                </div>
            </div>
        </div>
    </section>
    <!-- popular category end -->
    <section class="section bg-verde">
        <div class=" container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center text-white mb-4 pb-2">
                        <h3 class="normal mb-4">VANTAGENS DE <strong>ATENDER NA HELP!</strong></h3>
                    </div>
                </div>
            </div>
            <div class="row row-icons">
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_01.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Ética Profissional
                                </h3>
                                <p class="mb-0 text-white rounded text-left textIcon">A Terapia Online é regulamentada pela <a target="_blank" style="text-decoration: underline !important;" href="https://site.cfp.org.br/wp-content/uploads/2018/05/RESOLU%C3%87%C3%83O-N%C2%BA-11-DE-11-DE-MAIO-DE-2018.pdf">Resolução CFP nº 11/2018.</a></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_02.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Agendamento das Consultas</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Você é notificado sempre que o paciente confirmar o agendamento/pagamento de uma consulta.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_03.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Custo-Benefício</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">O Consultório virtual da Help é uma alternativa viável para economizar tempo e dinheiro com aluguéis, impostos, marketing e outros. </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_04.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Sigilo Profissional</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Possuímos certificados de segurança SSL, sigilo absoluto, atenda pelo celular, tablet ou computador com segurança.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_05.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Valores das consultas</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Os psicólogos têm autonomia total para definir os valores das consultas.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_06.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Suporte para os Psicólogos</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Treinamento inicial para que conheça os recursos da plataforma e suporte via WhatsApp sempre que precisar.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_07.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Flexibilidade de Horários</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Você faz sua agenda como desejar, conforme sua disponibilidade de tempo.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_08.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Ter mais pacientes</h3>
                                <p class="mb-0 text-white rounded text-left textIcon">Seus serviços terão mais visibilidade, possibilitando atender públicos antes inacessíveis à terapia.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                                <img src="<?php echo PUBLIC_URL ?>out/images/icon_vantagens_09.png" />
                            </div>
                            <div class="popu-category-content box-popu-vantagens">
                                <h3 class="mb-2 text-white text-left">Perfil profissional</h3>
                                <p class="mb-0 text-white rounded text-left textIcon"> Poderá compartilhar a URL do seu perfil profissional nas redes sociais para divulgar seus serviços.</p>
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </div>
    </section>
    <!-- Prices start -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-5 pb-3">
                        <h4 class="normal">QUERO FAZER PARTE <strong>AGORA MESMO</strong></h4>

                        <div class="row flex-center">
                            <div class="col-sm-8 col-md-8 center">
                                <h6 class="subtitle normal"><strong>SATISFAÇÃO GARANTIDA</strong> OU O SEU DINHEIRO DE VOLTA</h6>
                                <h6 class="subtitle normal">Você terá <strong> 7 dias </strong>de garantia para testar todos os recursos da Help, se não gostar<strong> devolvemos 100% do seu dinheiro sem burocracia.
                                    </strong></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if (isset($planos[2])) { ?>
                    <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0">
                        <div class="pricing-box border plan-dark rounded-price pt-4 pb-4">
                            <div>
                                <h6 class="text-center text-white text-uppercase font-weight-bold"><?= $planos[2]['title'] ?></h6>
                                <p class="text-white text-center mb-5 price mt-3 p-1"><span class="text-white font-weight-normal h1"><sup class="h5">R$</sup><?= Format::toMoney($planos[2]['price'], "") ?> </span><sup class="payment_method">à vista</sup></p>
                                <div class="flex-center">
                                    <p class="text-white">Ou</p>
                                </div>
                                <div class="pricing-plan-item pd-textPlan text-center">
                                    <ul class="list-unstyled mb-4">
                                        <li class="text-white mb-2"><sup>3x</sup></i><?= Format::toMoney(substr((($planos[2]['price'] * 1.0604) / 3), 0, 6)) ?></li>
                                        <!-- <li class="text-white mb-2"></i>Parcela única ou em até 3 vezes</li> -->
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center  p-4">
                                <a href="<?php PUBLIC_URL ?>curriculo-psicologo" class="btn border-23 btnColor2 text-white">Assinar</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($planos[1])) { ?>
                    <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0">
                        <div class="pricing-box border plan-1 rounded-price pt-4 pb-4">
                            <div>
                                <h6 class="text-center text-white text-uppercase font-weight-bold"><?= $planos[1]['title'] ?></h6>
                                <p class="text-white text-center mb-5 price mt-3 p-1"><span class="text-white font-weight-normal h1"><sup class="h5">R$</sup><?= Format::toMoney($planos[1]['price'], "") ?> </span><sup class="payment_method">à vista</sup></p>
                                <div class="flex-center">
                                    <p class="text-white">Ou</p>
                                </div>
                                <div class="pricing-plan-item pd-textPlan text-center">
                                    <ul class="list-unstyled mb-4">
                                        <li class="text-white mb-2"><sup>6x</sup><?= Format::toMoney(substr((($planos[1]['price'] * 1.1072) / 6), 0, 5)) ?></li>
                                        <!-- <li class="text-white mb-2">Parcela única ou em até 6 vezes</li> -->
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center  p-4">
                                <a href="<?php PUBLIC_URL ?>curriculo-psicologo" class="btn border-23 btnColor2 text-white">Assinar</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($planos[0])) { ?>
                    <div class="col-md-4 mt-4 mb-4 mt-sm-0 pt-2 pd-plan pt-sm-0">
                        <div class="pricing-box border plan-2 rounded-price pt-4 pb-4">
                            <div>
                                <h6 class="text-center text-white text-uppercase font-weight-bold"><?= $planos[0]['title'] ?></h6>
                                <p class="text-white text-center mb-5 price mt-3 p-1"><span class="text-white font-weight-normal h1"><sup class="h5">R$</sup><?= Format::toMoney($planos[0]['price'], "") ?> </span><sup class="payment_method">à vista</sup></p>
                                <div class="flex-center">
                                    <p class="text-white">Ou</p>
                                </div>
                                <div class="pricing-plan-item pd-textPlan text-center">

                                    <ul class="list-unstyled mb-4">
                                        <!-- <li class="text-white mb-2"></i>Ou</li> -->
                                        <li class="text-white mb-2"></i><sup>12x</sup><?= Format::toMoney(substr((($planos[0]['price'] * 1.205) / 12), 0, 5)) ?></li>
                                        <!-- <li class="text-white mb-2"></i>Parcela única ou em até 12 vezes</li> -->
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center  p-4">
                                <a href="<?php PUBLIC_URL ?>curriculo-psicologo" class="btn border-23 btnColor2 text-white">Assinar</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <section class="section-social bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-white text-center">
                        <div class="row flex-center">
                            <div class="col-sm-8 col-md-8 center">
                                <h6 class="subtitle text-white normal">INDIQUE A <strong>HELP! </strong>PARA AMIGOS PSICÓLOGOS</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-12 flex-center col-xs-12 text-center float-left icons-social">
                    <a target="_blank" href="https://api.whatsapp.com/send?text=HELP Terapia online: http://helpterapiaonline.com.br"><button class="customBtn whatsapp-color left"> <i class="mdi mdi-whatsapp iconBtn"></i>Compartilhe via Whatsapp</button>
                    </a>
                    <a rel="nofollow" href="mailto:?subject=HELP Terapia online: http://helpterapiaonline.com.br"> <button class="customBtn email-color left"> <i class="mdi mdi-email iconBtn"></i>Compartilhe via E-mail</button>
                    </a>
                    <div class="customBtn facebook-color left" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fhelpterapiaonline.com.br%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><i class="mdi mdi-facebook iconBtn"></i>Compartilhar via Facebook</a></div>
                    <!-- <button class="customBtn facebook-color left"> <i class="mdi mdi-facebook iconBtn"></i>Compartilhe via Facebook</button> -->
                </div>
                <!-- <center>
                    <div class="col-sm-12 col-md-12 mt-2 center">
                        <h6 class="subtitle text-white normal">*CONSULTAR CONDIÇÕES COM O PSICÓLOGO RESPONSÁVEL</h6>
                    </div>
                </center> -->
            </div>
        </div>
    </section>
    <section class="section-suporte">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h5 class="normal subtitle"><strong>SUPORTE PARA PSICÓLOGOS</strong></h5>

                        <div class="row flex-center">
                            <div class="col-sm-8 col-md-8 center">
                                <h6 class="subtitle normal">De segunda-feira a sexta-feira em horário comercial, exceto sábados, domingos e feriados. Deixe sua mensagem e responderemos os mais breve possível.</h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 flex-center col-xs-12 text-center float-left faleDiv">
                            <button class="saibaBtn left"><a rel="nofollow" href="mailto:?subject=HELP Terapia online: http://helpterapiaonline.com.br">suporte@help.com.br</a></button>
                            <h6 class="textFale text-black normal">Ou fale direto pelo<a target="_blank" href="https://api.whatsapp.com/send?phone=554998279091&text=Ol%C3%A1%2C%20gostaria%20de%20atender%20na%20Plataforma%20Help!"><img class="icon-whatsapp" src="<?php echo PUBLIC_URL ?>out/images/whatsapp.png" width="64"></a></h6>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- FAQ start -->
    <?php if(isset($perguntas[0])){?>
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
    <?php }?>
    <!-- FAQ END -->

    <!-- MODAL START -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-contact">
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="col-sm-8 col-lg-8 flex-center align-center" style="text-align: center;">
                    <span class="sucessulContact" id="sucess" style="display: none; font-size: 12px;
  color: green;">Sua mensagem foi enviada com sucesso! Agradeçemos o contato.</span>
                    <span id="error" style="display: none; font-size: 12px;
  color: red;" class="errorContact">Ocorreu um erro ao enviar sua mensagem</span>
                </div>
                <div class="col-sm-9 col-lg-9 flex-center align-center mt-4">
                    <h5 class="text-center normal">Deixe sua mensagem que entraremos em <strong>contato contigo</strong></h5>
                </div>
                <form id="contactForm" method="POST">
                    <div class="col-sm-12 col-lg-12 flex-center items-center direction-column">
                        <div class="form-input col-sm-12 col-lg-12">
                            <input name="nome" class="form-control" type="text" placeholder="Seu nome" />
                        </div>
                        <div class="form-input col-sm-12 col-lg-12">
                            <input name="telefone" class="form-control telefone" type="text" placeholder="Número de telefone" />
                        </div>
                        <div class="form-input col-sm-12 col-lg-12">
                            <input name="email" class="form-control" type="text" placeholder="Seu email" />
                        </div>
                        <div class="form-input col-sm-12 col-lg-12">
                            <textarea name="mensagem" rows="6" col="60" class="form-control border-12" placeholder=" Deixe sua mensagem"></textarea>
                        </div>
                        <button type="submit" class="saibaBtn">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- END MODAL -->
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
    <?php Page::script(array(
        'out/js/contato.js'
    )) ?>
    <script type="text/javascript">
        const text = document.querySelector('#textWritter');
        typeWritter(text);
    </script>
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