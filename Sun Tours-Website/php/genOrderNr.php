<?php
    session_start();
    include "user.php";
    include "dbClass.php";
    
    $user = new User();

    $orderID = $user->orderID();

    echo json_encode($orderID);
?>