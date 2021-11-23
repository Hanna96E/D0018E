<?php
    ob_start();

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
            include "functions100.php";
            $conn = connect();
        ?>

        

        <?php
            

                
            runSuperAdmin($conn);
        ?>
        






        <?php
            disConnect($conn);
        ?>

    </body>
</html>


<?php
    ob_end_flush();
?>