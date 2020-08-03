<?php

?>
<header id="topnav" class="defaultscroll scroll-active">
    <!-- Tagline STart -->

    <div class="tagline">
        <div class="container">
            <div class="float-left">
                <div class="phone">
                    <i class="mdi mdi-phone-classic"></i> +1 800 123 45 67
                </div>
                <div class="email">
                    <a href="#">
                        <i class="mdi mdi-email"></i> Support@mail.com
                    </a>
                </div>
            </div>
            <div class="float-right">
                <ul class="topbar-list list-unstyled d-flex" style="margin: 11px 0px;">
                    <li class="list-inline-item"><a href="javascript:void(0);"><i class="mdi mdi-account mr-2"></i>Benny Simpson</a></li>
                    <li class="list-inline-item">
                        <select id="select-lang" class="demo-default">
                            <option value="">Language</option>
                            <option value="4">English</option>
                            <option value="1">Spanish</option>
                            <option value="3">French</option>
                            <option value="5">Hindi</option>
                        </select>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Tagline End -->

    <!-- Menu Start -->
    <div class="container" style="width: 100% !important;">
        <!-- Logo container-->

        <div>
            <a href="<?php echo PUBLIC_URL ?>index" class="logo">
                <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-light" height="48" />
                <img src="<?php echo PUBLIC_URL ?>out/images/logo-help.png" alt="" class="logo-dark" height="48" />
            </a>



        </div>
        <!-- <div class="buy-button">
            <a href="post-a-job.html" class="btn btn-primary"><i class="mdi mdi-cloud-upload"></i> Post a Job</a>
        </div> -->
        <!--end login button-->
        <!-- End Logo container-->
        <div class="menu-extras">

            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>
        <div style="float: right; position: relative; top: 20px;" id="mobileThumb">
            <?php
            if (Psychologist::restrict($absolute = true)) {
                $psiID = $_SESSION[Psychologist::$SESSION]['ID'];
                $psi = Psychologist::load($psiID)[0];
            ?>
                <img src="<?php echo $psi['thumb'] ?>" style="border-radius: 50%;" height="42" width="42" class="img-responsive" />
            <?php }
            if (Client::restrict($absolute = true)) {
                $clientID = $_SESSION[Client::$SESSION]['ID'];
                $client = Client::load($clientID)[0];
            ?>
                <img src="<?= $client['thumb'] ?>" style="border-radius: 50%;" height="42" width="42" class="img-responsive" />
            <?php } ?>
        </div>
        <div id="navigation">


            <!-- NAVIGATION MOBILE -->
            <ul class="navigation-menu navigation-mobile flex-center direction-column" style="align-items: center;">
                <li>
                    <div class="flex-center mt-2">

                    </div>
                </li>
                <?php if (Client::restrict($absolute = true)) { ?>
                    <li><a href="<?php echo PUBLIC_URL ?>perfil">PERFIL</a></li>
                    <li><a href="<?php echo PUBLIC_URL ?>minhas-consultas">MINHAS CONSULTAS</a></li>
                <?php } ?>
                <?php if (Psychologist::restrict($absolute = true)) { ?>
                    <li><a href="<?php echo PUBLIC_URL ?>profile">PERFIL</a></li>
                    <li><a href="<?php echo PUBLIC_URL ?>consultas">MINHAS CONSULTAS</a></li>
                <?php } ?>

                <li><a href="<?php echo PUBLIC_URL ?>busca">NOSSOS PSICÓLOGOS</a></li>
                <li>
                    <a href="<?php echo PUBLIC_URL ?>vantagens">VANTAGENS DA TERAPIA ONLINE</a>
                </li>
                <?php if (Psychologist::restrict($absolute = true)) { ?>
                    <div>
                        <button class="experimenteBtn"><a href="<?php echo PUBLIC_URL ?>cadastrar-agenda" class="text-white">ÁREA DE PSICÓLOGOS</a></button>
                    </div>
                <?php } else { ?>
                    <div>
                        <button class="experimenteBtn"><a href="<?php echo PUBLIC_URL ?>trabalhe" class="text-white">PSI TRABALHE CONOSCO</a></button>
                    </div>
                <?php } ?>
                <?php if (!Client::restrict($absolute = true) && !Psychologist::restrict($absolute = true)) { ?>
                    <div class="flex-center direction-column" style="margin-left: 13px">
                        <div class="dropdown show">
                            <button data-toggle="dropdown" class="entrarBtn">
                                <a href="<?php echo PUBLIC_URL ?>login" class="text-white">ENTRAR</a>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item mt-2 mb-1" href="<?php echo PUBLIC_URL ?>login">
                                    <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Login para usuário</p>
                                </a>
                                <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>login-psicologo">
                                    <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Login para psicólogo</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="joinButtonArea">
                        <a href="<?php echo PUBLIC_URL ?>cadastrar">
                            <button type="button" class="btn btn-outline-primary btn-join">
                                CADASTRE-SE GRÁTIS
                            </button>
                        </a>
                    </div>
                <?php } ?>
                <?php if (Client::restrict($absolute = true)) { ?>
                    <li><a href="<?php echo PUBLIC_URL ?>responses/logout">SAIR</a></li>
                <?php }
                if (Psychologist::restrict($absolute = true)) { ?>
                    <li><a href="<?php echo PUBLIC_URL ?>responses/logout-psicologo">SAIR</a></li>
                <?php } ?>
            </ul>
            <!-- NAVIGATION MOBILE END -->



            <!-- Navigation Menu-->
            <ul class="navigation-menu navigation-desk">
                <div class="visible-xs visible-sm" style="display: none">

                    <p class="ml-4">Olá, <?php echo $_SESSION['l@#$@e@#r']['name'] . $_SESSION['l@#$@e@#r']['nickname'] ?>!</p>
                    <a class="dropdown-item mt-2 mb-1" href="#">
                        <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Perfil</p>
                    </a>
                    <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>responses/logout.php">
                        <p class="text-black"><i class="fa fas fa-sign-out-alt mr-4 color-gray"></i>Sair</p>
                    </a>
                </div>
                <li><a href="<?php echo PUBLIC_URL ?>busca">NOSSOS PSICÓLOGOS</a></li>
                <li>
                    <a href="<?php echo PUBLIC_URL ?>vantagens">VANTAGENS DA TERAPIA ONLINE</a>
                </li>
                <?php if (Psychologist::restrict($absolute = true)) { ?>
                    <button class="experimenteBtn"><a href="<?php echo PUBLIC_URL ?>cadastrar-agenda" class="text-white">ÁREA DE PSICÓLOGOS</a></button>
                <?php } else { ?>
                    <button class="experimenteBtn"><a href="<?php echo PUBLIC_URL ?>trabalhe" class="text-white">PSI TRABALHE CONOSCO</a></button>
                <?php } ?>
                <!-- CHECK IF NOT HAVE NO ONE SESSION STARTED -->
                <?php if (!Client::restrict($absolute = true) && !Psychologist::restrict($absolute = true)) { ?>

                    <div class="dropdown show">
                        <button data-toggle="dropdown" class="entrarBtn">
                            <a href="<?php echo PUBLIC_URL ?>login" class="text-white">ENTRAR</a>
                        </button>


                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item mt-2 mb-1" href="<?php echo PUBLIC_URL ?>login">
                                <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Login para usuário</p>
                            </a>
                            <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>login-psicologo">
                                <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Login para psicólogo</p>
                            </a>
                        </div>
                    </div>
                    <div class="joinButtonArea">
                        <a href="<?php echo PUBLIC_URL ?>cadastrar">
                            <button type="button" class="btn btn-outline-primary btn-join">
                                CADASTRE-SE GRÁTIS
                            </button>
                        </a>
                    </div>

                    <!-- IF HAVE A PSYCHOLOGIST SESSION -->
                <?php }
                if (Psychologist::restrict($absolute = true)) {
                    $psiID = $_SESSION[Psychologist::$SESSION]['ID'];
                    $psi = Psychologist::load($psiID)[0];
                ?>

                    <div class="dropdown show icon-user">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo $psi['thumb'] ?>" style="border-radius: 50%;" height="42" width="42" class="img-responsive" />
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <p class="ml-4">Olá, <?php echo $_SESSION['l@#$@e@#r2']['name'] . ' ' . $_SESSION['l@#$@e@#r2']['nickname'] ?>!</p>
                            <a class="dropdown-item mt-2 mb-1" href="<?php echo PUBLIC_URL ?>profile">
                                <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Perfil</p>
                            </a>
                            <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>consultas">
                                <p class="text-black"><i class="mdi mdi-newspaper mr-4 color-gray"></i>Minhas Sessões</p>
                            </a>
                            <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>responses/logout-psicologo">
                                <p class="text-black"><i class="fa fas fa-sign-out-alt mr-4 color-gray"></i>Sair</p>
                            </a>

                        </div>
                    </div>

                    <!-- IF HAVE A CLIENT SESSION -->
                <?php }
                if (Client::restrict($absolute = true)) {
                    $clientID = $_SESSION[Client::$SESSION]['ID'];
                    $client = Client::load($clientID)[0];
                ?>
                    <div class="dropdown show icon-user">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= $client['thumb'] ?>" style="border-radius: 50%" height="42" width="42" class="img-responsive" />
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <p class="ml-4">Olá, <?php echo $_SESSION['l@#$@e@#r']['name'] ?>!</p>
                            <a class="dropdown-item mt-2 mb-1" href="<?php echo PUBLIC_URL ?>perfil">
                                <p class="text-black"><i class="fa fa-user mr-4 color-gray"></i>Perfil</p>
                            </a>
                            <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>minhas-consultas">
                                <p class="text-black"><i class="mdi mdi-newspaper mr-4 color-gray"></i>Minhas Sessões</p>
                            </a>
                            <a class="dropdown-item mt-2" href="<?php echo PUBLIC_URL ?>responses/logout">
                                <p class="text-black"><i class="fa fas fa-sign-out-alt mr-4 color-gray"></i>Sair</p>
                            </a>

                        </div>
                    </div>
                <?php } ?>

            </ul>
            <!--end navigation menu-->
        </div>
        <!--end navigation-->
    </div>
    <!--end container-->
    <!--end end-->
</header>