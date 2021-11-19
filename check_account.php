<?php
//Start the session
session_start();
?>


<!DOCTYPE html>
<html>



<?php
	include "functions.php";
	$conn = connect();
	$email = $_POST["email"];
	$password = $_POST["password"];

?>

<?php $userType = login($conn, $email, $password);

	if ($userType == "admin"){
		echo "This is the admin";
	}
	if ($userType == "member"){
		echo "This is a member";
	}

	if ($userType == false){
		echo "Wrong email or paassword";
	}

	if ($userType == "error"){
		echo "Something is seriously wrong...";

	}


	$sql = "SELECT userId, name FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	$_SESSION["userId"] = $row["userId"];
	$_SESSION["name"] = $row["name"];
	
	echo $_SESSION["userId"], "!!!!!!!!!!!!!!!";
	echo $_SESSION["name"], "YES";

	session_unset();

?>



<?php
	disconnect($conn);
?>

</html>