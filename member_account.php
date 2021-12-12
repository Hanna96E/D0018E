
<?php
//Start the session
session_start();
?>

<script>

//check if user is not member	
var userType = '<?=$_SESSION["status"]?>';

switch(userType) {
	case "admin":
		window.location.href = "/admin_start.php";
    	break;

    case "distributer":
    	window.location.href = "/distributer_start.php";
	   	break;

	case "member":
		break;

    default:
    	window.location.replace("/");

}

</script>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>My account - bestshop</title>
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

div.account {
  position: absolute;
  left: 0px;
  top: 100px;
  background-color: #cce6ff;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.new {
  position: absolute;
  right: 0px;
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
</head>
<body>
<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header clearfix">
<h2 class="pull-left">My account <?=$_SESSION["name"]?>! </h2>

<!--MEMBER MENUE BAR-->
<table>
<tr>
<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/member_account.php"><button> My account </button></a></td>
<td><a href="/member_support.php"><button> Support </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>
</table>
</div>


<?php
	include "functions.php";
	include "init.php";
	$conn = connect();
	$userId = $_SESSION["userId"];
?>

<?php
// define variables and set to empty values
$userType = "member";
$passwordErr = $password2Err = "";
$name = $password = $password2 = $email = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {  
   
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


//check if all boxes are filled correctly
 if(($nameErr == "") && ($passwordErr == "") && ($password2Err == "") && ($emailErr == "")) {
		changeAccount($conn, $userId, $name, $password, $email);
		disconnect($conn);
		echo "<script>alert('Your password was successfully changed.');</script>";
	}
}
    

?>

<div class="account"><h3>Account information</h3>
	<b style="font-size: 26;">Name:</b><p style="font-size: 26;"><?=$_SESSION['name']?></p><br>
	<b style="font-size: 26;">Email:</b><p style="font-size: 26;"><?=$_SESSION['email']?></p><br>
	<b style="font-size: 26;">User type:</b><p style="font-size: 26;"><?=$_SESSION['status']?></p><br>
</div>

<div class="new"><h3>Change password</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="password"> Password: </label><br>
	<input  type = "password" id = "password" name="password" placeholder="New password..">
	<span class="error"> <?php echo $passwordErr;?></span>
	<br><br>
	<label for="password2">Verify password: </label><br>
	<input type = "password" id = "password2" name="password2" placeholder="Verify new password..">
	<span class="error"> <?php echo $password2Err;?></span>
	<br><br>
	<input type="submit" name="submit" value="Change password">  
</form>

</div>

</div>
</div>
</div>
</div>
</body>

</html>