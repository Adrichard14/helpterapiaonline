<?php
    session_start();
    require_once("../../lib/classes/Package.php");
    new Package();
    
    // $values = $_POST;
    // exit(var_dump($_POST));
     if(count($_POST['agenda']) == 1){
            $a = $_POST['agenda'];
            $data = (explode(" ", $a[0])[0]);
            $hour = (explode(" ", $a[0])[1]);
            Workhours::create2(1, $data, $hour, $_SESSION['l@#$@e@#r2']['ID']);
      }else{
        for ($i = 0; $i <= count($_POST['agenda']); $i++) {
            $var = $_POST['agenda'][$i];
            // exit(var_dump($var));
            $data = (explode(" ", $var)[0]);
            $hour = (explode(" ", $var)[1]);
            Workhours::create2(1, $data, $hour, $_SESSION['l@#$@e@#r2']['ID']);
        }
     }
?>