<?php

function paymentFunc($conn, $userId, $orderId, $adress,$totalCost, $discount){
// ----------------------------
//  START TRANSACTION
// ----------------------------
$conn->autocommit(FALSE);

	// Order message
	$message = " ";
	// Store errors
	$error = array();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	*
	*   Alter the database to have the correct amount of products
	*   Gives productId and amount of the users "shopping cart"
	*/
	$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
	$itemQuery = mysqli_query($conn, $sqlItems);

if (mysqli_num_rows($itemQuery) > 0) {
	$prodIdArray = array();
	$amountArray = array();

	while($itemArray = mysqli_fetch_array($itemQuery)) {
		// Gets the current amount of specifide product
		$sqlProd  = "SELECT `amount`,`price` FROM `products` WHERE `productId`= $itemArray[productId] ";
		$amountProd = mysqli_query($conn, $sqlProd);
		$amountProd = mysqli_fetch_array($amountProd);

		$newAmount = $amountProd[amount]-$itemArray[amount];

		// Error check to make sure it's not negative
		if($newAmount < 0){
			// Add error message to the order
			// Reduces the product amount so they don't get out of stock items
			// And makes the total cost reflect this
			$message = "One or more products where reduced as they are out of stock";
		
			$totalCost = $totalCost + ($newAmount)*$amountProd[price];
			$newAmount = 0;

			$sqlErrorFix = "UPDATE `itemList` SET `amount` = $amountProd[amount] WHERE `orderId`=$orderId AND `userId`=$userId";
			$updateItem = mysqli_query($conn, $sqlErrorFix);
			
			// ERROR HANDELING
			if ($updateItem == false) {
				array_push($error, "ERROR: Item update failed");
			}
		}
		// Updates the database
		$sql = "UPDATE `products` SET `amount` = $newAmount WHERE `products`.`productId` = $itemArray[productId]";
		$updateProd = mysqli_query($conn, $sql);

		// ERROR HANDELING
		if ($updateProd == false) {
			array_push($error, "ERROR: Product update failed");
		}

	}// END OF WHILE LOOP

	// Add the dicount
	$sqlDiscount = "SELECT `amount`,`isPercent` FROM `discounts` WHERE `code` = '$discount' AND `isActive` = '1'";
	$discountDB = mysqli_query($conn, $sqlDiscount);
	$discountDB = mysqli_fetch_array($discountDB);
	if (!Empty($discountDB)) { 


		// Either % or -amount on all products
		if ($discountDB[isPercent]) {
			$totalCost = $totalCost*(1 - $discountDB[amount]/100);
		} else {
			$totalCost = $totalCost - $discountDB[amount];
			//cant go below zero
			if ($totalCost<1) {
				$totalCost = 0;
			}
		}
	}// END OF DISCOUNT

	// Update the users orderId to a new one
	$newOrderId = $orderId + 1;

	$sqlOrderId = "UPDATE `users` SET `orderId` = $newOrderId WHERE `users`.`userId` = $userId";
	$updateOrderId = mysqli_query($conn, $sqlOrderId);

	// ERROR HANDELING
	if ($updateOrderId == false) {
		array_push($error, "ERROR: OrderId update failed");
	}
}

//Create an order table to store the order
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* Note:
*	OrderId and userId connect to an itemList for that specific order
*	So to find the times of the order, use those and search through itemList
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	// Creates the order table

	$orderState= 1;
	$sqlOrder = "INSERT INTO `orders` (`orderId`, `userId`,`totalCost`, `adress`, `status`, `message`) VALUES ('$orderId', '$userId', '$totalCost','$adress', '$orderState', '$message')";

	$updateOrder = mysqli_query($conn, $sqlOrder);

	// ERROR HANDELING
	if ($updateOrder == false) {
		array_push($error, "ERROR: Order update failed");
	}

// ----------------------------
//  END OF TRANSACTION
// ----------------------------
	// ERROR CHECK
	if (!empty($error)) {
		$conn -> rollback();
	}

	// When ready send it over
	$conn->commit();
}

?>