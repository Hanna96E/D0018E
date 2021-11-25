<?php
//Start the session
session_start();
?>

<script>

//check if user is not member	
var userType = '<?=$_SESSION["status"]?>';

switch(userType) {
	case "admin":
    	break;

    default:
    	window.location.replace("/");

}

</script>

<?php 
	include "functions.php";
	include "init.php";
	$conn = connect();
?>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_REQUEST['action'];
	$id = $_REQUEST['id'];
  $name = test_input($_POST['name']);
  $password = test_input($_POST['password']);
  $email = test_input($_POST['email']);
  $userType = test_input($_POST['userType']);
    switch ($action){
      case "remove":
          removeAccount($conn, $id);
          break;
      case "change":
      	$email_result = checkIfEmailExists($conn, $email);
		if(!($email == "") && ($email_result == $email)){
			echo "<script>alert('An account with this email already exists. Please try again with a different email.');</script>";
			}
			//if the email does not exist in database, the account is created.
			elseif($email_result == false){
			changeAccount($conn, $id, $name, $password, $email);
			}
		break;
    }

}

disconnect($conn);


?>

<script>
window.location.replace("/admin_accounts.php");
</script>
