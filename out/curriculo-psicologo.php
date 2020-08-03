<?php
$planos = Plans::load(-1);
$page = StaticPost::load(7, null, null, -1, null);
$page1 = StaticPost::load(8, null, null, -1, null);
$page = $page[0];
$page1 = $page1[0];
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('inc/head.php') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">


<body>
    <style>
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 868px;
                margin: 1.75rem auto;
            }
        }
    </style>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Loader -->

    <div class="back-to-home rounded d-none d-sm-block">
        <a href="<?php echo PUBLIC_URL ?>index" class="text-white rounded d-inline-block text-center defaultBtnColor"><i class="mdi mdi-home "></i></a>
    </div>

    <!-- Hero Start -->
    <section class="vh-100" style="background: #FFF;">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="login_page bg-white shadow rounded p-4">
                                <div class="text-center">
                                    <img src="<?php echo PUBLIC_URL ?>out/images/logo-help-dark.png" alt="" class="logo-login logo-light" height="48" />
                                    <h4 class="mb-4">Cadastrar-se</h4>
                                </div>
                                <form class="login-form" id="psyform" method="POST">
                                    <input type="hidden" name="valor_consulta">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Nome <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Nome" name="name" required="">
                                            </div>
                                        </div>
                                        <input type="hidden" name="nickname" />
                                        <!-- <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Sobrenome <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Sobrenome" name="nickname" required="">
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sexo<span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <label class="form-check-label" for="masculino">
                                                        Masculino
                                                    </label>
                                                    <input class="form-group" type="radio" name="genero" id="masculino" value="masculino">
                                                    <label class="form-check-label" for="feminino">
                                                        Feminino
                                                    </label>
                                                    <input class="form-group" type="radio" name="genero" id="feminino" value="feminino">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Data de nascimento <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_nasc" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Telefone</label>
                                                <input type="text" class="form-control" placeholder="Telefone" name="telefone" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>CPF<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control cpf" placeholder="Seu CPF" name="cpf" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>CRP<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Seu CRP" name="crp" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Possui E-PSI?<span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        Sim
                                                    </label>
                                                    <input class="form-group" type="radio" name="e_psi" id="sim" value="sim">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Não
                                                    </label>
                                                    <input class="form-group" type="radio" name="e_psi" id="nao" value="não">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Seu e-mail (esse será o login da sua plataforma)<span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" placeholder="Email" autocomplete="new-password" name="mail" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Formação<span class="text-danger">*</span></label>
                                                <select class="form-control" name="formacao" required="">
                                                    <option>Graduação</option>
                                                    <option>Curso</option>
                                                    <option>Pós-graduação</option>
                                                    <option>Extensão</option>
                                                    <option>Especialização</option>
                                                    <option>MBA</option>
                                                    <option>Mestrado</option>
                                                    <option>Doutorado</option>
                                                    <option>Pós-dotourado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Instituição de Ensino <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Ex: Universidade de São Paulo" autocomplete="new-password" name="instituicao" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Curso<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Ex: Psicologia" autocomplete="new-password" name="curso" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Ano de início<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Ex: 2010" autocomplete="new-password" name="ano_inicio" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Ano de conlusão<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Ex: 2016" autocomplete="new-password" name="ano_conclusao" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group position-relative">
                                                <label for="mini_curriculo">Seu mini currículo<span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="mini_curriculo" id="mini_curriculo" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group position-relative">
                                                <label for="abordagens_principais">Abordagens terapêuticas principais<span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" name="abordagens_principais" id="abordagens_principais" placeholder="Psicanálise,  Terapia Cognitiva-Comportamental, Psicologia Sistêmica" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group position-relative">
                                                <label for="abordagens_secundarias">Abordagens terapêuticas secundárias<span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" name="abordagens_secundarias" id="abordagens_secundarias" placeholder="Separadas por vírgula, ex: Psicanálise,  Terapia Cognitiva-Comportamental, Psicologia Sistêmica" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Ofereço ajuda para<span class="text-danger">*</span></label>
                                                <select class="selectpicker form-control my-select" value="especialidades" name="especialidades" multiple>
                                                    <!-- <option selected>Selecione</option> -->
                                                    <option>Abuso Sexual</option>
                                                    <option>Acompanhamento Psicológico</option>
                                                    <option>Adoção de Filhos</option>
                                                    <option>Adolescência</option>
                                                    <option>Agorafobia</option>
                                                    <option>Alcoolismo</option>
                                                    <option>Angústia</option>
                                                    <option>Anorexia Nervosa</option>
                                                    <option>Ansiedade</option>
                                                    <option>Autoconhecimento</option>
                                                    <option>Avaliação Neuropsicológica</option>
                                                    <option>Avaliação Psicológica</option>
                                                    <option>Baixa Autoestima</option>
                                                    <option>Baixo Desejo Sexual</option>
                                                    <option>Bulimia Nervosa</option>
                                                    <option>Bullying</option>
                                                    <option>Câncer</option>
                                                    <option>Cirurgia Bariátrica</option>
                                                    <option>Ciúmes</option>
                                                    <option>Compulsão Alimentar</option>
                                                    <option>Compulsão por compras</option>
                                                    <option>Conflitos Amorosos</option>
                                                    <option>Conflitos com a Justiça</option>
                                                    <option>Conflitos Familiares</option>
                                                    <option>Crise existencial</option>
                                                    <option>Culpas</option>
                                                    <option>Dependência Química</option>
                                                    <option>Depressão</option>
                                                    <option>Depressão Pós-parto</option>
                                                    <option>Desemprego</option>
                                                    <option>Desenvolvimento Pessoal</option>
                                                    <option>Dificuldade de Aprendizagem</option>
                                                    <option>Dificuldade para fazer amigos</option>
                                                    <option>Disfunção Erétil</option>
                                                    <option>Disfunções Sexuais</option>
                                                    <option>Distúrbios Alimentares</option>
                                                    <option>Doenças Terminais</option>
                                                    <option>Ejaculação Precoce</option>
                                                    <option>Emagrecimento</option>
                                                    <option>Encoprese</option>
                                                    <option>Enurese</option>
                                                    <option>Esquizofrenia</option>
                                                    <option>Estresse</option>
                                                    <option>Estresse pós-traumático</option>
                                                    <option>Fibromialgia</option>
                                                    <option>Fobia Social</option>
                                                    <option>Fobias</option>
                                                    <option>Gestalt-Terapia</option>
                                                    <option>Hipocondria</option>
                                                    <option>Ideação Suicida</option>
                                                    <option>Identidade de gênero</option>
                                                    <option>Insônia</option>
                                                    <option>Isolamento Social</option>
                                                    <option>Medo de Falar em Público</option>
                                                    <option>Medos</option>
                                                    <option>Morte e Luto</option>
                                                    <option>Nervosismo</option>
                                                    <option>Obesidade</option>
                                                    <option>Orientação de Pais</option>
                                                    <option>Orientação para Cirurgia Bariátrica</option>
                                                    <option>Orientação Psicopedagógica</option>
                                                    <option>Orientação Vocacional</option>
                                                    <option>Problemas de Orientação Sexual</option>
                                                    <option>Problemas no Trabalho</option>
                                                    <option>Psicologia Infantil</option>
                                                    <option>Psicoterapia</option>
                                                    <option>Psicoterapia Humanista</option>
                                                    <option>Psicoterapia Breve</option>
                                                    <option>Psicoterapia Sistêmica</option>
                                                    <option>Psicodrama</option>
                                                    <option>Psicoterapia Sistêmica</option>
                                                    <option>Psicoterapia Cognitiva Comportamental</option>
                                                    <option>Racismo</option>
                                                    <option>Relacionamento</option>
                                                    <option>Sexualidade</option>
                                                    <option>Síndrome de Burnout</option>
                                                    <option>Síndrome do Pânico</option>
                                                    <option>Supervisão Clínica em Psicologia</option>
                                                    <option>Terapia</option>
                                                    <option>Terapia de Casal</option>
                                                    <option>Terapia Sexual</option>
                                                    <option>Teste Vocacional</option>
                                                    <option>Timidez</option>
                                                    <option>TOC - Transtorno Obsessivo Compulsivo</option>
                                                    <option>Transição de Carreiras</option>
                                                    <option>Transtorno Bipolar</option>
                                                    <option>Transtorno da Personalidade Borderline</option>
                                                    <option>Transtorno da Personalidade Histriônica</option>
                                                    <option>Transtorno da Personalidade Narcisista</option>
                                                    <option>Transtorno de Acumulação</option>
                                                    <option>Transtorno de Ansiedade Generalizada (TAG)</option>
                                                    <option>Transtorno de Conduta</option>
                                                    <option>Transtorno de Déficit de Atenção/Hiperatividade</option>
                                                    <option>Transtorno Psicótico</option>
                                                    <option>Transtornos Alimentares</option>
                                                    <option>Transtornos por uso de Drogas</option>
                                                    <option>Traumas</option>
                                                    <option>Tristeza</option>
                                                    <option>Terapia Psicanalítica</option>
                                                    <option>Terapia Centrada na Pessoa</option>
                                                    <option>Vícios</option>
                                                    <option>Violência doméstica</option>
                                                    <option>Violência Sexual</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Idiomas<span class="text-danger">*</span></label>
                                                <select class="selectpicker form-control" value="idiomas" name="idiomas" multiple>
                                                    <option selected>Português</option>
                                                    <option>Inglês</option>
                                                    <option>Espanhol</option>
                                                    <option>Francês</option>
                                                    <option>Italiano</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Já respondeu alguma ação disciplinar por falha ética?<span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <label class="form-check-label" for="sim">
                                                        Sim
                                                    </label>
                                                    <input class="form-group" required type="radio" name="acao_etica" id="sim" value="sim">
                                                    <label class="form-check-label" for="não">
                                                        Não
                                                    </label>
                                                    <input class="form-group" required type="radio" name="acao_etica" id="nao" value="não">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipo: <span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <label class="form-check-label" for="psicologo">
                                                        Psicólogo(a)
                                                    </label>
                                                    <input class="form-group" required type="radio" name="tipo" id="psicologo" value="psicologo">
                                                    <label class="form-check-label" for="sexologo">
                                                        Sexólogo(a)
                                                    </label>
                                                    <input class="form-group" required type="radio" name="tipo" id="sexologo" value="sexologo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">
                                                <label>Plano<span class="text-danger">*</span></label>
                                                <select class="form-control" name="plano" required="">
                                                    <?php foreach ($planos as $plano) { ?>
                                                        <option class="form-control" value="<?= $plano['ID'] ?>"><?= $plano['title'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Senha <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" placeholder="Senha" autocomplete="new-password" name="password" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Confirmar senha <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" placeholder="Confirmar senha" autocomplete="new-password" name="password2" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="custom-control m-0 custom-checkbox">
                                                    <input type="checkbox" checked class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Eu aceito os <a data-toggle="modal" data-target="#exampleModal" href="#" class="text-primary">Termos e condições</a></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" onclick="javascript:newPsychologist()" class="btn defaultBtnColor btn-primary w-100">Registrar</button>
                                        </div>
                                        <div class="mx-auto">
                                            <p class="mb-0 mt-3"><small class="text-dark mr-2">Já tem uma conta?</small> <a href="login.php" class="text-dark font-weight-bold">Faça login</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end container-->
            </div>
        </div>
    </section>
    <!--end section-->
    <!-- MODAL TERMS AND CONDITIONS -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-contact">
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="col-sm-9 col-lg-9 flex-center align-center mt-4">
                    <h5 class="text-center normal">Termos e condições</h5>
                </div>
                <div style="height: 530px; overflow: auto; padding: 19px;">

                    <div class="job-detail-desc">
                        <p class="text-muted f-14 mb-3"><?= $page['content'] ?></p>
                    </div>
                    <div class="job-detail-desc">
                        <p class="text-muted f-14 mb-3"><?= $page1['content'] ?></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- MODAL TERMS AND CONDITIONS -->
    <!-- Hero End -->
    <!-- MODAL -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <h5>Para atender no site é necessário possuir um computador/notebook ou um smartphone para realizar os atendimentos.</h5>
                        <h5>Você possui algum desses requesitos?</h5>
                    </div>
                    <div class="col-sm-12">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary float-left">Sim</button>
                        <button type="button" class="btn btn-primary float-right" data-dismiss="modal" data-toggle="modal" data-target="#modalAlert" data-backdrop="static" data-keyboard="false">Não</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
    <!-- MODAL -->
    <div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <h5>Desculpe, para atender na HELP é necessário possuir um dos dispositivos citados acima.</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
    <!-- javascript -->
    <?php include('inc/scripts.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <?php
    Page::script(array(
        'out/js/curriculo-psy.js',
    )); ?>
    <script type="text/javascript">
        $('.my-select').selectpicker({
            maxOptions: 10,
            noneSelectedText: 'Selecione (máximo 10)'
        });
        $(document).ready(function() {
            $('#modalConfirm').modal({
                backdrop: 'static',
                keyboard: false
            })
        })
    </script>
</body>

</html>