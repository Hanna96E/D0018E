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
//    include "functions100.php";
    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
    

    $sql = "SELECT orderId FROM users WHERE userId = $userId";
    $sqlQueryResult = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($sqlQueryResult);
    $orderId = $row["orderId"];

//    echo $orderId;     
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Thank you - bestshop</title>
</head>



<!--MEMBER MENUE BAR-->
<table>
<tr>
<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/memberOrders.php"><button> Your past orders </button></a></td>
<td><a href="/member_account.php"><button> My account </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>

<?php

	$adress = $_POST["adress"];
	$totalCost = $_POST["totalCost"];
	echo "<br>TestTC: ";
	echo $totalCost;
	echo "<br>TestA: ";
	echo $adress;

// ----------------------------
//  START TRANSACTION
// ----------------------------




//Alter the database to have the correct amount of products
// Gives productId and amount of the users "shopping cart"
	$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
	$itemQuery = mysqli_query($conn, $sqlItems);

if (mysqli_num_rows($itemQuery) > 0) {
	$prodIdArray = array();
	$amountArray = array();

	while($itemArray = mysqli_fetch_array($itemQuery)) {
		// Gives the current amount of specifide product
		$sqlProd  = "SELECT `amount` FROM `products` WHERE `productId`= $itemArray[productId] ";
		$amountProd = mysqli_query($conn, $sqlProd);
		$amountProd = mysqli_fetch_array($amountProd);
		$amountArray[] = $itemArray[amount];
		
		// Sets the new amount
		$newAmount = $amountProd[amount]-$itemArray[amount];

		// Error check to make sure it's not negative
		//If not enough, the user will be informed and will be give all that are left
		if($newAmount < 0){
			echo "Error: Missing product, can't buy that many <br>";
			echo "You'll get $amountProd[amount] instead";








			$newAmount = 0;

			// Id of product, change amount to the real amount
			// update the users order so that it contains the proper amount
			//the users new amount for the item
			//$newUserAmount = $amountProd[amount];
			$sqlErrorFix = "UPDATE `itemList` SET `amount` = $amountProd[amount] WHERE `orderId`=$orderId AND `userId`=$userId";
			$update = mysqli_query($conn, $sqlErrorFix);

			// make sure that the payment reflects this
		}

		// Updates the database
		$sql = "UPDATE `products` SET `amount` = $newAmount WHERE `products`.`productId` = $itemArray[productId]";
		$endResult = mysqli_query($conn, $sql);

	}
	echo $totalCost;
}

//Create an order table to store the order
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* Note:
*	OrderId and userId connect to an itemList for that specific order
*	So to find the times of the order, use those and serch through itemList
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
//	$sqlForTable = "SELECT * FROM products";
//	$sqlForColumns = "SHOW COLUMNS FROM products";

	// Creates the order table
	echo "<br>Test: ";
	echo $orderId;
	echo "<br>Test: ";
	echo $userId;
	echo "<br>Test: ";
	echo $totalCost;
	echo "<br>Test: ";
	echo $adress;

	$sqlOrder = "INSERT INTO `orders` (`orderId`, `userId`,`totalCost`, `adress`, `status`, `message`) VALUES ($orderId, $userId,$totalCost,$adress, `1`, ``)";
	$result = mysqli_query($conn, $sqlOrder);
	echo $result;
	echo "|Works";




// Update the users orderId to a new one
	$newOrderId = $orderId + 1;

	$sqlOrderId = "UPDATE `users` SET `orderId` = $newOrderId WHERE `users`.`userId` = $userId";
	$orderIdUpdate = mysqli_query($conn, $sqlOrderId);


?>

<body>
	<p>Thank you for choosing best shop</p>



</body>

