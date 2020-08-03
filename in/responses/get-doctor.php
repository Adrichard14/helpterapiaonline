<?php
    require_once("../../lib/classes/Package.php");
    new Package();
    function opt($txt = "", $val = "") {
        return '<option value="'.$val.'">'.$txt.'</option>';
    }
    $targets = Doctor::load(-1, NULL, "`name` ASC", 1);
    if(empty($targets))
        exit(opt('cadastre um médico'));
    $output = '<option></option>';
    foreach($targets as $target)
        $output.=opt($target['name']." - ".$target['specialty'], $target['doctorID']);
    exit($output);
?>