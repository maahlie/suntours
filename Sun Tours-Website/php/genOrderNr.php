<?php
    session_start();
    include "user.php";
    include "dbClass.php";
    
    $user = new User();

    $orderID = $user->orderID();

    //hier wordt de orderID die we nodig hebben geechoed zodat de XMLHttp request hem op kan halen.
    echo json_encode($orderID);
?>