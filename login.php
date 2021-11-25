<?php
//Start the session
session_start();
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



<form action="/check_account.php" method="post">
  <label for="email">Email: </label><br>
  <input type="email" id="email" name="email"><br>
  <label for="password">Password: </label><br>
  <input type="password" id="password" name="password"><br><br>
  <input type="submit" value="Enter">
</form> 


</div>
</div>
</div>
</div>
</body>

</html>
