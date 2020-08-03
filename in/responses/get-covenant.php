<?php
    require_once("../../lib/classes/Package.php");
    new Package();
    function opt($txt = "", $val = "") {
        return '<option value="'.$val.'">'.$txt.'</option>';
    }
    $targets = Covenant::load(-1, NULL, "`name` ASC", 1);
    if(empty($targets))
        exit(opt('cadastre um convênio'));
    $output = '<option></option>';
    foreach($targets as $target)
        $output.=opt($target['name'], $target['covenantID']);
    exit($output);
?>