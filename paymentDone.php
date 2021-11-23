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
        window.location.replace("http://130.240.200.56");

}

</script>
<?php
    include "init.php";
    include "functions100.php";
    
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
<!---<td><?php// echo $row["id"]; ?></td>--->
<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>

<?php

	$adress = $_POST["adress"];
	$email = $_POST["email"];

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
	$sqlOrder = "INSERT INTO `orders` (`orderId`, `userId`, `adress`, `status`, `message`) VALUES ('$orderId', '$userId', '$adress', '1', '')";

	$result = mysqli_query($conn, $sqlOrder);



//Alter the database to have the correct amount of products
// Gives productId and amount of the users "shopping cart"
	$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
	$itemQuery = mysqli_query($conn, $sqlItems);

if (mysqli_num_rows($itemQuery) > 0) {

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
	// Not fully sure how to handle that kind of error
	// Should we make sure that no amount is negative and cancel?
	if($newAmount < 0){
		echo "Error: Missing product, can't buy that many ";
	}

	// Updates the database
	$sql = "UPDATE `products` SET `amount` = $newAmount WHERE `products`.`productId` = $itemArray[productId]";
	$endResult = mysqli_query($conn, $sql);
}

	echo $amountArray[1];


// Update the users orderId to a new one
	$newOrderId = $orderId + 1;

	$sqlOrderId = "UPDATE `users` SET `orderId` = $newOrderId WHERE `users`.`userId` = $userId";
	$orderIdUpdate = mysqli_query($conn, $sqlOrderId);
}

?>

<body>
	<p>Thank you for choosing best shop</p>



</body>

