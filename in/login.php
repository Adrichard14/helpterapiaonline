<?php
	isset($_SESSION) or session_start();
	require_once("../lib/classes/Package.php");
	$package = new Package();
	Page::pushBase();
	if(User::restrict($absolute = true)) {
		header("location: index.php");
		exit();
	}
	$nav = "login";
?>
<!DOCTYPE html>
<html lang="pt-br" class="no-js">
<head><?php require_once("inc/html_head.php"); ?></head>
<body style="background-color: #0593c2; height: 100vh;" >
	<div style="display: flex;justify-content: center; flex-direction: row;">
		<h1 style="text-align: center; color: white; font-family: 'Poppins'; font-weight: bolder;">  marina</h1>
	</div>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" id="form_login">
					<span class="login100-form-title p-b-43" style="font-family: 'Poppins'; margin-bottom: 10px;">
						Acesse sua conta e controle os dados do seu projeto.
					</span>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Por favor digite um login válido">
						<input class="input100" type="text" id="login" name="login">
						<span class="focus-input100"></span>
						<span class="label-input100">Login</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="A senha é obrigatória">
						<input class="input100" type="password"  name="password" >
						<span class="focus-input100"></span>
						<span class="label-input100">Senha</span>
					</div>

				
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Entrar
						</button>
					</div>
					<div class="new-account">
						<br>
							<?php echo FORGOT_PASSWORD; ?>
							<a href="javascript:window.recover()">
								<?php echo RECOVER_PASSWORD; ?>
							</a>
						</div>
					<div class="container-login100-form-btn" style="text-align: center">
						<p>
							<br>
						(79) 99124-0223 <br>
						neto@somosship.com.br <br>
						Av. Pedro Paes Azevedo, 488<br>
						Salgado Filho, Aracaju - SE<br>
						49020-450<br>
						©2019 Powered by Ship. All Rights Reserved.
						</p>
					</div>
				</form>
			
				<div class="login100-more" style="background-image: url('<?php echo PUBLIC_URL?>/assets/images/bg-01.jpg');">
					<div style=" width: 100%; display: -webkit-flex; /* Safari */
								  -webkit-align-items: center; /* Safari 7.0+ */
								  display: flex;
								  

								  flex-direction:column;">		
					<div style="flex: 1; padding-top: 100px;">
						<h3 style="color: white; font-size: 50px;">Seja muito <br> bem vindo (a)<br> à  <strong>Marina.</strong></h3>
						<p style="color: white">O seu gerenciador de conteúdo.</p>
						</div>
						<div style="flex: 1; padding-top: 150px;">
							<img src="<?php echo PUBLIC_URL?>/assets/images/ship.png" style="width: 25%;">
							<p style="color: white">©2019 Powered by Ship. All Rights Reserved. </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
<?php require_once("inc/footer.php"); Page::script(array('assets/js/in/login.js','assets/js/in/recover.js')); ?>
</body>
<!--[if IE 8]><html class="ie8 no-js" lang="pt-br"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="pt-br"><![endif]-->
<!--[if !IE]><!-->

</html>
