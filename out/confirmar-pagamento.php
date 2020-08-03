<?php
session_start();
$planID = $_GET['planID'];
$plano = Plans::load($planID)[0];
$psicologo = $_SESSION[Psychologist::$SESSION];
// exit(var_dump($psicologo));
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
    <?php //require_once('inc/header.php'); ?>
    <!--end header-->
    <!-- Navbar End -->

    <!-- popular category start -->
    <section class="section vantagens-sec">
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
    <section class="section bg-verde" style="padding: 50px 0;">
        <form method="POST" id="wform">
            <div class=" container">
                <div class="row flex-center">

                    <input type="hidden" name="customerID" value="<?php echo $psicologo['ID'] ?>">
                    <input type="hidden" name="planID" value="<?php echo $plano['ID'] ?>">
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">

                        <div class="popu-category-box planHover rounded text-center p-4">
                            <div class="popu-category-content box-popu-vantagens">
                                <h4 class="mb-2 text-white text-center"><?= $plano['title'] ?></h4>
                                <h6 class="mb-2 text-white text-center"><?= Format::toMoney($plano['price']) ?></h6>
                                <button type="submit" class="saibaBtn" >Ir para o pagamento</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- popular category end -->
    <!-- Prices start -->

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
    <?php //Page::script(array(
    //'out/js/confirmar-plano.js'
    //))
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
    <script>
    ;(function(w,d,$,undefined) {
                var sending = false, f = $('#wform'), btn = $('#wform button[type="submit"]');
                btn.on('click', function() {
                    f.submit();
                });
                btn = btn[0];
                if(f.length == 0)
                    return false;
                function start() {
                    if(sending)
                        return false;
                    sending = true;
                    btn.disabled = true;
                    return true;
                }
                function unlock() {
                    if(!sending)
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
                        url: '<?php echo PUBLIC_URL; ?>out/responses/compra.php',
                        data: f.serializeArray(),
                        dataType: 'json',
                        success: function(r) {
                            modal("Sucesso!", '<h5 style="color: #00FF00">Estamos redirecionando você para a tela de pagamento!</h5>', null);
                            location.href = r.URL;
                            //w.open(r.URL);
                        }, error: function(r) {
                            let msg = r.responseText;
                            if(msg.indexOf("atualizamos nossa validação de endereços") > 0) {
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
    <!-- <script>
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
                    url: '<?php echo PUBLIC_URL; ?>out/responses/compra.php',
                    data: f.serializeArray(),
                    dataType: "json",
                    success: function(r) {
                        alert(r)
                        modal("Sucesso!", ('<?php echo 'PAGSEGURO_SUCESSO'; ?>').replace('{URL}', r.URL), null);
                        location.href = r.URL;
                        //w.open(r.URL);
                    },
                    error: function(r) {
                        console.log(r.responseText);
                        let msg = r.responseText;
                        error(msg);
                    }
                });
                return null;
            }
            f.on('submit', function(evt) {
                evt.preventDefault();
                return start() ? send() : false;
            });
        })(window, document, jQuery);
    </script> -->
</body>

</html>