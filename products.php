<?php
    session_start();
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style type="text/css"> .bs-example{margin: 20px;}</style>
        <script type="text/javascript">$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
    </head>
    <body>





        <div class="bs-example">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Products</h2>


<!--not loged in MENUE BAR-->
<table>
<tr>
<!---<td><?php// echo $row["id"]; ?></td>--->
<td><a href="/"><button> Home </button></a></td>
<!--<td><a href="/productsForMember.php"><button> View products </button></a></td>-->
<td><a href="/login.php"><button> Login </button></a></td>
<td><a href="/become_member.php"><button> Become member</button></a></td>
</tr>
</table><br><br>



                        </div>
                        <?php
                            showProducts($conn,'table table-bordered table-striped');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



