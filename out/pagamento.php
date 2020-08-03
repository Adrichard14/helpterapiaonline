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
$psicologo = Psychologist::load($event['workerID']);
$psicologo = $psicologo[0];
// exit(var_dump($_SESSION[Client::$SESSION]['ID']));
// exit(var_dump($event));
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
    <!-- Navbar End -->
    <section class="section vantagens-sec" style="background: #2caf7f;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center normal">
                        <h2 class="normal text-white  mb-4">VOCÊ ESTÁ ADQUIRINDO: </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- popular category start -->
    <section class="section" id="psi">
        <div class="container" style="padding-top: 100px">
            <form method="POST" id="wform">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center text-white mb-4 pb-2">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr class="table-header">
                                        <th class="text-center"></th>
                                        <th class="text-center">Nome do profissional</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Data</th>
                                        <th class="text-center">Preço</th>
                                    </tr>

                                    <tr>
                                        <td class="text-center td-consulta"><img src="<?php echo PUBLIC_URL . $psicologo['thumb'] ?>" class="img-psi" width="64" height="64" /></td>
                                        <td class="text-center td-consulta"><?= $psicologo['name'] ?></td>
                                        <td class="text-center td-consulta">
                                            <?php echo $event['hour'] ?>
                                        </td>
                                        <td class="text-center td-consulta"><?php echo $event['date'] ?></td>
                                        <td class="text-center td-consulta"><?= Format::toMoney($psicologo['valor_consulta']) ?></td>
                                    </tr>

                                </tbody>
                            </table>
                            <h2 class="normal mb-4">
                                <input type="hidden" name="date" value="<?php echo $event['date'] ?>" />
                                <input type="hidden" name="hour" value="<?php echo $event['hour'] ?>" />
                                <input type="hidden" name="clientID" value="<?php echo $clientID ?>" />
                                <input type="hidden" name="workerID" value="<?php echo $event['workerID'] ?>" />
                                <input type="hidden" name="dateID" value="<?php echo $event['ID'] ?>" />
                                <h5>Clique em confirmar para marcar a consulta</h5>
                                <button class="btnPsy" type="submit">Confirmar</button>

                            </h2>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php
    require_once('inc/scripts.php');
    // Page::script(array(
    //     'assets/js/in/eventCreate.js'
    // )); ?>
    <!-- popular category end -->
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
        ;
        (function(w, d, $, undefined) {
            var sending = false,
                f = $('#wform'),
                btn = $('#wform button[type="submit"]');
            btn.on('click', function() {
                f.submit();
            });
            btn = btn[0];
            if (f.length == 0)
                return false;

            function start() {
                if (sending)
                    return false;
                sending = true;
                btn.disabled = true;
                return true;
            }

            function unlock() {
                if (!sending)
                    return false;
                sending = false;
                btn.disabled = false;
            }

            function error(txt) {
                modal("Mensagem do sistema", txt, null);
                unlock();
            }

            function send() {
                $.ajax({
                    type: "POST",
                    url: '<?php echo PUBLIC_URL; ?>out/responses/write-workevents.php',
                    data: f.serializeArray(),
                    dataType: 'json',
                    success: function(r) {
                        modal("Sucesso!", '<h5 style="color: #00FF00">Estamos redirecionando você para a tela de pagamento!</h5>', null);
                        location.href = r.URL;
                        //w.open(r.URL);
                    },
                    error: function(r) {
                        let msg = r.responseText;
                        if (msg.indexOf("atualizamos nossa validação de endereços") > 0) {
                            modal('erro', r, null);
                        } else {
                            error(msg);
                        }
                    }
                });
                return null;
            }
            f.on('submit', function(evt) {
                evt.preventDefault();
                return start() ? send() : false;
            });
        })(window, document, jQuery);
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