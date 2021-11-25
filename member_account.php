
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
<td><a href="/paymentPage.php"><button> Pay </button></a></td>
<td><a href="/memberOrders.php"><button> Your past orders </button></a></td>
<td><a href="/member_account.php"><button> My account </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>
</table>
</div>

<table><tr><td>Name: </td><td></td><td><?=$_SESSION['name']?></td></tr><br>
	<tr><td>Email: </td><td></td><td><?=$_SESSION['email']?></td></tr><br>
	<tr><td>User type: </td><td></td><td><?=$_SESSION['status']?></td></tr></table>



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
  
  if (!empty($_POST["password"])) {
    $password = test_input($_POST["password"]);
  }

  if (!empty($_POST["password"]) && empty($_POST["password2"])) {
    $password2Err = "Password verification is required";
  } elseif (!empty($_POST["password"]) && !empty($_POST["password2"])) {
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

<br><h5>Change password</h5>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="password"> Password: </label><br>
	<input  type = "password" id = "password" name="password" >
	<span class="error"> <?php echo $passwordErr;?></span>
	<br><br>
	<label for="password2">Verify password: </label><br>
	<input type = "password" id = "password2" name="password2">
	<span class="error"> <?php echo $password2Err;?></span>
	<br><br>
	<input type="submit" name="submit" value="Change password">  
</form>



</div>
</div>
</div>
</div>
</body>

</html>