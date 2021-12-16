<?php
//Start the session
session_start();
?>

<?php


function login($conn, $email, $password){

	try{

		$sql = "SELECT userType FROM users WHERE email = '$email' and pwd = '$password'";

		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "s", $continent);
		mysqli_stmt_execute($stmt);
    	$result = mysqli_stmt_get_result($stmt);
    	$type = mysqli_fetch_assoc($result)["userType"];

	}
	catch (Exception $e){
		$type = "error";
	}

	return $type;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function checkIfEmailExists($conn, $email){
	$sql = "SELECT email FROM users WHERE email = '$email'";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "s", $continent);
	mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $email = mysqli_fetch_assoc($result)["email"];
    return $email;
}

function createAccount($conn, $orderId, $name, $password, $email, $userType){
	if($orderId == 1){
		$sql = "INSERT INTO users (orderId, name, pwd, email, userType) VALUES ('$orderId', '$name', '$password', '$email','$userType')";
	}
	else{
		$sql = "INSERT INTO users (name, pwd, email, userType) VALUES ('$name', '$password', '$email','$userType')";
	}

	if (mysqli_query($conn, $sql)) {
  		echo "<script>alert('Congratulations! The account was successfully created.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}

function removeAccount($conn, $id){
	
	$sql = "DELETE FROM users WHERE userId = $id";

	if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('The account was successfully removed.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}


//////////////////////// CHANGE ACCOUNT //////////////////////////////////////////

function changeAccount($conn, $id, $name, $password, $email){

	$numOfcolumns = 0;
	
	$arguments = array();

	$arguments['name'] = $name;
	$arguments['pwd'] = $password;
	$arguments['email'] = $email;

	$columnNames = array();
	$columnItems = array();
	foreach ($arguments as $key => $value) {
		if($value != ""){
			$numOfcolumns++;
			$columnNames[] = $key;
			$columnItems[] = $value;
		}

	}
	
	if ($numOfcolumns > 0){
		switch ($numOfcolumns){
			case 1:
				$sql = "UPDATE users SET $columnNames[0]='$columnItems[0]' WHERE userId=$id";
				break;

			case 2:
				$sql = "UPDATE users SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]' WHERE userId=$id";
				break;

			case 3:
				$sql = "UPDATE users SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]', $columnNames[2]='$columnItems[2]' WHERE userId=$id";
				break;
		}


		if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('The account was successfully changed.');</script>";
		} else {
  			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
}


////////////////////////// END OF CHANGE ACCOUNT //////////////////////////////////



//when member creates account, when user logs in.
function setSessionUser($conn, $email){
	$sql = "SELECT userId, name, userType FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	$_SESSION["userId"] = $row["userId"];
	$_SESSION["name"] = $row["name"];
	$_SESSION["email"] = $email;
	$_SESSION["status"] = $row["userType"];
}


function addProduct($conn, $name, $price, $info, $amount, $image, $content){

/*
	echo "$conn";
	echo "$name";
	echo "$price";
	echo "$info";
	echo "$amount";
	echo "$image";
	echo "$content";
*/


	$sql = "INSERT INTO `products` (`productId`, `name`, `price`, `amount`, `info`, `content`, `image`) VALUES (NULL, '$name', '$price', '$amount', '$info', '$content', '$image')"; 
	//"INSERT INTO products (`name`, `price`, `amount`, `info`, `image`, `content`) VALUES ('$name', '$price', '$amount', '$info','$image', '$content')";

	if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully added.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

function removeProduct($conn, $id){

		$sql = "DELETE FROM products WHERE productId = $id";

		if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully removed.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}


//////////////////////// CHANGE PRODUCT //////////////////////////////////////////
/*function changeProduct($conn, $id, $name, $price, $info, $amount, $image, $content){


	$sql = "UPDATE products SET name='$name', price='$price', info='$info', amount='$amount', image='$image', contents='$content' WHERE productId=$id";

	if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully changed.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}*/


function changeProduct($conn, $id, $name, $price, $info, $amount, $image, $content){

	$numOfcolumns = 0;
	
	$arguments = array();

	$arguments['name'] = $name;
	$arguments['price'] = $price;
	$arguments['info'] = $info;
	$arguments['amount'] = $amount;
	$arguments['image'] = $image;
	$arguments['content'] = $content;
	

	$columnNames = array();
	$columnItems = array();
	foreach ($arguments as $key => $value) {
		if($value != ""){
			$numOfcolumns++;
			$columnNames[] = $key;
			$columnItems[] = $value;
		}

	}
	
	if ($numOfcolumns > 0){
		switch ($numOfcolumns){
			case 1:
				$sql = "UPDATE products SET $columnNames[0]='$columnItems[0]' WHERE productId=$id";
				break;

			case 2:
				$sql = "UPDATE products SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]' WHERE productId=$id";
				break;

			case 3:
				$sql = "UPDATE products SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]', $columnNames[2]='$columnItems[2]' WHERE productId=$id";
				break;

			case 4:
				$sql = "UPDATE products SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]', $columnNames[2]='$columnItems[2]', $columnNames[3]='$columnItems[3]' WHERE productId=$id";
				break;

			case 5:
				$sql = "UPDATE products SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]', $columnNames[2]='$columnItems[2]', $columnNames[3]='$columnItems[3]', $columnNames[4]='$columnItems[4]' WHERE productId=$id";
				break;

			case 6:
				$sql = "UPDATE products SET $columnNames[0]='$columnItems[0]', $columnNames[1]='$columnItems[1]', $columnNames[2]='$columnItems[2]', $columnNames[3]='$columnItems[3]', $columnNames[4]='$columnItems[4]', $columnNames[5]='$columnItems[5]' WHERE productId=$id";
				break;
		}


		if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully changed.');</script>";
		} else {
  			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
}


////////////////////////// END OF CHANGE PRODUCT //////////////////////////////////



function createMessage ($conn, $sender, $receiver, $message, $messageType){
	$date = date("Y-m-d");
	$time = date("H:i");
	$sql1 = "INSERT INTO messages (messageType ,sender, receiver, message, date, time) VALUES ('$messageType', '$sender', '$receiver', '$message', '$date','$time')";
		
	if (mysqli_query($conn, $sql1)) {
  		//echo "<script>alert('Your message was successfully sent.');</script>";
	} else {
  		echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
	}

}


function createDiscount($conn, $code, $amount, $isPercent){
	$isActive = '1';
	$sql1 = "INSERT INTO discounts (code, amount, isActive, isPercent) VALUES ('$code', $amount, $isActive, $isPercent)";
		
	if (mysqli_query($conn, $sql1)) {
  		//echo "<script>alert('Your message was successfully sent.');</script>";
	} else {
  		echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
	}

}


function checkDiscountCode($conn, $code){
	$sql = "SELECT code FROM discounts WHERE code = '$code'";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "s", $continent);
	mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $code = mysqli_fetch_assoc($result)["code"];
  return $code;
}

function changeDiscountActiveStatus($conn, $discountId, $isActive){
	$sql = "UPDATE discounts SET isActive ='$isActive' WHERE discountId='$discountId'";

	if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully removed.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

function removeDiscount($conn, $discountId){
			$sql = "DELETE FROM discounts WHERE discountId = $discountId";

		if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully removed.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

?>



