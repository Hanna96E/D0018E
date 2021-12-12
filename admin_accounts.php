
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
        //window.location.href = "/distributer_start.php";
        break;

    case "member":
        //window.location.href = "/member_start.php";
        break;

    default:
        //window.location.replace("/");

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
        <title>Manage products - bestshop</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style type="text/css"> .bs-example{margin: 20px;}</style>
        <script type="text/javascript">$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
    <style type="text/css">
.bs-example{
margin: 20px;
}

.error {color: #FF0000;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}


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

textarea {
  width: 100%;
  height: 170px;
  padding: 8px 10px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  background-color: #FFFFFF;
  font-size: 16px;
  resize: none;
}

input[type=submit]:hover {
  background-color: #0066FF;
}

input[type=text], input[type=number], input[type=email] {
  width: 90%;
  padding: 12px 8px;
  margin: 4px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

select {
  width: 80%;
  padding: 5px 15px;
  border: none;
  border-radius: 4px;
  background-color: #FFFFFF;
}

div.new {
  position: absolute;
  left: -100px;
  top: 100px;
  background-color: #cce6ff;
  width: 400px;
  height: 645px;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
} 


div.admDis {
  position: absolute;
  right: -100px;
  top: 100px;
  background-color: #ffcce6;
  width: 900px;
  height: 645px;
  border: 10px solid #ffcce6;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.members {
  position: absolute;
  left: -100px;
  top: 765px;
  background-color: #ccffcc;
  width: 1320px;
  border: 10px solid #ccffcc;
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
    <h2 class="pull-left">Manage products</h2>

    <!--ADMIN MENUE BAR-->
<table>
<tr>
<td><a href="/admin_start.php"><button> Home </button></a></td>
<td><a href="/admin_products.php"><button> Manage products </button></a></td>
<td><a href="/admin_orders.php"><button> Manage orders </button></a></td>
<td><a href="/admin_accounts.php"><button> Manage accounts </button></a></td>
<td><a href="/admin_messages.php"><button> Messages </button></a></td>
<td><a href="/admin_discounts.php"><button> Discounts </button></a></td>
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




<div class="new"><h3>New Account</h3>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Name: <span class="error">* <?php echo $nameErr;?></span></label><br>  
        <input type="text" id = "name" name="name" placeholder="Name..">
        
        <br><br>
        <label for="password">Password: <span class="error">* <?php echo $passwordErr;?></span></label><br>
        <input type = "text" id = "password" name="password" placeholder="Password..">
        
        <br><br>
        <label for="email">Email: <span class="error">* <?php echo $emailErr;?></span></label><br>
        <input type = "email" id = "email" name="email" placeholder="Email..">
        
        <br><br>
        <label for="userType">User type: <span class="error">* <?php echo $userTypeErr;?></span></label><br>
        <input type="radio" name="userType" <?php if (isset($userType) && $userType =="admin") echo "checked";?> value="admin">Admin
        <input type="radio" name="userType" <?php if (isset($userType) && $userType =="distributer") echo "checked";?> value="distributer">Distributer
        <input type="radio" name="userType" <?php if (isset($userType) && $userType =="member") echo "checked";?> value="member">Member
        
        <br><br><br>
        <input type="submit" name="submit" value="Create account">  
</form>
</div>

<div class="admDis"><h3>Administrators and distributors </h3> 
    
    <table class='table table-bordered table-striped'>

    <tr>
    <td>User id</td>
    <td>Name</td>
    <td>Password</td>
    <td>Email</td>
    <td>User type</td>
    <td></td>
    </tr>

<?php $result = mysqli_query($conn,"SELECT * FROM users WHERE userType ='admin'  || userType = 'distributer'"); ?>

<?php

if (mysqli_num_rows($result) > 0) {
?>
<?php
while($row = mysqli_fetch_array($result)) {
    $id = $row["userId"];
    $name = $row["name"];
    $password = $row["pwd"];
    $email = $row["email"];
    $userType = $row["userType"];
    ?>

    <tr><form method="post" action="manage_accounts.php?action=change&id=<?=$id?>">
    <td>    <br><br><br><br><label for="id"><?=$id?> </label><br><br>  
    </td>

    <td>
            <br><br><label for="name"><?=$name?></label>
            <br><br><input type = "text" id = "name" name="name" style="width: 130px;" placeholder="New name..">
    </td>

    <td>   
            <br><br><label for="password"><?=$password?></label>
            <br><br><input type = "text" id = "password" name="password" style="width: 130px;" placeholder="New password..">
    </td>
    <td>
            <br><br><label for="email"><?=$email?></label>
            <br><br><input type = "email" id = "email" name="email" style="width: 180px;" placeholder="New email..">
    </td>
    <td>
            <br><br><br><br><label for="userType"><?=$userType?></label>
    </td>
    <td>
    <br>
    <input type="submit" name="submit" value="Submit changes">
    <br><br>
    </form>
    <form method="post" action="manage_accounts.php?action=remove&id=<?=$id?>">
    <input type="submit" name="submit" value="Remove account" onclick="return confirm('Are you sure you want to remove this account?')">
    </td> </form>
    </tr>


<?php
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

<div class="members"><h3>Members</h3>
    
    <table class='table table-bordered table-striped'>

    <tr>
    <td>User id</td>
    <td>Name</td>
    <td>Password</td>
    <td>Email</td>
    <td>User type</td>
    <td></td>
    </tr>

<?php $result = mysqli_query($conn,"SELECT * FROM users WHERE userType = 'member'"); ?>

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
    <td>    <br><br><br><br><label for="id"><?=$id?> </label><br><br>  
    </td>

    <td>
            <br><br><label for="name"><?=$name?></label>
            <br><br><input type = "text" id = "name" name="name" style="width: 250px;" placeholder="New name..">
    </td>

    <td>   
            <br><br><label for="password"><?=$password?></label>
            <br><br><input type = "text" id = "password" name="password" style="width: 250px;" placeholder="New password..">
    </td>
    <td>
            <br><br><label for="email"><?=$email?></label>
            <br><br><input type = "email" id = "email" name="email" style="width: 300px;" placeholder="New email..">
    </td>
    <td>
            <br><br><br><br><label for="userType"><?=$userType?></label>
    </td>
    <td>
    <br>
    <input type="submit" name="submit" value="Submit changes">
    <br><br>
    </form>
    <form method="post" action="manage_accounts.php?action=remove&id=<?=$id?>">
    <input type="submit" name="submit" value="Remove account" onclick="return confirm('Are you sure you want to remove this account?')">
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
    </div>
    </body>
</html>
