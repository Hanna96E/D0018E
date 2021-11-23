<?php
//Start the session
session_start();
?>

<?php

function connect(){
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


function disconnect($conn){
    mysqli_close($conn);
}

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
	$sql = "INSERT INTO users (orderId,name, pwd, email, userType) VALUES ('1','$name', '$password', '$email','$userType')";

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








?>
