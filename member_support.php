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
<title>Support - bestshop</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example{
margin: 20px;
}

div.support {
  position: absolute;
  left: -100px;
  top: 100px;
  background-color: #cce6ff;
  width: 650px;
  height: 600px;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
} 

div.supportTopLeft {
  position: absolute;
  left: 0px;
  top: 35px;
  background-color: #cce6ff;
  width: 360px;
  height: 250px;
  border: 10px solid cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.supportTopRight {
  position: absolute;
  right: 0px;
  top:35px;
  background-color: #cce6ff;
  width: 240px;
  height: 250px;
  border: 10px solid cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.supportBottomLeft {
  position: absolute;
  left: 0px;
  bottom: 0px;
  background-color: #cce6ff;
  width: 320px;
  height: 280px;
  border: 10px solid cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.supportBottomRight {
  position: absolute;
  right: 0px;
  bottom: 0px;
  background-color: #cce6ff;
  width: 280px;
  height: 280px;
  border: 10px solid cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.alert {
  position: absolute;
  right: -100px;
  top: 100px;
  background-color: #ffcce6;
  width: 650px;
  height: 700px;
  border: 10px solid #ffcce6;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.discount {
  position: absolute;
  left: -100px;
  bottom: -1420px;
  background-color: #ccffcc;
  width: 650px;
  height: 800px;
  border: 10px solid #ccffcc;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.other {
  position: absolute;
  right: -100px;
  bottom: -1420px;
  background-color: #ffff80;
  width: 650px;
  height: 700px;
  border: 10px solid #ffff80;
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
<h2 class="pull-left">Support </h2>

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
<br><br>
</div>

<?php
    include "functions.php";
    include "init.php";

    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
   
?>

<div class="support"><h3>Contact information & customer support</h3>
	<div class="supportTopLeft">
		<br>
		<b style="font-size: 24;">Order and shipping questions:</b><br><br>
		<p style="font-size: 18";>Tel: 8357-123456<br>(Phone hours: 06:30-21:30)</p>
		<p style="font-size: 18";>Email: <br>orders-and-shipping@bestshop.com</p>
	</div>
	<div class="supportTopRight">
		<br>
		<b style="font-size: 24";>Other questions:</b><br><br>
		<p style="font-size: 18";>Tel: 8357-123457<br>(Phone hours: 10:00-18:00)</p>
		<p style="font-size: 18";>Email: <br>support@bestshop.com</p>
	</div>
	<div class="supportBottomLeft">
		<br><br>
		<b style="font-size: 24";>Account questions:</b><br><br>
		<p style="font-size: 18";>Tel: 8357-123458<br>(Phone hours: 09:00-17:00)</p>
		<p style="font-size: 18";>Email: <br> account-support@bestshop.com</p>
	</div>
	<div class="supportBottomRight">
		<br><br>
		<b style="font-size: 24";>Product questions:</b><br><br>
		<p style="font-size: 18";>Tel: 8357-123459<br>(Phone hours: 12:00-16:00)</p>
		<p style="font-size: 18";>Email: <br>product-support@bestshop.com</p>
	</div>
	

</div>

<div class="alert"><h3>Alerts</h3>	<table class='table table-bordered table-striped'>
    <tr>
    	<td><label></label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


	<?php $alert_result = mysqli_query($conn,"SELECT * FROM messages WHERE (receiver = '$userId' or receiver = '0') and messageType = 'alert'");


	$rows = array();
	while ($row = mysqli_fetch_array($alert_result)) {
    $rows[] = $row;
	}
	array_reverse($rows);


	while($row = array_pop($rows)) {
	$receiver = $row["receiver"];
	if($receiver == $userId){
		$sender = 'Direct message';
	} else{
		$sender = 'General message';
	}
	$message = $row["message"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

    <tr>
    	<td><label <?php if($sender == 'Direct message') echo "style='color:red;'";?> ><?=$sender?></label></td>
    	<td><label><?=$message?></label></td>
    	<td><label><?=$date?></label></td>
    	<td><label><?=$time?></label></td>

    </tr>


<?php

}
?>

</table>
</div>

  <div class="discount"><h3>Discounts</h3>
<table class='table table-bordered table-striped'>
    <tr>
    	<td><label></label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


	<?php $discount_result = mysqli_query($conn,"SELECT * FROM messages WHERE (receiver = '$userId' or receiver = '0') and messageType = 'discount'");

	$rows = array();
	while ($row = mysqli_fetch_array($discount_result)) {
    $rows[] = $row;
	}
	array_reverse($rows);


	while($row = array_pop($rows)) {
	$receiver = $row["receiver"];
	if($receiver == $userId){
		$sender = 'Direct message';
	} else{
		$sender = 'General message';
	}
	$message = $row["message"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

    <tr>
    	<td><label <?php if($sender == 'Direct message') echo "style='color:red;'";?> ><?=$sender?></label></td>
    	<td><label><?=$message?></label></td>
    	<td><label><?=$date?></label></td>
    	<td><label><?=$time?></label></td>

    </tr>


<?php

}
?>

</table>

  </div>
  <div class="other"><h3>Other messages</h3>
<table class='table table-bordered table-striped'>
    <tr>
    	<td><label></label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


	<?php $other_result = mysqli_query($conn,"SELECT * FROM messages WHERE (receiver = '$userId' or receiver = '0') and messageType = 'other'");

	$rows = array();
	while ($row = mysqli_fetch_array($other_result)) {
    $rows[] = $row;
	}
	array_reverse($rows);

	
	while($row = array_pop($rows)) {
	$receiver = $row["receiver"];
	if($receiver == $userId){
		$sender = 'Direct message';
	} else{
		$sender = 'General message';
	}
	$message = $row["message"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

    <tr>
    	<td><label <?php if($sender == 'Direct message') echo "style='color:red;'";?> ><?=$sender?></label></td>
    	<td><label><?=$message?></label></td>
    	<td><label><?=$date?></label></td>
    	<td><label><?=$time?></label></td>

    </tr>


<?php

}

disconnect();
?>

</table>
</div>
















</div>
</div>
</div>
</div>
</body>

</html>

