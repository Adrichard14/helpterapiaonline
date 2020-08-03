<?php
    require_once("../../lib/classes/Package.php");
    new Package();
    if(!isset($_POST, $_POST['ID']))
        exit(INVALID_COMMAND);
    if(!User::restrict())
        exit(ACCESS_DENIED);
   if(Psychologist::aprove($_POST['ID'])){
       $psicologo = Psychologist::load($_POST['ID']);
       $psicologo = $psicologo[0];
       Newsletter::send('Cadastro aprovado', 'Parabéns, a sua solicitação de cadastro para atuar na HELP foi aprovada. Acesse nosso site, faça o login e comece já a utilizar nossa plataforma!', $psicologo['mail'] );
   }
