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
<title>Admin start - bestshop</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example{
margin: 20px;
}

.dropdown1 {
  position: relative;
  display: inline-block;
}

.dropdown1-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown1:hover .dropdown1-content {
  display: block;
}

div.newMessages {
  position: absolute;
  left: 0px;
  top: 30px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 100%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}  
div.newMembers {
  position: absolute;
  left: 0px;
  top: 605px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 61%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.mostActiveMembers {
  position: absolute;
  right: 0px;
  top: 605px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 41%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.reviews {
  position: absolute;
  left: 0px;
  top: 1180px;
  background-color: #2D4263;
  width: 100%;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.productReviews {
  position: relative;
  background-color: #ECDBBA;
  width: 98%;
  height: 340px;
  border: 10px solid #ECDBBA;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 10px;
}
div.review {
  position: absolute;
  top: 90px;
  background-color: #C84B31;
  width: 250px;
  height: 210px;
  border: 5px solid #C84B31;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 10px;
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
    headerAdmin("Welcome!");
?>

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

<div class = newMessages><h3>Recent messages</h3>
	<table class='table table-bordered table-striped' style="color: #ECDBBA;">

		<tr>
    	<td><label>Sender</label></td>
    	<td><label>Receiver</label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>

    <?php $result = mysqli_query($conn,"SELECT * FROM messages");


	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
	}
	array_reverse($rows);
	$i = 0;
	while($i < 10 && $row = array_pop($rows)) {
	$sender = $row["sender"];
	if($sender == $userId){
		$sender = 'You';
	}
	$receiver = $row["receiver"];
	if($receiver == 0){
		$receiver = 'All members';
	}
	$message = $row["message"];
	$messageType = $row["messageType"];
	$date = $row["date"];
	$time = $row["time"];
    ?>

        <tr>
    	<td><label><?=$sender?></label></td>
    	<td><label><?=$receiver?></label></td>
    	<td><label><b>Message type: <?=$messageType?></b><br>
    				<?=$message?></label></td>
    	<td><label><?=$date?></label></td>
    	<td><label><?=$time?></label></td>
    	</tr>

    <?php $i++;} ?>


	</table>
</div>

<div class = newMembers><h3>Newest members</h3>
	<table class='table table-bordered table-striped' style="color: #ECDBBA;">

		<tr>
    	<td><label>User id</label></td>
    	<td><label>Name</label></td>
    	<td><label>Email</label></td>
    </tr>

    <?php $result = mysqli_query($conn,"SELECT userId, name, email FROM users WHERE userType = 'member'");


	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
	}
	array_reverse($rows);
	$i = 0;
	while($i < 10 && $row = array_pop($rows)) {
	
	$id = $row["userId"];
	$name = $row["name"];
	$email = $row["email"];
    ?>
        <tr>
    	<td><label><?=$id?></label></td>
    	<td><label><?=$name?></label></td>
    	<td><label><?=$email?></label></td>
    	</tr>

    <?php $i++;} ?>

</table>
</div>

<div class = mostActiveMembers><h3>Most active members</h3>
		<table class='table table-bordered table-striped' style="color: #ECDBBA;">

		<tr>
    	<td><label>User id</label></td>
    	<td><label>Total purchase amount</label></td>
    	</tr>

	<?php
	$resultUsers = mysqli_query($conn, "SELECT userId FROM users WHERE userType = 'member'");
	
	while($row = mysqli_fetch_array($resultUsers)) {
		$id = $row['userId'];
		$sum = 0;
		$sums[] = array();
		$resultOrder = mysqli_query($conn,"SELECT totalCost FROM orders WHERE userId = $id");

		while($row1 = mysqli_fetch_array($resultOrder)) {
			$sum += $row1['totalCost'];
		}
		$sums[$id] = $sum;
	}
	arsort($sums);

	$i = 0;
	foreach($sums as $id => $sum) {
		if($sum > 0 && ($sum != null)){ ?>
			<tr>
    		<td><label><?=$id?></label></td>
    		<td><label><?=$sum?></label></td>
    		</tr>
	<?php }
	}

	?>


</table>	
</div>

<div class = reviews><h3 style="color: #ECDBBA;">Reviews</h3>

	<?php

	$prodResult = mysqli_query($conn, "SELECT productId, name, image FROM products");

	while($prodRow = mysqli_fetch_array($prodResult)){

		$productId = $prodRow['productId'];
		$productName = $prodRow['name'];
		$productImage = $prodRow['image'];

		$result = mysqli_query($conn, "SELECT * FROM reviews WHERE productId = $productId");

		if (mysqli_num_rows($result) > 0) {

		?>
			<div class = productReviews>
			<h5> <div class="dropdown1">
             <img src="<?=$productImage?>" width="60" height="60">
             <div class="dropdown1-content">
             <img src="<?=$productImage?>" width="200" height="200">
             </div></div> Product id: <?=$productId?> <br><?=$productName?>
       		 </h5>

        <?php
	
		$rows = array();
		while($row = mysqli_fetch_array($result)) {		
    			$rows[] = $row;
		}
		array_reverse($rows);
		$leftPos = 0;
		while($row = array_pop($rows)) {
			$uid = $row['userId'];
			$text = $row['reviewText'];
			?>
			<div class = "review" style = "left: <?=$leftPos?>;">
			<p>User id: <?=$uid?> </p>
			<?php
			$rating = $row["numStar"];
    		for ($i=0; $i < 5; $i++) {
        		if ($i<$rating) {
           		 	echo '<span class="fa fa-star checked" style="color:gold;"></span>';
        		}else{
            		echo '<span class="fa fa-star checked" style="color:white;"></span>';
        		}
    		}?>

    		<br><br><p><?=$text?></p>
		

			</div>

			<?php
			$leftPos += 270;	
			}
			?></div><?php
			

		}

	}
disconnect();

	?>
	
</div>


</div>
</div>
</div>
</div>
</body>

</html>