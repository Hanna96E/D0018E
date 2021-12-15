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
	<title>Payment Page - bestshop</title>
    <?php
        include_once "visualFunctions.php";
    ?>
    <?php
    headerMember("Payment");
    ?>

    <style>
    .error {color: #FF0000;}



input[type=submit] {
  width: 30%;
  background-color: #0099FF;
  color: white;
  padding: 14px 20px;
  margin: 4px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #0066FF;
}

input[type=text], input[type=password], input[type=email] {
  width: 30%;
  padding: 12px 8px;
  margin: 4px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

textarea {
  width: 30%;
  height: 170px;
  padding: 12px 20px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  background-color: #FFFFFF;
  font-size: 16px;
  resize: none;
}

    </style>

</head>

<?php
include "styleHeader.php" 
?>

<body>

<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header clearfix">
<h2 class="pull-left">Payment Page</h2>
<!--MEMBER MENUE BAR-->
<table>
<tr>

<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/paymentPage.php"><button> Pay </button></a></td>
<td><a href="/memberOrders.php"><button> Your past orders </button></a></td>
<td><a href="/member_account.php"><button> My account </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>
</table>
<br><br>

</div>

<?php
// Welcome the user
$userName = "SELECT `name` FROM `users` WHERE `userId`=$userId";
$userName = mysqli_query($conn,$userName);
$name = mysqli_fetch_array($userName);
?>
	<h4> Welcome <?php echo $name[name];?> </h4>
<?php

// Tell of what products are in the shoping cart
$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
$items = mysqli_query($conn,$sqlItems); //Items in cart
?>

<table class='table table-bordered table-striped'>
<tr> <td>Product</td> <td>Price</td> <td>Amount</td> <td></td> </tr>

<?php

$totalCost = 0;
// Running through and printing the users shopping cart
while($cartInfo = mysqli_fetch_array($items)) {

    //Call for each product
    $prodId = $cartInfo["productId"];
    $prodInfo = mysqli_query($conn,"SELECT `name`,`price`,`image` FROM `products` WHERE `productId`=$prodId");
	
    $row = mysqli_fetch_array($prodInfo);

	$totalCost = $totalCost + $row["price"]*$cartInfo["amount"];

    //Print out in table
?>	<tr>
	<td><?php echo $row["name"]; ?></td>
	<td><?php echo $row["price"]; ?></td>
        <td><?php echo $cartInfo["amount"]; ?></td>
	<td><img src="<?php echo $row["image"]; ?>" style="width:50px;height:50px;"  >
	</tr>
<?php
}
// END OF WHILE LOOP
?>
</table>

<?php  echo "Total cost: ";
	   echo $totalCost; 

// THE ADREES IS REQUIERD
?>

<?php
$nameErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = htmlspecialchars($_REQUEST['fname']);
    if (empty($_POST["name"]) || $totalCost==0) {
        $nameErr = "Adress is empty";
    } else {
        // Start transaction
        include "paymentFunc.php";
        $adress = $_POST["name"];
        $discount = $_POST["discount"];

    paymentFunc($conn, $userId, $orderId, $adress,$totalCost, $discount);

        // Move to next page
        echo "<script>window.location.href = '/memberOrders.php';</script>";
    }
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

  <br>
  Adress <span class="error">* <?php echo $nameErr;?></span>
  <br>
  <input type="text" name="name">
  <br>
  Discount
  <br>
  <input type="text" name="discount">
  <br>
  <input type="submit" value="Finalize purchase">

</form>




<?php
// We are only looking for input on paymentpage
disconnect($conn);
?>

</div></div></div></div></div>
</body>
</html>
