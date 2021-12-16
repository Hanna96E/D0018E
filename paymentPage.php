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


body{
    color: #ECDBBA;    
}
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


div.prod {
  position: absolute;
  left: 10%;
  top: 20%;
  background-color: #2D4263;
  width: 70%;
  
  border: 10px solid #C84B31;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}


table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #C84B31;
  color: #ECDBBA;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #191919;
}

.dropdown1 {
  position: relative;
  display: inline-block;
}

.dropdown1-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown1:hover .dropdown-content {
  display: block;
}

    </style>

</head>

<body class=bodyClass>

<?php
// Tell of what products are in the shoping cart
$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
$items = mysqli_query($conn,$sqlItems); //Items in cart
?>

<div class="prod">

<?php //START OF TABLE ?>
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
	<td>

        <div class="dropdown1">
             <img src="<?php echo $row["image"]; ?>" width="50" height="50">
             <div class="dropdown1-content">
             <img src="<?php echo $row["image"]; ?>" width="160" height="160">
             </div></div>
    </td>
	</tr>
<?php
}
// END OF WHILE LOOP
?>
</table>
<br>
<?php //END OF TABLE ?>

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
  <br><br>
  Discount
  <br>
  <input type="text" name="discount">
  <br>
  <input type="submit" value="Finalize purchase">

</form>

</div>


<?php
// We are only looking for input on paymentpage
disconnect($conn);
?>

<?php
    footer();
?>
</body>
</html>
