<?php
    //session_start();
?>



<?php
    include "init.php";
    include "functions101.php";
    $conn = connect();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Products - bestshop</title>
        <?php
        include_once "visualFunctions.php";
        ?>
    </head>
    <body class=bodyClass>

    <?php
    headerNotLoggedIn("Products");
   

    //<h2 style="text-align: center;">Products</h2>

 ?>
                        
    <?php
        $numberOfColumns =2;
        $sqlForProducts = "SELECT * From products";
        $booleanIsLoggedIn = false;
        $booleanShowCart = false;
        $userId = "dummy";
        $orderId = "dummy";
        $redirectToString = "dummy";
        showProductsBetter($conn,$numberOfColumns,$sqlForProducts,$booleanIsLoggedIn,$booleanShowCart,$userId,$orderId,$redirectToString);
    ?>
    </body>
</html>



