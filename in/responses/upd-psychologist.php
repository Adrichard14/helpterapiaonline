<?php
if (!isset($_POST, $_POST['ID'], $_POST['name'], $_POST['nickname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['mail'], $_POST['status'], $_POST['genero'], $_POST['data_nasc'], $_POST['telefone'], $_POST['cpf'], $_POST['crp'], $_POST['e_psi'], $_POST['formacao'], $_POST['instituicao'], $_POST['curso'], $_POST['ano_inicio'], $_POST['ano_conclusao'], $_POST['mini_curriculo'], $_POST['abordagens_principais'], $_POST['abordagens_secundarias'], $_POST['especialidades'], $_POST['acao_etica'], $_POST['plano'], $_POST['thumb'], $_POST['valor_consulta'], $_POST['tipo'], $_POST['idiomas'])) exit("Comando inválido.");
session_start();
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"), true, false);
if (!$package->import())
    exit("Falha ao importar biblioteca de execução.");
if (!User::restrict()) exit("Você não pode realizar esta operação.");
if (Psychologist::update($_POST['ID'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'], $_POST['status'], $_POST['genero'], $_POST['data_nasc'], $_POST['telefone'], $_POST['cpf'], $_POST['crp'], $_POST['e_psi'], $_POST['formacao'], $_POST['instituicao'], $_POST['curso'], $_POST['ano_inicio'], $_POST['ano_conclusao'], $_POST['mini_curriculo'], $_POST['abordagens_principais'], $_POST['abordagens_secundarias'], $_POST['especialidades'], $_POST['acao_etica'], $_POST['plano'], $_POST['thumb'], $_POST['valor_consulta'], $_POST['tipo'], $_POST['idiomas'])) exit("Super administrador alterado com sucesso!");
exit("Falha ao alterar super administrador.");
