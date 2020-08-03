<?php session_start();
if (!Psychologist::restrict()) {
    header("location: index");
    exit();
}
$workerID = $_SESSION[Psychologist::$SESSION];
$eventos = WorkEvents::load(-1, NULL, 'registry_date DESC', -1, NULL, NULL, $workerID, -1);
$pagseguro_status_list = array("pendente", "aprovado", "em disputa", "estornado", "cancelado");
$nav = 'consultas';
$total_consultas = 0.00;
// exit(var_dump(floatval(2)));
?>
<!DOCTYPE html>
<html lang="pt-br" class="no-js">
<?php require_once('inc/head.php'); ?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link href="<?php echo PUBLIC_URL ?>out/css/simple-sidebar.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="<?Php echo PUBLIC_URL ?>assets/css/jquery.datetimepicker.css" />

<?php include_once('inc/nav-psicologo.php'); ?>
<div id="wrapper" class="toggled">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <?php include_once('inc/sidebar.php') ?>
    <!-- Page Content -->
    <div id="page-content" style="direction: initial">
        <!-- popular category start -->
        <section style="padding: 100px 0; background: #F5F6F8;">
            <div class=" container">

                <div class="row row-consultas">
                    <div class="col-12 flex-center items-center" style="min-height: 0;">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="padding: 0; margin: 0;">
                            <div class="row justify-content-left">
                                <div class="col-12 mt-4">
                                    <div class="section-title">
                                        <h5 class="normal">Minhas <strong>consultas</strong></h5>
                                    </div>
                                </div>
                            </div>
                            <div id="table">
                                <div class="table-responsive bg-white">
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr class="table-header">
                                                <th class="text-center">Avatar</th>
                                                <th class="text-center">Nome do paciente</th>
                                                <th class="text-center">Data e hora</th>
                                                <th class="text-center">E-mail</th>
                                                <th class="text-center">Telefone</th>
                                                <!-- <th class="text-center">Cancelamento</th> -->
                                                <th class="text-center">Reagendamento</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                            <?php foreach ($eventos as $evento) {
                                                $cliente = Client::load($evento['clientID'])[0];
                                                $link  = EventLink::load(-1, null, null, -1, $evento['ID']);
                                                $link = isset($link[0]) ? $link[0] : null;
                                                $status = TransactionAppointment::load(-1, null, null, -1, -1, -1, $evento['ID']);
                                                $total_consultas += isset($status[0]['cost']) ? floatval($status[0]['cost']) : 0;
                                                $status = isset($status[0]) ? $pagseguro_status_list[$status[0]['payment_status']] : 'Não disponível';
                                            ?>
                                                <tr>
                                                    <td class="text-center td-consulta"><img src="<?php echo PUBLIC_URL . $cliente['thumb'] ?>" class="img-psi" width="64" height="64" /></td>
                                                    <td class="text-center td-consulta"><?= $cliente['name'] . ' ' . $cliente['nickname'] ?></td>
                                                    <td class="text-center td-consulta"><?= $evento['date'] . '-' . $evento['hour'] ?></td>
                                                    <td class="text-center td-consulta"><?= $cliente['mail'] ?></td>
                                                    <td class="text-center td-consulta"><?= $cliente['telefone'] ?></td>
                                                    <!-- <td class="text-center td-consulta">
                                                        <a target="_blank" href="<?php if (isset($link)) {
                                                                                        echo $link['link'];
                                                                                    } else {
                                                                                        echo '#';
                                                                                    } ?>" class="btn btn-click">Clique aqui</a>
                                                        <div class="btn-group open">
                                                            <a href="#" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                                                                <i class="fa fa-cog"></i>
                                                                <span class="caret"></span>
                                                            </a>
                                                            <ul role="menu" class="dropdown-menu pull-right">
                                                                <?php if (!isset($link)) { ?>
                                                                    <li role="presentation">
                                                                        <a class="menuitem" role="menuitem" tabindex="-1" href="javascript:createLink(<?= $evento['ID'] ?>)"><i class="fa fa-cog"></i>Cadastrar link</a>
                                                                    </li>
                                                                <?php } else { ?>
                                                                    <li role="presentation">
                                                                        <a class="menuitem" role="menuitem" tabindex="-1" href="javascript:updateLink(<?= $link['ID'] . ',' . $evento['ID'] ?>)"><i class="fa fa-cog"></i>Alterar link</a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </td> -->
                                                    <!-- <td class="text-center td-consulta">
                                                        <a data-toggle="modal" data-target="#cancelModal" href="#" class="btn btn-cancel">Cancelar</a>
                                                    </td> -->
                                                    <td class="text-center td-consulta">
                                                        <a data-toggle="modal" data-target="#rescheduleModal" href="#" class="btn btn-reschedule">Reagendar</a>
                                                    </td>
                                                    <td class="text-center td-consulta"><?= $status ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <!-- <div class="row"> -->
                                    <div class="col-sm-6 col-md-4 col-lg-3 float-right">
                                        <?php echo 'Total a receber: R$' .  $total_consultas . ',00' ?>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>
</div>
<!-- CANCEL MODAL START -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
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
                <h5 class="text-center normal">Preencha os campos abaixo e especifique o motivo do <strong>cancelamento</strong></h5>
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
                        <input name="hora" class="form-control" type="text" placeholder="Horário da consulta" />
                    </div>
                    <div class="form-input col-sm-12 col-lg-12">
                        <input name="dia" class="form-control" type="text" placeholder="Dia da consulta" />
                    </div>
                    <div class="form-input col-sm-12 col-lg-12">
                        <input name="nome_psicologo" class="form-control" type="text" placeholder="Nome do psicólogo" />
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
<!-- CANCEL END MODAL -->

<!-- RESCHEDULE MODAL START -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
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
                <h5 class="text-center normal">Preencha os campos abaixo e especifique o motivo do <strong>reagendamento</strong></h5>
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
                        <input name="hora" class="form-control" type="text" placeholder="Horário da consulta" />
                    </div>
                    <div class="form-input col-sm-12 col-lg-12">
                        <input name="dia" class="form-control" type="text" placeholder="Dia da consulta" />
                    </div>
                    <div class="form-input col-sm-12 col-lg-12">
                        <input name="nome_psicologo" class="form-control" type="text" placeholder="Nome do psicólogo" />
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
<!-- RESCHEDULE END MODAL -->
<!-- Back to top -->
<a href="#" class="back-to-top rounded text-center" id="back-to-top">
    <i class="mdi mdi-chevron-up d-block"> </i>
</a>
<!-- Back to top -->
<?php require_once('inc/scripts.php');
Page::script(array(
    'assets/js/in/confirm.js'
));
?>

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