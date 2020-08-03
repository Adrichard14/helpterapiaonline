<?php session_start();
if (!Client::restrict()) {
    header("location: login");
    exit();
}
// exit(var_dump($_GET['dateID']));
$event = Workhours::load($_GET['dateID']);
// $psyID = $_GET['psyID'];
$event = $event[0];
$clientID = $_SESSION[Client::$SESSION]['ID'];
// exit(var_dump($_SESSION[Client::$SESSION]['ID']));
// exit(var_dump($event));
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
            <div>
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
    <?php include_once('inc/sidebar.php') ?>
    <!-- Page Content -->
    <div id="page-content">
        <section class="section" id="psi" style="background: #2caf7f;">
            <div class="container" style="padding-top: 100px">
                <form method="POST" id="wform">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="section-title text-center text-white mb-4 pb-2">
                                <h2 class="normal mb-4">
                                    <input type="hidden" name="date" value="<?php echo $event['date'] ?>" />
                                    <input type="hidden" name="hour" value="<?php echo $event['hour'] ?>" />
                                    <input type="hidden" name="clientID" value="<?php echo $clientID ?>" />
                                    <input type="hidden" name="workerID" value="<?php echo $event['workerID'] ?>" />
                                    <input type="hidden" name="dateID" value="<?php echo $event['ID'] ?>" />
                                    <h5>Clique em confirmar para marcar a consulta</h5>
                                    <button class="btnPsy" type="submit">Confirmar</button></h2>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->
<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script> <!-- Menu Toggle Script -->

<?php
require_once('inc/scripts.php');
Page::script(array(
    'assets/js/in/eventCreate.js'
)); ?>
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