  <div class="home-form-position">
      <div class="row">
          <div class="col-lg-12">
              <div class="home-registration-form p-4 mb-3">
                  <form class="registration-form" method="POST" action="<?php PUBLIC_URL ?>busca">
                      <div class="row">
                          <div class="col-lg-12 col-md-12 search-box">
                              <div class="registration-form-box2">
                                  <!-- <i class="fa fa-briefcase"></i> -->
                                  <input name="k" class="form-control" placeholder="Busque por motivo, nome ou especialidade..." aria-describedby="newssubscribebtn">
                                  <div class="input-group-append">
                                      <button class="btn btn-primary submitBnt searchBtn" type="submit" id="newssubscribebtn">Procurar</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-lg-4 col-md-6">
                              <div class="registration-form-box">
                                  <!-- <i class="fa fa-location-arrow">Gênero</i> -->
                                  <i class="bolder">Tipo do especialista</i>
                                  <select id="select-country" name="tipo" class="demo-default">
                                      <option value="">Todos</option>
                                      <option <?= isset($_POST['tipo']) && $_POST['tipo'] == 'psicologo' ? 'selected' : '' ?> value="psicologo">Psicólogo(a)</option>
                                      <option <?= isset($_POST['tipo']) && $_POST['tipo'] == 'sexologo' ? 'selected' : '' ?> value="sexologo">Sexólogo(a)</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-lg-4 col-md-6">
                              <div class="registration-form-box">
                                  <!-- <i class="fa fa-location-arrow">Gênero</i> -->
                                  <i class="bolder">Motivo</i>
                                  <select id="select-country" class="demo-default">
                                      <option value="">Todos</option>
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
                          <div class="col-lg-4 col-md-6">
                              <div class="registration-form-box">
                                  <!-- <i class="fa fa-location-arrow">Gênero</i> -->
                                  <i class="bolder">Valor</i>
                                  <select id="select-country" class="demo-default" name="valor" sortField="int" ,>
                                      <option value="">Todos</option>
                                      <option <?= isset($_POST['valor']) && $_POST['valor'] == '60/100' ? 'selected' : '' ?> value="60/100">R$60 a 100</option>
                                      <option <?= isset($_POST['valor   ']) && $_POST['valor   '] == '100/200' ? 'selected' : '' ?> value="100/200">R$100 a 200</option>
                                      <option <?= isset($_POST['valor   ']) && $_POST['valor   '] == '200/400' ? 'selected' : '' ?> value="200/400">R$200 a 400</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>