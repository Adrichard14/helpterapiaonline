<?php
if (!isset($_POST, $_POST['name'], $_POST['nickname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['mail'])) exit("Comando inválido.");
// exit(var_dump($_POST));
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
$status = !isset($_POST['status']) ? 1 : $_POST['status'];
if (Psychologist::update($_POST['ID'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'], $status, $_POST['genero'], $_POST['data_nasc'], $_POST['telefone'], $_POST['cpf'], $_POST['crp'], $_POST['e_psi'], $_POST['formacao'], $_POST['instituicao'], $_POST['curso'], $_POST['ano_inicio'], $_POST['ano_conclusao'], $_POST['mini_curriculo'], $_POST['abordagens_principais'], $_POST['abordagens_secundarias'], $_POST['especialidades'], $_POST['acao_etica'], $_POST['plano'], $_POST['thumb'], $_POST['valor_consulta'], $_POST['tipo'], $_POST['idiomas']))
    exit('Perfil alterado com sucesso!');
exit(USER_INSERTION_FAILED);
