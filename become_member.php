<?php
//Start the session
session_start();
?>

<?php
	include "functions.php";
	include "init.php";
	$conn = connect();
?>

<?php
// define variables and set to empty values
$orderId = '1';
$userType = "member";
$nameErr = $passwordErr = $password2Err= $emailErr  = "";
$name = $password = $password2 = $email = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and whitespace is allowed";
    }
  }
  
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  if (empty($_POST["password2"])) {
    $password2Err = "Password verification is required";
  } else {
    $password2 = test_input($_POST["password2"]);
    if($_POST["password"] != $_POST["password2"]){
    	$password2Err = "Password did not match";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    $email_result = checkIfEmailExists($conn, $email);
		if($email_result == $email){
			$emailErr = "An account with this email already exists.";
		}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

//check if all boxen are filled correcyly
 if(($nameErr == "") && ($passwordErr == "") && ($password2Err == "") && ($emailErr == "")) {
		createAccount($conn, $orderId, $name, $password, $email, $userType);
		setSessionUser($conn, $email);
		disconnect($conn);
 }
    
}

?>
<script>
	//check if already logged in
var userType = '<?=$_SESSION["status"]?>';

switch(userType) {
	case "admin":
		window.location.href = "/admin_start.php";
    	break;
	
	case "member":
		window.location.href = "/member_start.php";
    	break;

    case "distributer":
    window.location.href = "/distributer_start.php";
	   	break;

    default:
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Become member - bestshop</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example{
margin: 20px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});
</script>
<style>
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
  width: 1000px;
  height: 450px;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.newLeft {
  position: absolute;
  left: 0px;
  top: 20px;
  background-color: #cce6ff;
  width: 450px;
  height: 400px;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.newRight {
  position: absolute;
  right: 0px;
  top: 20px;
  background-color: #cce6ff;
  width: 450px;
  height: 400px;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
</style>
</head>
<body>
<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header clearfix">
<h2 class="pull-left">Become member</h2>
<h4><a href="index.html"><button> Home </button></a></h4>
</div>


<div class="new">

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	
	<div class="newLeft">
	
	<label for="name">Name: </label><br>  
	<input type="text" id = "name" name="name" placeholder="Name..">
	<span class="error">* <?php echo $nameErr;?></span>
	<br><br>
	<label for="email">Email: </label><br>
	<input type="text" id = "email" name="email" placeholder="Email..">
	<span class="error">* <?php echo $emailErr;?></span>
	<br><br><input type="submit" name="submit" value="Create account"> 
	</div>
	<div class="newRight">
	
	<label for="password"> Password: </label><br>
	<input  type = "password" id = "password" name="password" placeholder="Password..">
	<span class="error">* <?php echo $passwordErr;?></span>
	<br><br>
	<label for="password2">Verify password: </label><br>
	<input type = "password" id = "password2" name="password2" placeholder="Verify password..">
	<span class="error">* <?php echo $password2Err;?></span>
	
	</div>

	 
</form>

</div>


</div>
</div>
</div>
</div>
</body>
</html>
