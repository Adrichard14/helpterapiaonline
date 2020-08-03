<?php
    session_start();
    require_once("../../lib/classes/Package.php");
    new Package();
    // exit(var_dump($_POST));
    $status = 2;
    WorkEvents::create2(2, $_POST['date'], $_POST['hour'], $_POST['workerID'], $_POST['clientID'] );
    Workhours::status($_POST['dateID']);
    $event = WorkEvents::load(-1, null, null, -1, $_POST['date'], $_POST['hour'], $_POST['workerID'], $_POST
    ['clientID']);
    $event = $event[0];
    $json = TransactionAppointment::create($_POST['clientID'], $event['ID']);
        exit(json_encode($json));
  ?>
