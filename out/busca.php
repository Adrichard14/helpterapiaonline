<?php session_start();
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

$especialidade = isset($_POST['especialidade']) ? $_POST['especialidade'] : '';

$valor = isset($_POST['valor']) ? $_POST['valor'] : '';
$valor1 = isset($valor) && $valor != "" ? explode("/", $valor)[0] : 0;
$valor2 = isset($valor) && $valor != "" ? explode("/", $valor)[1] : 1000;
$valor1 = intval($valor1);
$valor2 = intval($valor2);
$psicologos = Connector::newInstance()->query("SELECT * FROM psychologists where lower(tipo) like lower('%$tipo%') AND lower(especialidades) like lower('%$especialidade%') AND valor_consulta BETWEEN $valor1 AND $valor2 and status = 1");
$today = date('d/m/Y');
$tomorrow = date('d/m/Y', strtotime("+1 day"));
$day3 = date('d/m/Y', strtotime("+2 day"));
$day4 = date('d/m/Y', strtotime("+3 day"));

// $page = isset($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) : 1;
// $limit = 25;
// $ready = false;
// while (!$ready) {
//     $page_limit = (($page - 1) * $limit) . "," . $limit;
//     $list = Psychologist::load(-1, $page_limit, "`order` ASC", 2.0);
//     $ready = !empty($list) || $page == 1;
//     if (!$ready) $page--;
// }
// $paginator = new Paginator(Psychologist::paginator(2.0), "busca.php?page=", $page, $limit);
// exit(var_dump($paginator));
$has_search2 = isset($_POST, $_POST['k']) && urldecode($_POST['k']) != '';
$search2 = $has_search2 ? urldecode($_POST['k']) : NULL;
// exit(var_dump($search2));
if ($has_search2) {
    $k = "k=" . $search2;
    $k_ = $k . "&";
}
if ($has_search2) {
    $list = Connector::newInstance()->query("SELECT * FROM psychologists where lower(name) like lower('%$search2%') OR  lower(tipo) like lower('%$search2%') OR  lower(especialidades) like lower('%$search2%') AND valor_consulta BETWEEN $valor1 AND $valor2 and status = 1");
}
if ($has_search2) {
    $psicologos = $list;
}
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
    <section class="bg-psicologos bg-internas" id="interna">
        <!-- <div class="bg-overlay"></div> -->
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class=" text-center text-white">
                                <h2 class=" mb-4">Use os filtros para achar o seu <strong>Psicólogo(a)</strong></h2>
                            </div>
                        </div>
                    </div>
                    <?php include('components/search-bar.php') ?>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH BAR -->

    <!-- TEAM START -->
    <section class="section pt-0 candidates-sec">
        <div class="container">
            <!-- <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="show-results">
                        <div class="float-left">
                            <h5 class="text-dark mb-0 pt-2">Mostrando resultados : 1-6 of 540</h5>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="candidates-listing-item">
                        <?php foreach ($psicologos as $psi) {
                            $ID = $psi['ID'];
                            $todayHours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y'), NULL, $ID);
                            $tomorrowHours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y', strtotime("+1 day")), NULL, $ID);
                            $day3Hours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y', strtotime("+2 day")), NULL, $ID);
                            $day4Hours = Workhours::load(-1, NULL, "date DESC", 1, date('d/m/Y', strtotime("+3 day")), NULL, $ID);
                        ?>
                            <div class="border mt-4 rounded p-3 box-candidates shadow">
                                <div class="row border-left-psi">
                                    <div class="col-md-6">
                                        <div class="float-left mr-4">
                                            <img src="<?php echo PUBLIC_URL . $psi['thumb'] ?>" alt="" class="d-block img-psi" height="180">
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
                                                <li class="text-muted">Ansiedade</li>
                                                <li class="text-muted">Depressão</li>
                                                <li class="text-muted">Transtornos de atenção</li>
                                                <?php if ($psi['valor_consulta'] != null) { ?>
                                                    <li class="text-muted"><strong>R$<?php echo $psi['valor_consulta'] ?>/50 minutos</strong> </li>
                                                <?php } ?>
                                            </ul>
                                            <p class="text-muted mt-1 mb-0"><?php echo $psi['mini_curriculo'] ?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="candidates-list-fav-btn text-right">
                                            <div class="fav-icon">
                                                <i class="mdi mdi-heart"></i>
                                            </div>
                                            <div class="candidates-listing-btn mt-4">
                                                <a href="<?= PUBLIC_URL . 'perfil-psicologo/' .  $psi['ID'] ?>" class="btn btn-primary-outline btn-sm">Gostou? Visitar perfil</a>
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

                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <!-- <nav aria-label="Page navigation example">
                    <ul class="pagination job-pagination justify-content-center mb-0 mt-4 pt-2">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <i class="mdi mdi-chevron-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="mdi mdi-chevron-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav> -->
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