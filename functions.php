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

function createAccount($conn, $name, $password, $email, $userType){
	$sql = "INSERT INTO users (orderId, name, pwd, email, userType) VALUES ('1', '$name', '$password', '$email','$userType')";

	if (mysqli_query($conn, $sql)) {
  		echo "<script>alert('Congratulations! Your account was successfully created.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}

function setSessionUser($conn, $email){
	$sql = "SELECT userId, name, userType FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	$_SESSION["userId"] = $row["userId"];
	$_SESSION["name"] = $row["name"];
	$_SESSION["status"] = $row["userType"];
}

function addProduct($conn, $name, $price, $info, $amount, $image){
	$sql = "INSERT INTO products (name, price, amount, info, image) VALUES ('$name', '$price', '$amount', '$info','$image')";

	if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully added.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}


//////////////////////// CHANGE PRODUCT //////////////////////////////////////////

function changeProduct($conn, $id, $name, $price, $info, $amount, $image){

	$numOfcolumns = 0;
	
	$arguments = array();

	$arguments['name'] = $name;
	$arguments['price'] = $price;
	$arguments['info'] = $info;
	$arguments['amount'] = $amount;
	$arguments['image'] = $image;
	

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
		}


		if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully changed.');</script>";
		} else {
  			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
}


////////////////////////// END OF CHANGE PRODUCT //////////////////////////////////



function removeProduct($conn, $id){

		$sql = "DELETE FROM products WHERE productId = $id";

		if (mysqli_query($conn, $sql)) {
  		echo "<script>alert('Your product was successfully removed.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}


?>
