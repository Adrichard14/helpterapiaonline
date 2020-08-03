   <?php
    $psiID = $_SESSION[Psychologist::$SESSION]['ID'];
    $psi = Psychologist::load($psiID)[0];
    ?>
   <div id="sidebar-wrapper">
       <ul class="sidebar-nav">
           <li class="mt-3 mb-3">
               <div>
                   <div>
                       <img src="<?php echo $psi['thumb'] ?>" height="64" width="64" style="border-radius: 50%" class="img-responsive" />
                   </div>
               </div>
           </li>
           <li>
               <a href="profile"><?php echo $_SESSION[Psychologist::$SESSION]['name'] ?></a>
           </li>

           <li <?php echo strpos($nav, 'consultas') !== false ? ' class="active"' : '' ?>> <a href="<?php echo PUBLIC_URL ?>consultas">Minhas consultas</a> </li>
           <li <?php echo strpos($nav, 'profile') !== false ? ' class="active"' : '' ?>> <a href="<?php echo PUBLIC_URL ?>profile">Meu perfil</a> </li>
           <li <?php echo strpos($nav, 'agenda') !== false ? ' class="active"' : '' ?>> <a href="<?php echo PUBLIC_URL ?>cadastrar-agenda">Agenda</a> </li>
           <li> <a href="<?php echo PUBLIC_URL ?>responses/logout-psicologo">Sair</a> </li>
           <li> <a href="<?php echo PUBLIC_URL ?>">Voltar para o site</a> </li>
       </ul>
   </div> <!-- /#sidebar-wrapper -->