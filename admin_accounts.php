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

    case "distributer":
        window.location.href = "/distributer_start.php";
	   	break;

	case "member":
		window.location.href = "/member_start.php";
		break;

    default:
    	window.location.replace("/");

}
</script>

<?php
    include "functions.php";
    include "init.php";

    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Manage accounts - bestshop</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style type="text/css"> .bs-example{margin: 20px;}</style>
        <script type="text/javascript">$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
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
    <h2 class="pull-left">Manage accounts</h2>

    <!--ADMIN MENUE BAR-->
<table>
<tr>
<td><a href="/admin_start.php"><button> Home </button></a></td>
<td><a href="/admin_products.php"><button> Manage products </button></a></td>
<td><a href="/adminOrders.php"><button> Manage orders </button></a></td>
<td><a href="/admin_accounts.php"><button> Manage accounts </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>
</table>
<br><br>

</div>


<?php

$nameErr = $passwordErr = $emailErr = $userTypeErr = "";
$name = $password = $email = $userType ="";
$orderId = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
  
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    $email_result = checkIfEmailExists($conn, $email);
	if($email_result == $email){
		$emailErr = "An account with this email already exists.";
	}
  }

  if (empty($_POST["userType"])) {
    $userTypeErr = "User type is required";
  } else {
    $userType = test_input($_POST["userType"]);
    if ($userType == 'member'){
    	$orderId = '1';
    }
  }

  //check if all boxen are filled correcyly
  if(($nameErr == "") && ($passwordErr == "") && ($emailErr == "") && ($userTypeErr == "")) {
		createAccount($conn, $orderId, $name, $password, $email, $userType);
	}
 }



?>


    <table class='table table-bordered table-striped'>

    <tr>
    <td>User id</td>
    <td>Name</td>
    <td>Password</td>
    <td>Email</td>
    <td>User type</td>
    <td></td>
    </tr>

    <tr><p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <td></td>
    <td>    <label for="name">Name: * </label><br><br>  
            <input type="text" id = "name" name="name" style="width: 150px;">
            <br><span class="error"> <?php echo $nameErr;?></span>
    </td>

    <td>
            <label for="password">Password: * </label><br><br>
            <input type = "text" id = "password" name="password" min = "0" style="width: 100px;">
            <br><span class="error"> <?php echo $passwordErr;?></span>
    </td>

    <td>
            <label for="email">Email: * </label><br><br>
            <input type = "email" id = "email" name="email" min = "0" style="width: 150px;">
            <br><span class="error"> <?php echo $emailErr;?></span>
    </td>
    <td>
            <label for="userType">User type: *</label><br><br>
            <input type="radio" name="userType" <?php if (isset($userType) && $userType =="admin") echo "checked";?> value="admin">Admin
  			<input type="radio" name="userType" <?php if (isset($userType) && $userType =="distributer") echo "checked";?> value="distributer">Distributer
  			<input type="radio" name="userType" <?php if (isset($userType) && $userType =="member") echo "checked";?> value="member">Member  
  			<br><span class="error"> <?php echo $userTypeErr;?></span>
    </td>
    <td><br><br>
    <input type="submit" name="submit" value="Add account"> 
    </td></form></tr>


<?php $result = mysqli_query($conn,"SELECT * FROM users"); ?>

<?php
    disconnect($conn);
?>

<?php

if (mysqli_num_rows($result) > 0) {
?>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
    $id = $row["userId"];
    $name = $row["name"];
    $password = $row["pwd"];
    $email = $row["email"];
    $userType = $row["userType"];
    ?>

    <tr><form method="post" action="manage_accounts.php?action=change&id=<?=$id?>">
    <td>    <br><br><label for="id"><?=$id?> </label><br><br>  
    </td>

    <td>
            <label for="name"><?=$name?> </label><br><br>
            <input type = "text" id = "name" name="name" style="width: 150px;">
    </td>

    <td>    <label for="password"><?=$password?></label><br><br>
            <input type = "text" name="password" id = "password" style = "width: 100px"></textarea>

    </td>
    <td>
            <label for="email"><?=$email?></label><br><br>
            <input type = "email" id = "email" name="email" style="width: 150px;">
    </td>
    <td>
            <label for="userType"><?=$userType?></label><br><br>
    </td>
    <td>
    <input type="submit" name="submit" value="Submit changes">
    <br><br><br>
    </form>
    <form method="post" action="manage_accounts.php?action=remove&id=<?=$id?>">
    <input type="submit" name="submit" value="Remove account">
    </td> </form>
    </tr>


<?php
$i++;
}
?>
</table>
<?php
}
else{
echo "No result found";
}
?>



    </div>
    </div>
    </div>
    </div>
    </body>
</html>
