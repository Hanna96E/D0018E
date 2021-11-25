<?php
//Start the session
session_start();
?>

<script>

//check if user is not member	
var userType = '<?=$_SESSION["status"]?>';

switch(userType) {
	case "admin":
    	break;

    case "distributer":
        window.location.href = "/distributer_start.php";
	   	break;

	case "member":
		window.location.href = "/member_start.php";
		break;

    default:
    	window.location.replace("/");

}
</script>

<?php
    include "functions.php";
    include "init.php";

    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Manage products - bestshop</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style type="text/css"> .bs-example{margin: 20px;}</style>
        <script type="text/javascript">$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
    <style>
    .error {color: #FF0000;}
    </style>
    </head>
    <body>

    <div class="bs-example">
    <div class="container">
    <div class="row">
    <div class="col-md-12">
	<div class="page-header clearfix">
    <h2 class="pull-left">Manage products</h2>

    <!--ADMIN MENUE BAR-->
<table>
<tr>
<td><a href="/admin_start.php"><button> Home </button></a></td>
<td><a href="/admin_products.php"><button> Manage products </button></a></td>
<td><a href="/admin_orders.php"><button> Manage orders </button></a></td>
<td><a href="/admin_accounts.php"><button> Manage accounts </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>
</table>
<br><br>

</div>


<?php

$nameErr = $priceErr = $infoErr = $amountErr = $imageErr = "";
$name = $price = $info = $amount = $image ="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
  
  if (empty($_POST["price"])) {
    $priceErr = "Price is required";
  } else {
    $price = test_input($_POST["price"]);
  }

  if (empty($_POST["info"])) {
    $infoErr = "Info is required";
  } else {
    $info = test_input($_POST["info"]);
  }

  if (empty($_POST["amount"])) {
    $amountErr = "Amount is required";
  } else {
    $amount = test_input($_POST["amount"]);
  }

  if (empty($_POST["image"])) {
    $imageErr = "Image is required";
  } else {
    $image = test_input($_POST["image"]);
  }

//check if all boxen are filled correcyly
 if(($nameErr == "") && ($priceErr == "") && ($infoErr == "") && ($amountErr == "") && ($imageErr == "")) {
    addProduct($conn, $name, $price, $info, $amount, $image);
 }

}

?>



    <table class='table table-bordered table-striped'>

    <tr>
    <td>Name</td>
    <td>Price</td>
    <td>Info</td>
    <td>Amount</td>
    <td>Image</td>
    <td></td>
    </tr>

    <tr><p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <td>    <label for="name">Name: * </label><br><br>  
            <input type="text" id = "name" name="name" style="width: 150px;">
            <br><span class="error"> <?php echo $nameErr;?></span>
    </td>

    <td>
            <label for="price">Price: * </label><br><br>
            <input type = "number" id = "price" name="price" min = "0" style="width: 80px;">
            <br><span class="error"> <?php echo $priceErr;?></span>
    </td>

    <td>    <label for="info"> Info: * </label><br>
            <textarea name="info" id = "info" rows="3" cols="20"></textarea>
            <br><span class="error"> <?php echo $infoErr;?></span>

    </td>
    <td>
            <label for="amount">Amount: * </label><br><br>
            <input type = "number" id = "amount" name="amount" min = "0" style="width: 80px;">
            <br><span class="error"> <?php echo $amountErr;?></span>
    </td>
    <td>
            <label for="image">Image: * </label><br><br>
            <input type="text" id = "image" name="image" style="width: 150px;">
            <br><span class="error"> <?php echo $imageErr;?></span>
    </td>
    <td><br><br>
    <input type="submit" name="submit" value="Add product"> 
    </td></form></tr>


<?php $result = mysqli_query($conn,"SELECT * FROM products"); ?>

<?php
    disconnect($conn);
?>

<?php

if (mysqli_num_rows($result) > 0) {
?>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
    $id = $row["productId"];
    $name = $row["name"];
    $price = $row["price"];
    $info = $row["info"];
    $amount = $row["amount"];
    $image = $row["image"];
    ?>

    <tr><form method="post" action="manage_products.php?action=change&id=<?=$id?>">
    <td>    <label for="name"><?=$name?> </label><br><br>  
            <input type="text" id = "name" name="name" style="width: 150px;">
    </td>

    <td>
            <label for="price"><?=$price?> </label><br><br>
            <input type = "number" id = "price" name="price" min = "0" style="width: 80px;">
    </td>

    <td>    <label for="info"><?=$info?></label><br>
            <textarea name="info" id = "info" rows="3" cols="20"></textarea>

    </td>
    <td>
            <label for="amount"><?=$amount?></label><br><br>
            <input type = "number" id = "amount" name="amount" min = "0" style="width: 80px;">
    </td>
    <td>
            <label for="image"><img src="<?=$image?>" style="width:39px;height:39px;"></label><br>
            <input type="text" id = "image" name="image" style="width: 150px;">
    </td>
    <td>
    <input type="submit" name="submit" value="Submit changes">
    <br><br><br>
    </form>
    <form method="post" action="manage_products.php?action=remove&id=<?=$id?>">
    <input type="submit" name="submit" value="Remove product">
    </td> </form>
    </tr>


<?php
$i++;
}
?>
</table>
<?php
}
else{
echo "No result found";
}
?>



    </div>
    </div>
    </div>
    </div>
    </body>
</html>
