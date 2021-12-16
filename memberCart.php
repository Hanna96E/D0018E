

<?php
    session_start();
?>

<script>

    //check if user is not member
    var userType = '<?=$_SESSION["status"]?>';

    switch(userType) {
        case "admin":
            window.location.href = "/admin_start.php";
            break;

        case "distributer":
            window.location.href = "/distributer_start.php";
            break;

        case "member":
            //window.location.href = "/member_start.php";
            break;

        default:
            window.location.replace("/");

    }

</script>

<?php
    include "init.php";
    include "functions101.php";
    
    $conn = connect();
    $userId = $_SESSION["userId"];
    
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];

    

    $sql = "SELECT orderId FROM users WHERE userId = $userId";
    $sqlQueryResult = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($sqlQueryResult);
    $orderId = $row["orderId"];

    
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
    headerMember("Cart");
    ?>


                        
    <?php
        $numberOfColumns =1;
        $sqlForProducts = $sqlForCart = "SELECT * FROM products";
        $booleanIsLoggedIn = true;
        $booleanShowCart = true;
        $redirectToString = "memberCart.php";
        showProductsBetter($conn,$numberOfColumns,$sqlForProducts,$booleanIsLoggedIn,$booleanShowCart,$userId,$orderId,$redirectToString);
    ?>

<?php
    footer();
?>
    </body>
</html>


<?php
    disconnect($conn);
?>
