<!DOCTYPE html>
<html lang="en">
<head>
	<title>Thank you - bestshop</title>
</head>


<?php
<<<<<<< HEAD
<<<<<<< HEAD
	include "functions.php";
	$conn = connect();
	$adress = $_POST["adress"];
	$email = $_POST["email"];
	

=======
//
=======
>>>>>>> 159fa7b303083d5188d41ab804181e38f7fbc3bf
	include "init.php";
	$conn = connect();
	$userId = "2";
	$orderId = "1";

	$adress = $_POST["adress"];
	$email = $_POST["email"];

	echo $adress;

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

//	$sqlItems = "SELECT amount, productId FROM itemList WHERE orderId == $orderId AND userId == $userId";
	// Gives productId and amount of the users "shopping cart"
	$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
	$itemQuery = mysqli_query($conn, $sqlItems);

if (mysqli_num_rows($itemQuery) > 0) {


while($itemArray = mysqli_fetch_array($itemQuery)) {
//	echo $itemArray[amount];
//	echo $itemArray[productId];


	// Gives the current amount of specifide product
	$sqlProd  = "SELECT `amount` FROM `products` WHERE `productId`= $itemArray[productId] ";
	$amountProd = mysqli_query($conn, $sqlProd);
	$amountProd = mysqli_fetch_array($amountProd);
//	echo $amountProd[amount];

	// Sets the new amount
	$newAmount = $amountProd[amount]-$itemArray[amount];
	// Error check to make sure it's not negative
	// Not fully sure how to handle that kind of error
	// Should we make sure that no amount is negative and cancel?
	if($newAmount < 0){
		echo "Error: Missing product, can't buy that many ";
	}

//	$newAmount = "47";
//	echo $newAmount;

	$sql = "UPDATE `products` SET `amount` = $newAmount WHERE `products`.`productId` = $itemArray[productId]";
	$endResult = mysqli_query($conn, $sql);
}}













/*
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["adress"])) {
                        $adressErr = "Adress is required";
			echo $adressErr;
                } else {
                        $name = test_input($_POST["adress"]);
                }

                if (empty($_POST["email"])) {
                        $emailErr = "Email is required";
			echo $emailErr;
                } else {
                        $email = test_input($_POST["email"]);
                }
}*/
>>>>>>> e466b98a2974d8f055f1955a095596a26e1430a5
?>

<body>
	<p>Thank you for choosing best shop</p>



</body>

