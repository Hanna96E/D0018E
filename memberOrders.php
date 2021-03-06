

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
    //$userName = $_SESSION["name"];
    //$userStatus = $_SESSION["status"];
    

    //$sql = "SELECT orderId FROM users WHERE userId = $userId";
    //$sqlQueryResult = mysqli_query($conn,$sql);
    //$row = mysqli_fetch_assoc($sqlQueryResult);
    //$orderId = $row["orderId"];


   
?>





<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Products - bestshop</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style type="text/css"> .bs-example{margin: 20px;}</style>
        <script type="text/javascript">$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
        

        <?php
        include_once "visualFunctions.php";
        ?>
    </head>
    <body class=bodyClass>

        <?php
        headerMember("My Orders");
        ?>
        
        


        
        <?php
            $tableClassForVisual = 'table table-bordered table-striped';
            $redirectToString = "memberOrders.php";
            showOrdersViaTableMember($conn, $tableClassForVisual, $redirectToString,$userId);
        ?>


<?php
    footer();
?>
    </body>
</html>


<?php
    disconnect($conn);
?>