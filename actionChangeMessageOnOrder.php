<?php

    include "init.php";
    include "functions101.php";
    
    $conn = connect();

    $redirectToString = $_REQUEST['redirectToString'];
    $orderId = $_REQUEST['orderId'];
    $userId = $_REQUEST['userId'];

    $message = $_POST["amountInNumberBox"];
    $message = hannnas_test_input($message);

    $sql = "UPDATE orders SET message = $message WHERE orderId = $orderId AND userId = $userId;";
    mysqli_query($conn,$sql);

    header("Location: $redirectToString", true, 303); 
    exit;

?>