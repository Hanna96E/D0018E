<?php

    include "init.php";
    
    $conn = connect();

    $redirectToString = $_REQUEST['redirectToString'];
    $orderId = $_REQUEST['orderId'];
    $userId = $_REQUEST['userId'];
    $status = $_REQUEST['status'];
    $value = $_REQUEST['value'];

    if((0<=($status + $value)) AND (($status + $value)<=5)){
        $sql = "UPDATE orders SET status = status + $value WHERE orderId = $orderId AND userId = $userId;";
        mysqli_query($conn,$sql);
    }

    header("Location: $redirectToString", true, 303); 
    exit;

?>

