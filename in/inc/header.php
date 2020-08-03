
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container" style="background: #f9f9f9;">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<a class="navbar-brand logo" href="index.php">
						<img src='<?php echo BASE?>assets/images/versa-logo.png' class='logo-img' />
					</a>
					<!-- end: LOGO -->
				</div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
					<ul class="nav navbar-right">
                        <li>
                        	<a href="<?php echo PUBLIC_URL?>" title="Ver página inicial" target="_blank">
                            	<i class="icon-globe"></i>
                            </a>
                        </li>
						<!-- start: USER DROPDOWN -->
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="username"><?php echo $_SESSION[User::$SESSION]['name']?></span>
								<i class="clip-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="javascript:updateUser(<?php echo $_SESSION[User::$SESSION]["ID"]?>,4)">
										<i class="clip-user-2"></i>
										&nbsp;<?php echo UPDATE_PROFILE; ?>
									</a>
								</li>
								<li>
									<a href="logout.php">
										<i class="clip-exit"></i>
										&nbsp;<?php echo LOGOUT; ?>
									</a>
								</li>
							</ul>
						</li>
						<!-- end: USER DROPDOWN -->
					</ul>
					<!-- end: TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>
		<!-- end: HEADER -->