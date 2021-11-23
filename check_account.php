<?php
//Start the session
session_start();
?>

<!DOCTYPE html>
<html>



<?php
	include "functions.php";
	$conn = connect();
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);

?>

<?php $userType = login($conn, $email, $password);

	// set session variables, Name, UID and userType.
	setSessionUser($conn, $email);

	disconnect($conn);
	
?>


<script>
	//Check what type of user
var userType = '<?=$_SESSION["status"]?>';

switch(userType) {
	case "admin":
		window.location.href = "/admin_start.php";
    	break;
	
	case "member":
		window.location.href = "/member_start.php";
    	break;

    case "distributer":
	   	break;

    default:

}
</script>


<?php


	if ($userType == false){
		echo "Wrong email or password";
		session_unset(); 
		session_destroy();
	}

	if ($userType == "error"){
		echo "An error has occured, please resturn to login-page and try again.";
		session_unset(); 
		session_destroy();

	}

	/* session unset for testing only */
	//session_unset();


?>

<br><br><br>
<a href="login.php"><button> Return to login </button></a>

</html>