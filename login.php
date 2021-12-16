<?php
//Start the session
session_start();
?>

<?php
	include "functions.php";
	include "init.php";
	$conn = connect();

	$passwordErr = $emailErr = "";
	$password = $email = $userType ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  	} else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    $email_result = checkIfEmailExists($conn, $email);
		if($email_result != $email){
			$emailErr = "An account with this email does not exist.";
		}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
  
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  //check if all boxes are filled correcyly
  if(($passwordErr == "") && ($emailErr == "")) {
 		$userType = login($conn, $email, $password);
		if ($userType == false){
		$passwordErr = "Wrong password";
		} else if ($userType == "error"){
		echo "An error has occured, please resturn to login-page and try again.";
		} else{
				setSessionUser($conn, $email);
				disconnect($conn);
		}

 	}
 }

?>


<script>
	//check if already logged in
var userType = '<?=$_SESSION["status"]?>';

switch(userType) {
	case "admin":
		window.location.replace("/admin_start.php");
    	break;
	
	case "member":
		window.location.replace("/member_start.php");
    	break;

    case "distributer":
    	window.location.replace("/distributer_start.php");
	   	break;

    default:

}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Log in - bestshop</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example{
margin: 20px;
}


div.new {
  position: absolute;
  left: 25%;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 50%;
  border: 25px solid #C84B31;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php
    include_once "visualFunctions.php";
?>


</head>
<body class=bodyClass>

<?php
    headerNotLoggedIn("Log in");
?>
<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">


<div class="new">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="email">Email: </label><br>
	<input type="text" id = "email" name="email" placeholder="Email.." style="width: 100%;">
	<br><span class="error"> <?php echo $emailErr;?></span>
	<br><br>
	<label for="password"> Password: </label><br>
	<input  type = "password" id = "password" name="password" placeholder="Password.." style="width: 100%;">
	<br><span class="error"> <?php echo $passwordErr;?></span>
	
	<br><br>
	<input type="submit" name="submit" value="Login" style="width: 50%; padding: 20px 0px;">  
</form>

</div>

</div>
</div>
</div>
</div>
</body>

</html>
