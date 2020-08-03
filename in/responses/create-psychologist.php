<?php
!isset($_POST['login']) ? $_POST['login'] = trim(strtolower($_POST['nickname'])) : $_POST['login'];
$vars = array('name', 'nickname', 'login', 'password', 'password2', 'mail', 'genero', 'data_nasc', 'telefone', 'cpf', 'crp', 'e_psi', 'formacao', 'instituicao', 'curso', 'ano_inicio', 'ano_conclusao', 'mini_curriculo', 'abordagens_principais', 'abordagens_secundarias', 'especialidades', 'acao_etica', 'plano');
foreach ($vars as $var) {
    if (!isset($_POST, $_POST[$var]))
        exit('Comando inválido' . $var);
    $$var = $_POST[$var];
}
session_start();
require("../../lib/classes/Package.php");
$package = new Package(array("_essential", "basic"));
!isset($_POST['status']) ? $status = 1 : $status = $_POST['status'];
if (!User::restrict($absolute = true))
    exit(ACCESS_DENIED);
$thumb = "";
if (Psychologist::create($_POST['login'], $_POST['password'], $_POST['password2'], $_POST['name'], $_POST['nickname'], $_POST['mail'], $_POST['status'], $_POST['genero'], $_POST['data_nasc'], $_POST['telefone'], $_POST['cpf'], $_POST['crp'], $_POST['e_psi'], $_POST['formacao'], $_POST['instituicao'], $_POST['curso'], $_POST['ano_inicio'], $_POST['ano_conclusao'], $_POST['mini_curriculo'], $_POST['abordagens_principais'], $_POST['abordagens_secundarias'], $_POST['especialidades'], $_POST['acao_etica'], $_POST['plano'], $thumb, $_POST['valor_consulta'], $_POST['tipo'], $_POST['idiomas']))
    exit(USER_INSERTED);
exit(USER_INSERTION_FAILED);
