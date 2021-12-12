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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Messages - bestshop</title>
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
  width: 50%;
  background-color: #0099FF;
  color: white;
  padding: 14px 20px;
  margin: 4px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

textarea {
  width: 90%;
  height: 170px;
  padding: 12px 20px;
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

select {
  width: 50%;
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
  width: 650px;
  height: 600px;
  border: 10px solid #cce6ff;
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
<h2 class="pull-left">Messages </h2>

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
    include "functions.php";
    include "init.php";

    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
   
?>

<?php 

$receiverErr = $messageErr = $messageTypeErr = "";
$receiver = $message = $messageType = $date = $time = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((empty($_POST["receiver"])) && ($_POST["receiver"] != "0")) {
    $receiverErr = "Receiver is required";
  } else {
    $receiver = test_input($_POST["receiver"]);
  }
  
  if (empty($_POST["message"])) {
    $messageErr = "Message is required";
  } else {
    $message = test_input($_POST["message"]);
  }

  if (empty($_POST["messageType"])) {
    $messageTypeErr = "Message type is required";
  } else {
    $messageType = test_input($_POST["messageType"]);
   
  }

    //check if all boxen are filled correcyly
  if(($receiverErr == "") && ($messageErr == "") && ($messageTypeErr == "")) {
		createMessage($conn, $userId, $receiver, $message, $messageType);
	}

}

?>


<div class="new"><h3>New message</h3>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="receiver">Receiver: </label><br>  
	<select id="receiver" name="receiver">
	<option value="">Not selected</option>
  	<option value="0">All members</option>
  	<?php $result = mysqli_query($conn,"SELECT userId FROM users WHERE userType = 'member'");

	while($row = mysqli_fetch_array($result)) {
		echo "<option value='". $row['userId'] . "'>". $row['userId'] . "</option>";
	}

  	?>
  	</select>
	<span class="error">* <?php echo $receiverErr;?></span>
	<br><br>
	<label for="message"> Message: </label><br>
	<textarea name="message" id = "message" ></textarea>
	<span class="error">* <?php echo $messageErr;?></span>
	<br><br>
	<label for="messageType">Message type: </label><br>
	<input type="radio" name="messageType" <?php if (isset($messageType) && $messageType =="alert") echo "checked";?> value="alert">Alert
  	<input type="radio" name="messageType" <?php if (isset($messageType) && $messageType =="discount") echo "checked";?> value="discount">Discount
  	<input type="radio" name="messageType" <?php if (isset($messageType) && $messageType =="other") echo "checked";?> value="other">Other  
	<span class="error">* <?php echo $messageTypeErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="Send message">  
</form>


</div>

<div class="alert"><h3>Alert messages</h3>	<table class='table table-bordered table-striped'>
    <tr>
    	<td><label>Sender</label></td>
    	<td><label>Receiver</label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


	<?php $alert_result = mysqli_query($conn,"SELECT * FROM messages WHERE messageType = 'alert'");


	$rows = array();
	while ($row = mysqli_fetch_array($alert_result)) {
    $rows[] = $row;
	}
	array_reverse($rows);


	while($row = array_pop($rows)) {
	$sender = $row["sender"];
	if($sender == $userId){
		$sender = 'You';
	}
	$receiver = $row["receiver"];
	if($receiver == 0){
		$receiver = 'All members';
	}
	$message = $row["message"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

    <tr>
    	<td><label><?=$sender?></label></td>
    	<td><label><?=$receiver?></label></td>
    	<td><label><?=$message?></label></td>
    	<td><label><?=$date?></label></td>
    	<td><label><?=$time?></label></td>

    </tr>


<?php

}
?>

</table>
</div>

  <div class="discount"><h3>Discount messages</h3>
<table class='table table-bordered table-striped'>
    <tr>
    	<td><label>Sender</label></td>
    	<td><label>Receiver</label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


<?php $discount_result = mysqli_query($conn,"SELECT * FROM messages WHERE messageType = 'discount'");

	$rows = array();
	while ($row = mysqli_fetch_array($discount_result)) {
    $rows[] = $row;
	}
	array_reverse($rows);


	while($row = array_pop($rows)) {
	$sender = $row["sender"];
	if($sender == $userId){
		$sender = 'You';
	}
	$receiver = $row["receiver"];
	if($receiver == 0){
		$receiver = 'All members';
	}
	$message = $row["message"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

    <tr>
    	<td><label><?=$sender?></label></td>
    	<td><label><?=$receiver?></label></td>
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
    	<td><label>Sender</label></td>
    	<td><label>Receiver</label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


<?php $other_result = mysqli_query($conn,"SELECT * FROM messages WHERE messageType = 'other'");

	$rows = array();
	while ($row = mysqli_fetch_array($other_result)) {
    $rows[] = $row;
	}
	array_reverse($rows);

	
	while($row = array_pop($rows)) {
	$sender = $row["sender"];
	if($sender == $userId){
		$sender = 'You';
	}
	$receiver = $row["receiver"];
	if($receiver == 0){
		$receiver = 'All members';
	}
	$message = $row["message"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

    <tr>
    	<td><label><?=$sender?></label></td>
    	<td><label><?=$receiver?></label></td>
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
