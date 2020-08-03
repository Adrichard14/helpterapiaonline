<?php session_start();
if (!Psychologist::restrict()) {
    header("location: index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br" class="no-js">
<?php require_once('inc/head.php'); ?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link href="<?php echo PUBLIC_URL ?>out/css/simple-sidebar.css" rel="stylesheet" id="bootstrap-css">

<?php //require_once('inc/header-psi.php') 
?>
<nav class="navbar navbar-expand navbar-dark fixed-top bg-verde"> <a href="#menu-toggle" id="menu-toggle" class="navbar-brand"><span class="navbar-toggler-icon"></span></a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse container" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
            <div >
                <a href="<?php echo PUBLIC_URL ?>index" class="logo">
                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-light" height="48" />
                </a>
            </div>
        </ul>
        <form class="form-inline my-2 my-md-0"> </form>
    </div>
</nav>
<div id="wrapper" class="toggled">
    <!-- Sidebar -->
    <?php include_once('inc/sidebar.php')?>
    <!-- Page Content -->
    <div id="page-content">
        <section class="section" id="psi" style="background: #2caf7f;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center text-white mb-4 pb-2">
                            <h2 class="normal mb-4">COMO AGENDAR MEU <strong>PSICÓLOGO(A) ONLINE</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 0 21px;">
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <a href="javascript:void(0)">
                            <div class="popu-category-box rounded text-center p-4">
                                <div class="popu-category-icon mb-3">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/icon_01.png" />
                                </div>
                                <div class="popu-category-content box-popu">
                                    <h3 class="mb-2 text-white text-left">Escolha o psicólogo(a)</h3>
                                    <p class="mb-0 text-white rounded text-left">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuad</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <a href="javascript:void(0)">
                            <div class="popu-category-box rounded text-center p-4">
                                <div class="popu-category-icon mb-3">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/icon_02.png" />
                                </div>
                                <div class="popu-category-content box-popu">
                                    <h3 class="mb-2 text-white text-left">Escolha o dia e horário</h3>
                                    <p class="mb-0 text-white rounded text-left">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuad</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <a href="javascript:void(0)">
                            <div class="popu-category-box rounded text-center p-4">
                                <div class="popu-category-icon mb-3">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/icon_03.png" />
                                </div>
                                <div class="popu-category-content box-popu">
                                    <h3 class="mb-2 text-white text-left">Efetue o pagamento</h3>
                                    <p class="mb-0 text-white rounded text-left">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuad</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-4 col-md-3 col-xs-12 text-center floating">
                        <a href="#search"> <span class="floating-text">Role para baixo e escolha um psicólogo</span><br>
                            <span id="search" class="floating-text"> </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->
<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script> <!-- Menu Toggle Script -->
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

</html>