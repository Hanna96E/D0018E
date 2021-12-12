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

.error {color: #FF0000;}

input[type=submit] {
  width: 100%;
  background-color: #0099FF;
  color: white;
  padding: 14px 20px;
  margin: 4px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #0066FF;
}

input[type=text], input[type=password], input[type=email] {
  width: 100%;
  padding: 12px 8px;
  margin: 4px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}


div.new {
  position: absolute;
  left: -100px;
  top: 100px;
  background-color: #cce6ff;
  width: 600px;
  border: 10px solid #cce6ff;
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
</head>
<body>
<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header clearfix">
<h2 class="pull-left">Log in to account </h2>
<h4><a href="index.html"><button> Home </button></a></h4>
</div>




<div class="new">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="email">Email: </label><br>
	<input type="text" id = "email" name="email" placeholder="Email..">
	<br><span class="error"> <?php echo $emailErr;?></span>
	<br><br>
	<label for="password"> Password: </label><br>
	<input  type = "password" id = "password" name="password" placeholder="Password..">
	<br><span class="error"> <?php echo $passwordErr;?></span>
	
	<br><br>
	<input type="submit" name="submit" value="Log in">  
</form>

</div>

</div>
</div>
</div>
</div>
</body>

</html>
