<?php session_start();
$page = StaticPost::load(7, null, null, -1, null);
$page1 = StaticPost::load(8, null, null, -1, null);
$page = $page[0];
$page1 = $page1[0];
// exit(var_dump($page)); 
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
                        <h2 class="normal text-white  mb-4"><strong>TERMOS E CONDIÇÕES DE USO</strong></h2>
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
                    <div class="candidates-listing-item">
                        <div class="mt-4 p-3">
                            <!-- <div class="row">
                                <div class="col-lg-12 mt-4 pt-2">
                                    <h4 class="text-dark">Lorem ipsum:</h4>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <div class="p-4">
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