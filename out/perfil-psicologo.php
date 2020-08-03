<?php session_start();
$ID = implode('/', $_VARS);
$psi = Psychologist::load($ID)[0];
$especialidades = explode(",", $psi['especialidades']);
$today = date('d/m/Y');
$agenda = Workhours::load(-1, NULL, NULL, 1, $today, NULL);
$tomorrow = date('d/m/Y', strtotime("+1 day"));
$day3 = date('d/m/Y', strtotime("+2 day"));
$day4 = date('d/m/Y', strtotime("+3 day"));
$ID = $psi['ID'];
$todayHours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y'), NULL, $ID);
$tomorrowHours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y', strtotime("+1 day")), NULL, $ID);
$day3Hours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y', strtotime("+2 day")), NULL, $ID);
$day4Hours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y', strtotime("+3 day")), NULL, $ID);
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
    <!-- SEARCH BAR -->
    <section class="section vantagens-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center normal">
                        <h2 class="normal text-white  mb-4"><strong>PERFIL DO PSICÓLOGO</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH BAR -->

    <!-- TEAM START -->
    <section class="section pt-0 candidates-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="candidates-listing-item">

                        <div class="border mt-4 rounded p-3 box-candidates shadow">
                            <div class="row border-left-psi">
                                <div class="col-md-6">
                                    <div class="float-left mr-4">
                                        <img src="<?php echo PUBLIC_URL . $psi['thumb'] ?>" alt="" class="d-block img-psi" height="250">
                                    </div>
                                    <div class="candidates-list-desc job-single-meta  pt-2">
                                        <h5 class="mb-2"><a href="#" class="text-dark"><?php echo $psi['name'] . ' ' . $psi['nickname'] ?></a></h5>
                                        <ul class="list-unstyled">
                                            <li class="text-muted">
                                                <i class="mdi mdi-star star-gold"></i>
                                                <i class="mdi mdi-star star-gold"></i>
                                                <i class="mdi mdi-star star-gold"></i>
                                                <i class="mdi mdi-star star-gold"></i>
                                                <i class="mdi mdi-star star-gold"></i>
                                                (35 avaliações)
                                            </li>
                                            <?php if ($psi['tipo'] != null) { ?>
                                                <li class="text-muted"><?= $psi['tipo'] ?></strong></li>
                                            <?php } ?>
                                            <?php if ($psi['idiomas'] != null) { ?>
                                                <li class="text-muted">Idioma(as): <strong><?= $psi['idiomas'] ?></strong></li>
                                            <?php } ?>
                                            <?php if ($psi['valor_consulta'] != null) { ?>
                                                <li class="text-muted"><strong>R$<?php echo $psi['valor_consulta'] ?>/50 minutos</strong> </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="candidates-list-fav-btn text-right">
                                        <!-- <div class="fav-icon">
                                            <i class="mdi mdi-heart"></i>
                                        </div> -->
                                        <!-- <div class="candidates-listing-btn mt-4">
                                            <a href="#" class="btn btn-primary-outline btn-sm">Gostou? Visitar perfil</a>
                                        </div> -->
                                        <div class="row row-schedules">
                                            <div class="title-schedules">
                                                <h4>Marque um horário com o Psicólogo(a)!</h5>
                                            </div>
                                            <div class="col-12 table-schedules">
                                                <div class="day1">
                                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                                        <a href="#" class="hour"><?php echo date('d/m') ?></a>
                                                    </div>
                                                    <?php
                                                    if ($todayHours != null) {
                                                        foreach ($todayHours as $hour1) {
                                                    ?>
                                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                                <a href="<?php echo PUBLIC_URL . 'pagamento&dateID=' . $hour1['ID'] ?>" class="hour"><?php echo $hour1['hour'] ?></a>
                                                            </div>
                                                    <?php }
                                                    } ?>
                                                </div>
                                                <div class="day2">
                                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                                        <a href="#" class="hour"><?php echo date('d/m', strtotime("+1 day")) ?></a>
                                                    </div>
                                                    <?php $tomorrowHour =  Workhours::load(-1, NULL, "date DESC", 1, $tomorrow, NULL, $psi['ID']);
                                                    foreach ($tomorrowHour as $hour2) {
                                                    ?>
                                                        <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                            <a href="<?php echo PUBLIC_URL . 'pagamento&dateID=' . $hour2['ID'] ?>" class="hour"><?php echo $hour2['hour'] ?></a>
                                                        </div>

                                                    <?php } ?>
                                                </div>

                                                <div class="day3">
                                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                                        <a href="#" class="hour"><?php echo date('d/m', strtotime("+2 day")) ?></a>
                                                    </div>

                                                    <?php $day3Hour = Workhours::load(-1, NULL, "date DESC", 1, $day3, NULL, $psi['ID']);
                                                    if ($day3Hour != null) {
                                                        foreach ($day3Hour as $hour3) {
                                                    ?>
                                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                                <a href="<?php echo PUBLIC_URL . 'pagamento&dateID=' . $hour3['ID'] ?>" class="hour"><?php echo $hour3['hour'] ?></a>
                                                            </div>

                                                    <?php }
                                                    } ?>
                                                </div>

                                                <div class="day4">
                                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                                        <a href="#" class="hour"><?php echo date('d/m', strtotime("+3 day")) ?></a>
                                                    </div>
                                                    <?php $day4Hour =  Workhours::load(-1, NULL, "date DESC", 1, $day4, NULL, $psi['ID']);

                                                    if ($day4Hour != null) {
                                                        foreach ($day4Hour as $hour4) {
                                                    ?>
                                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                                <a href="<?php echo PUBLIC_URL . 'pagamento&dateID=' . $hour4['ID'] ?>" class="hour"><?php echo $hour4['hour'] ?></a>
                                                            </div>

                                                    <?php }
                                                    } ?>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <!-- SCHEDULE START -->
                                <!-- <div class="col-md-6">
                                    <div class="candidates-list-fav-btn text-right">
                                        <div class="fav-icon">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <div class="row row-schedules">
                                            <div class="title-schedules">
                                                <h4>Marque um horário com o Psicólogo(a)!</h5>
                                            </div>
                                            <div class="col-12 table-schedules">

                                                <div class="day1">
                                                    <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule col-header">
                                                        <a href="#" class="hour"><?php echo date('d/m') ?></a>
                                                    </div>
                                                    <?php $horario = Workhours::load(-1, NULL, "date DESC", 1, $today, NULL);
                                                    if ($horario != null) {
                                                        foreach ($horario as $hor) {
                                                    ?>
                                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                                <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                                            </div>

                                                    <?php }
                                                    } ?>
                                                </div>

                                                <div class="day2">

                                                    <?php $horario = Workhours::load(-1, NULL, "date DESC", 1, $tomorrow, NULL);
                                                    foreach ($horario as $hor) {
                                                    ?>
                                                        <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                            <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                                        </div>

                                                    <?php } ?>
                                                </div>

                                                <div class="day3">
                                                    <?php $horario = Workhours::load(-1, NULL, "date DESC", 1, $day3, NULL);
                                                    if ($horario != null) {
                                                        foreach ($horario as $hor) {
                                                    ?>
                                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                                <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                                            </div>

                                                    <?php }
                                                    } ?>
                                                </div>

                                                <div class="day4">
                                                    <?php $horario = Workhours::load(-1, NULL, "date DESC", 1, $day4, NULL);
                                                    if ($horario != null) {
                                                        foreach ($horario as $hor) {
                                                    ?>
                                                            <div class="col-sm-3 col-md-3 col-lg-3 coluna-schedule">
                                                                <a href="#" class="hour"><?php echo $hor['hour'] ?></a>
                                                            </div>

                                                    <?php }
                                                    } ?>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div> -->
                                <!-- SCHEDULE END -->
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-6 col-sm-8">
                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=55<?= $psi['telefone']?>"><button class="customBtn whatsapp-color left"> <i class="mdi mdi-whatsapp iconBtn"></i>Whatsapp</button>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4 pt-2">
                                    <h4 class="text-dark">Descrição pessoal:</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <div class="border rounded p-4">
                                        <div class="job-detail-desc">
                                            <p class="text-muted f-14 mb-3"><?= $psi['mini_curriculo'] ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mt-4 pt-2">
                                    <h4 class="text-dark">Formação:</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <div class="border rounded p-4">
                                        <div class="job-detail-desc">
                                            <ul class="list-group">
                                                <li class="list-group-item">Formação: <?= $psi['formacao'] ?></li>
                                                <li class="list-group-item">Curso: <?= $psi['curso'] ?></li>
                                                <li class="list-group-item">Instituíção: <?= $psi['instituicao'] ?></li>
                                                <li class="list-group-item">Ano de início: <?= $psi['ano_inicio'] ?></li>
                                                <li class="list-group-item">Ano de conclusão: <?= $psi['ano_conclusao'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mt-4 pt-2">
                                    <h4 class="text-dark">Especialidades:</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <div class="border rounded p-4">
                                        <div class="job-detail-desc">
                                            <ul class="list-group">
                                                <?php foreach ($especialidades as $esp) { ?>
                                                    <li class="list-group-item"><?php echo $esp ?></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-lg-12 mt-4 pt-2">
                                    <h4 class="text-dark">Experiência:</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <div class="border rounded p-4">
                                        <div class="job-detail-desc">
                                            <ul class="list-group">
                                                <li class="list-group-item">Cras justo odio</li>
                                                <li class="list-group-item">Dapibus ac facilisis in</li>
                                                <li class="list-group-item">Morbi leo risus</li>
                                                <li class="list-group-item">Porta ac consectetur ac</li>
                                                <li class="list-group-item">Vestibulum at eros</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    </div>
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
    <?php require_once('inc/scripts.php') ?>
</body>

</html>