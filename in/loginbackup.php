<html lang="pt-br" class="no-js">
	<!--<![endif]-->
	<head><?php require_once("inc/html_head.php"); ?></head>
	<body class="login example2">
		<div class="main-login col-sm-4 col-sm-offset-4">
			<div class="logo"><img src='<?php echo PUBLIC_URL?>/assets/images/versa logo.png' class='logo-img' /></div>
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<h3><?php echo ACCESS_YOUR_ACCOUNT; ?></h3>
				<p>
                    <?php echo PLEASE_INFORM_YOUR_LOGIN; ?>
				</p>
				<form class="form-login" id="form_login">
					<fieldset>
						<div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control" id="login" name="login" placeholder="Login">
								<i class="icon-user"></i> </span>
						</div>
						<div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control password" name="password" placeholder="Senha">
								<i class="icon-lock"></i> </span>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-bricky pull-right">
								<?php echo LOGIN; ?> <i class="icon-circle-arrow-right"></i>
							</button>
						</div>
                        <div class="new-account">
							<?php echo FORGOT_PASSWORD; ?>
							<a href="javascript:window.recover()">
								<?php echo RECOVER_PASSWORD; ?>
							</a>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: LOGIN BOX -->
			<!-- start: COPYRIGHT -->
		
			<!-- end: COPYRIGHT -->
		</div>
		<!-- end: MAIN CONTAINER --><?php require_once("inc/footer.php"); Page::script(array('assets/js/in/login.js','assets/js/in/recover.js')); ?>
	</body>
	<?php */ ?>
	<!-- end: BODY -->