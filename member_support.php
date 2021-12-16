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
  left: 0px;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 55%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.grid-container {
  display: grid;
  grid-template-columns: auto auto;
  background-color: #2D4263;
  padding: 10px;
}
div.grid-item {
  background-color: #ECDBBA;
  border: 5px solid #2D4263;
  padding: 20px;
  color: black;
  text-align: center;
  border-radius: 15px;
}

div.alert {
  position: absolute;
  right: 0px;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 47%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.discount {
  position: absolute;
  left: 0px;
  top: 580px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 53%;
  height: 700px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.other {
  position: absolute;
  right: 0px;
  top: 580px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 49%;
  height: 700px;
  border: 25px solid #C84B31;
  padding: 10px;
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
    headerMember("Support");
?>
<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">

<?php
    include "functions.php";
    include "init.php";

    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
   
?>

<div class="support"><h3>Contact information & customer support</h3>
  <div class="grid-container">
	<div class="grid-item">
		<br>
		<b style="font-size: 20;">Order questions:</b><br>
		<p style="font-size: 14";>Tel: 8357-123456<br>(Phone hours: 06:30-21:30)</p>
		<p style="font-size: 14";>Email: <br>orders-and-shipping@bestshop.com</p>
	</div>
	<div class="grid-item">
		<br>
		<b style="font-size: 20";>Other questions:</b><br>
		<p style="font-size: 14";>Tel: 8357-123457<br>(Phone hours: 10:00-18:00)</p>
		<p style="font-size: 14";>Email: <br>support@bestshop.com</p>
	</div>
	<div class="grid-item">
		<br><br>
		<b style="font-size: 20";>Account questions:</b><br>
		<p style="font-size: 14";>Tel: 8357-123458<br>(Phone hours: 09:00-17:00)</p>
		<p style="font-size: 14";>Email: <br> account-support@bestshop.com</p>
	</div>
	<div class="grid-item">
		<br><br>
		<b style="font-size: 20";>Product questions:</b><br>
		<p style="font-size: 14";>Tel: 8357-123459<br>(Phone hours: 12:00-16:00)</p>
		<p style="font-size: 14";>Email: <br>product-support@bestshop.com</p>
	</div>
  </div>
	

</div>

<div class="alert"><h3>Alerts</h3>	<table class='table table-bordered table-striped' style="color: #ECDBBA;">
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
    	<td><label <?php if($sender == 'Direct message') echo "style='color: #C84B31;'";?> ><?=$sender?></label></td>
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
<table class='table table-bordered table-striped' style="color: #ECDBBA;">
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
    	<td><label <?php if($sender == 'Direct message') echo "style='color: #C84B31;'";?> ><?=$sender?></label></td>
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
<table class='table table-bordered table-striped' style="color: #ECDBBA;">
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
    	<td><label <?php if($sender == 'Direct message') echo "style='color: #C84B31;'";?> ><?=$sender?></label></td>
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

