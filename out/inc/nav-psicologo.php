<?php
$psiID = $_SESSION[Psychologist::$SESSION]['ID'];
$psi = Psychologist::load($psiID)[0];
?>
<nav class="navbar navbar-expand navbar-dark fixed-top bg-verde"> <a href="#menu-toggle" id="menu-toggle" class="navbar-brand"><span class="navbar-toggler-icon"></span></a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse container" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
            <li>
                <div>
                    <a href="<?php echo PUBLIC_URL ?>index" class="logo">
                        <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-light" height="48" />
                    </a>
                </div>
            </li>
            <li>

            </li>
        </ul>
        <form class="form-inline my-2 my-md-0"> </form>
    </div>
    <div class="col-sm-3">
        <h5 class="text-white">ACESSO DO <strong>PSICÓLOGO</strong></h5>
    </div>
    <div class="dropdown-psicologo">
        <div class="dropdown show icon-user">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="<?php echo $psi['thumb'] ?>" height="48" width="48" style="border-radius: 50%" class="img-responsive" />
            </a>

            <div class="dropdown-menu dropdown-menu-psicologo" style="text-align: left;" aria-labelledby="dropdownMenuLink">
                <p class="ml-4">Olá, <?php echo $_SESSION['l@#$@e@#r2']['name'] ?>!</p>
                <a class="dropdown-item mt-2 mb-1" href="<?php echo PUBLIC_URL ?>profile">
                    <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Perfil</p>
                </a>
                <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>consultas">
                    <p class="text-black"><i class="mdi mdi-newspaper mr-4 color-gray"></i>Minhas consultas</p>
                </a>
                <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>cadastrar-agenda">
                    <p class="text-black"><i class="mdi mdi-calendar mr-4 color-gray"></i>Agenda</p>
                </a>
                <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>responses/logout-psicologo">
                    <p class="text-black"><i class="fa fas fa-sign-out-alt mr-4 color-gray"></i>Sair</p>
                </a>
                <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>">
                    <p class="text-black"><i class="mdi mdi-home mr-4"></i>Voltar para o site</p>
                </a>
            </div>
        </div>
    </div>
</nav>