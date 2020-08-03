<?php
$transaction = TransactionAppointment::load(11560, "0,1", NULL, 2.0, -1, 8, 148);
exit(var_dump($transaction));
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

    <!--end header-->
    <!-- SEARCH BAR -->
    <section class="section vantagens-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center normal">
                        <h2 class="normal text-white  mb-4"><strong>INSTITUCIONAL</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH BAR -->

    <!-- TEAM START -->
    <section class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <table style="width: 100%;
    margin-bottom: 1rem;
    color: #212529;">
                        <tbody>
                            <tr style="border: 1px solid #000000; color: #fff; background-color: #383838;">
                                <th>Hora</th>
                                <th>Data</th>
                                <th>Psicólogo</th>
                                <th>Valor</th>
                            </tr>
                            <tr style="border: 1px solid #000000;">
                                <td>14:00</td>
                                <td>22/02/2029</td>
                                <td>Adrian</td>
                                <td>R$20,00</td>
                            </tr>
                        </tbody>
                    </table>
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