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
    <!-- Start Home -->
    <section class="bg-psicologos" id="interna" style="background: #2caf7f;">
        <!-- <div class="bg-overlay"></div> -->
        <div class="home-center">
            <div class="home-desc-center">
            </div>
        </div>
    </section>
    <!-- end home -->
    <!-- testimonial start -->
    <section class="section depoimentos-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="title text-white pb-5 title-internas">Depoimentos dos nosso clientes</h4>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <?php for ($i = 0; $i < 6; $i++) { ?>
                            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                                <div class="employers-list position-relative pb-3 pt-3 pl-2 pr-2 border rounded bg-light">
                                    <div class="grid-list-desc text-center mt-3">
                                        <h5 class="mb-2"><a href="#" class="text-dark name">Kyle Jones</a></h5>
                                        <p class="text-muted mb-0">Donec sollicitudin molestie malesuada. Praesent sapien massa, convallis a pellentesque nec, egestas</p>

                                        <ul class="employers-icons list-inline mb-1">
                                            <li class="list-inline-item"><a href="#" class="text-success"><i class="mdi mdi-star star-gold"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="text-success"><i class="mdi mdi-star star-gold"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="text-success"><i class="mdi mdi-star star-gold"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="text-success"><i class="mdi mdi-star star-gold"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="text-success"><i class="mdi mdi-star star-gold"></i></a></li>

                                        </ul>
                                    </div>

                                    <div class="fav-collection fav-icon">
                                        <i class="mdi mdi-heart" title="Collect Now"></i>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- <div class="col-lg-12 mt-4 pt-2">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination job-pagination mb-0 justify-content-center">
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
                            </nav>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer start -->
    <?php require_once('inc/footer.php'); ?>
    <!-- footer end -->

    <!-- Back to top -->
    <a href="#" class="back-to-top rounded text-center" id="back-to-top">
        <i class="mdi mdi-chevron-up d-block"> </i>
    </a>
    <!-- Back to top -->
    <?php require_once('inc/scripts.php') ?>
</body>

</html>