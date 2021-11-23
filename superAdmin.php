

<?php
    session_start();
    ob_start();
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
        window.location.replace("http://130.240.200.56");

}

</script>
<?php
    include "init.php";
    include "functions100.php";
    
    $conn = connect();
    
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>title</title>
    </head>
    

    <body>
        <?php
            include "init.php";
            include "functions100.php";
            $conn = connect();
        ?>

        

        <?php
            

                
            runSuperAdmin($conn);
        ?>
        






        <?php
            disconnect($conn);
        ?>

    </body>
</html>


<?php
    ob_end_flush();
?>