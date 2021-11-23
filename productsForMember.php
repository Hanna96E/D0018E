

<?php
    ob_start();

    include "functions100.php";
    include "init.php";

    $conn = connect();
    $userId = 1;
    $orderId = 1;
   

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
    </head>
    <body>

        
        <?php
            goToMemberCartButton($conn);
            goToMemberAcountButton($conn);
        ?>


        <div class="bs-example">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Products</h2>
                        </div>
                        <table class='table table-bordered table-striped'>
                        <?php
                            showDataInsideTableSpecificForProductsForMember($conn,$userId,$orderId);
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


<?php
    disconnect($conn);
    ob_end_flush();
?>