<?php
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic", "newsletter"));
$to = array("razera.psi@gmail.com");
$vars = array(
    "nome",
    "telefone",
    "email",
    "mensagem",
    
    );
foreach ($vars as $key => $var) {
	if(!isset($_POST,$_POST[$var])){
		exit(INVALID_COMMAND);
	}
	$$var= trim(strip_tags($_POST[$var]));
}
$email = strtolower($email);
	if(!Format::isMail($email)){
		exit("E-mail inválido");
	}
	if(strlen($nome)<3){
		exit("Por favor informar um nome completo");
	}
	$subject = "Contato via website - Página trabalhe conosco";
	$content = "<p>Um candidato enviou e-mail de contato através da página Trabalhe conosco. Veja à seguir os dados preenchidos por ele: </p><p>";
    $content.="<b>Nome: </b>".$nome."<br>";
	$content.="<b>Email: </b>".$email."<br>";
    $content.="<b>Telefone: </b>".$telefone."<br>";
    $content.="<b>Mensagem: </b>".$mensagem."<br>";
    $send = Newsletter::send($subject,$content,$to);
    if($send){
        exit("Mensagem enviada com sucesso! Agradecemos o contato");
 }
 exit("Mensagem não enviada");
?>