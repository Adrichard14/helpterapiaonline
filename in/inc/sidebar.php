<?php
$nav = isset($nav) ? $nav : "";
?>
<div class="navbar-content" style="position: relative;height:100%;">
    <div id="nav_test" class="hidden-xs"></div>
    <!-- start: SIDEBAR -->
    <div id="nav" class="main-navigation navbar-collapse collapse">
        <!-- start: MAIN NAVIGATION MENU -->
        <ul class="main-navigation-menu">
            <li<?= $nav == "index" ? ' class="active open"' : "" ?>>
                <a href="index.php"><i class="clip-home-3"></i>
                    <span class="title"> <?php echo HOME; ?> </span>
                    <span class="selected"></span>
                </a>
                </li>

                <li<?php echo strpos($nav, "staticpost") !== false ? ' class="active open"' : ""; ?>>
                    <a href="javascript:void(0)">
                        <i class="clip-note"></i>
                        <span class="title"> Termos e condições </span><i class="icon-arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        <?php if ($nav == "alt-staticpost") { ?>
                            <li class="active open">
                                <a href="#">
                                    <span class="title"><?php echo UPDATE; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <li<?= $nav == 'add-staticpost' ? ' class="active open"' : '' ?>>
                            <li<?= $nav == 'list-staticpost' ? ' class="active open"' : '' ?>>
                                <a href="staticposts.php">
                                    <span class="title"><?php echo VIEW_LIST; ?></span>
                                </a>
                                </li>
                    </ul>
                    </li>
                    <li<?php echo strpos($nav, "plans") !== false ? ' class="active open"' : ""; ?>>
                        <a href="javascript:void(0)">
                            <i class="clip-archive"></i>
                            <span class="title"> Planos </span><i class="icon-arrow"></i>
                        </a>
                        <ul class="sub-menu">
                            <?php if ($nav == "alt-plans") { ?>
                                <li class="active open">
                                    <a href="#">
                                        <span class="title"><?php echo UPDATE; ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li<?= $nav == 'add-plans' ? ' class="active open"' : '' ?>>
                                <a href="write-slide.php">
                                    <span class="title"><?php echo WRITE; ?></span>
                                </a>
                                </li>
                                <li<?= $nav == 'list-plans' ? ' class="active open"' : '' ?>>
                                    <a href="plans.php">
                                        <span class="title"><?php echo VIEW_LIST; ?></span>
                                    </a>
                                    </li>
                        </ul>
                        </li>
                        <li<?php echo strpos($nav, "plans") !== false ? ' class="active open"' : ""; ?>>
                            <a href="javascript:void(0)">
                                <i class="clip-calendar-3"></i>
                                <span class="title"> Consultas </span><i class="icon-arrow"></i>
                            </a>
                            <ul class="sub-menu">
                                <?php if ($nav == "alt-workerevents") { ?>
                                    <li class="active open">
                                        <a href="#">
                                            <span class="title"><?php echo UPDATE; ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <!-- <li<?= $nav == 'add-workerevents' ? ' class="active open"' : '' ?>>
                                    <a href="write-workerevents.php">
                                        <span class="title"><?php echo WRITE; ?></span>
                                    </a>
                                    </li> -->
                                <li<?= $nav == 'list-workerevents' ? ' class="active open"' : '' ?>>
                                    <a href="workerevents.php">
                                        <span class="title"><?php echo VIEW_LIST; ?></span>
                                    </a>
                                    </li>
                            </ul>
                            </li>
                            <li<?php echo strpos($nav, "faqs") !== false ? ' class="active open"' : ""; ?>>
                                <a href="javascript:void(0)">
                                    <i class="clip-calendar-3"></i>
                                    <span class="title"> Perguntas e Repostas (Trabalhe Conosco) </span><i class="icon-arrow"></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ($nav == "alt-faqs") { ?>
                                        <li class="active open">
                                            <a href="#">
                                                <span class="title"><?php echo UPDATE; ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li<?= $nav == 'add-faqs' ? ' class="active open"' : '' ?>>
                                        <a href="write-faq.php">
                                            <span class="title"><?php echo WRITE; ?></span>
                                        </a>
                                        </li>
                                        <li<?= $nav == 'list-faqs' ? ' class="active open"' : '' ?>>
                                            <a href="faqs.php">
                                                <span class="title"><?php echo VIEW_LIST; ?></span>
                                            </a>
                                            </li>
                                </ul>
                                </li>
                                <li<?php echo strpos($nav, "advantage") !== false ? ' class="active open"' : ""; ?>>
                                    <a href="javascript:void(0)">
                                        <i class="clip-calendar-3"></i>
                                        <span class="title"> Perguntas e Repostas (Vantagens) </span><i class="icon-arrow"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <?php if ($nav == "alt-advantage") { ?>
                                            <li class="active open">
                                                <a href="#">
                                                    <span class="title"><?php echo UPDATE; ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li<?= $nav == 'add-advantage' ? ' class="active open"' : '' ?>>
                                            <a href="write-faqadvantage.php">
                                                <span class="title"><?php echo WRITE; ?></span>
                                            </a>
                                            </li>
                                            <li<?= $nav == 'list-advantage' ? ' class="active open"' : '' ?>>
                                                <a href="advantagefaqs.php">
                                                    <span class="title"><?php echo VIEW_LIST; ?></span>
                                                </a>
                                                </li>
                                    </ul>
                                    </li>
                                    <li<?php echo strpos($nav, "transactions") !== false ? ' class="active open"' : ""; ?>>
                                        <a href="javascript:void(0)">
                                            <i class="clip-stats"></i>
                                            <span class="title"> Transações </span><i class="icon-arrow"></i>
                                        </a>
                                        <ul class="sub-menu">
                                            <?php if ($nav == "alt-transactions") { ?>
                                                <li class="active open">
                                                    <a href="#">
                                                        <span class="title"><?php echo UPDATE; ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li<?= $nav == 'add-transactions' ? ' class="active open"' : '' ?>>
                                                <a href="write-transaction.php">
                                                    <span class="title"><?php echo WRITE; ?></span>
                                                </a>
                                                </li>
                                                <li<?= $nav == 'list-transactions' ? ' class="active open"' : '' ?>>
                                                    <a href="transactions.php">
                                                        <span class="title"><?php echo VIEW_LIST; ?></span>
                                                    </a>
                                                    </li>
                                        </ul>
                                        </li>
                                        <li<?php echo strpos($nav, "queue") !== false || strpos($nav, "email") !== false ? ' class="active open"' : ""; ?>>
                                            <a href="javascript:void(0)">
                                                <i class="icon-envelope"></i>
                                                <span class="title"> Boletins Informativos </span><i class="icon-arrow"></i>
                                                <span class="selected"></span>
                                            </a>
                                            <ul class="sub-menu">
                                                <li<?php echo strpos($nav, "email") !== false ? ' class="active open"' : ""; ?>>
                                                    <a href="javascript:void(0)">
                                                        <span class="title"> E-mails </span><i class="icon-arrow"></i>
                                                    </a>
                                                    <ul class="sub-menu">
                                                        <?php if ($nav == "alt-emails") { ?>
                                                            <li class="active open">
                                                                <a href="#">
                                                                    <span class="title"><?php echo UPDATE; ?></span>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <li<?= $nav == 'add-emails' ? ' class="active open"' : '' ?>>
                                                            <a href="write-email.php">
                                                                <span class="title"><?php echo WRITE; ?></span>
                                                            </a>
                                                            </li>
                                                            <li<?= $nav == 'list-emails' ? ' class="active open"' : '' ?>>
                                                                <a href="emails.php">
                                                                    <span class="title"><?php echo VIEW_LIST; ?></span>
                                                                </a>
                                                                </li>
                                                    </ul>
                                                    </li>
                                                    <li<?php echo strpos($nav, "queue") !== false ? ' class="active open"' : ""; ?>>
                                                        <a href="javascript:void(0)">
                                                            <span class="title"> Boletins </span><i class="icon-arrow"></i>
                                                        </a>
                                                        <ul class="sub-menu">
                                                            <?php if ($nav == "alt-queues") { ?>
                                                                <li class="active open">
                                                                    <a href="#">
                                                                        <span class="title"><?php echo UPDATE; ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <li<?= $nav == 'add-queues' ? ' class="active open"' : '' ?>>
                                                                <a href="write-queue.php">
                                                                    <span class="title"><?php echo WRITE; ?></span>
                                                                </a>
                                                                </li>
                                                                <li<?= $nav == 'list-queues' ? ' class="active open"' : '' ?>>
                                                                    <a href="queues.php">
                                                                        <span class="title"><?php echo VIEW_LIST; ?></span>
                                                                    </a>
                                                                    </li>
                                                        </ul>
                                                        </li>
                                            </ul>
                                            </li>
                                            <li<?= strpos($nav, "user") !== false ? ' class="active open"' : "" ?>>
                                                <a href="users.php">
                                                    <i class="clip-users"></i>
                                                    <span class="title"> <?php echo USERS; ?> </span>
                                                    <span class="selected"></span>
                                                </a>
                                                </li>
                                                <li<?= strpos($nav, "clients") !== false ? ' class="active open"' : "" ?>>
                                                    <a href="clients.php">
                                                        <i class="clip-users"></i>
                                                        <span class="title">Clientes</span>
                                                        <span class="selected"></span>
                                                    </a>
                                                    </li>
                                                    <li<?= strpos($nav, "psy") !== false ? ' class="active open"' : "" ?>>
                                                        <a href="psychologists.php">
                                                            <i class="clip-users"></i>
                                                            <span class="title">Psicólogos</span>
                                                            <span class="selected"></span>
                                                        </a>
                                                        </li>
                                                        <li<?= strpos($nav, "aprove") !== false ? ' class="active open"' : "" ?>>
                                                            <a href="aproves.php">
                                                                <i class="clip-list-6"></i>
                                                                <span class="title">Esperando aprovação</span>
                                                                <span class="selected"></span>
                                                            </a>
                                                            </li>

        </ul>
        <!-- end: MAIN NAVIGATION MENU -->

    </div>
    <!-- end: SIDEBAR -->
</div>