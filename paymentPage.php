<!DOCTYPE html>
<html lang="en">
<head>
	<title>Payment Page - bestshop</title>
</head>

<?php include 'init.php';?>

<body>
	<p>Test</p>


	<form action="paymentDone.php" method="get">
	Adress: <input type="text" name="adress"><br>
	E-mail: <input type="text" name="email"><br>
	<input type="submit">
	</form>

<?php
	$adressErr = $emailErr = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["adress"])) {
			$adressErr = "Adress is required";
		} else {
			$name = test_input($_POST["adress"]);
		}
		
		if (empty($_POST["email"])) {
			$emailErr = "Email is required";
		} else {
			$email = test_input($_POST["email"]);
		}
?>

</body>