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
<title>My page - bestshop</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example{
margin: 20px;
}

a:link {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

a:active {
  text-decoration: underline;
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
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  height: 600px;
  width: 72%;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}  
div.activeDiscounts {
  position: absolute;
  right: 0px;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 31%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.discount {
  position: relative;
  background-color: #ECDBBA;
  width: 95%;
  border: 15px solid #ECDBBA;
  padding: 5px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.popularProducts {
  position: absolute;
  left: 0px;
  top: 580px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 100%;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
  
}


div.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  background-color: #2D4263;
  padding: 10px;
}
div.grid-item {
  background-color: #ECDBBA;
  border: 5px solid #2D4263;
  padding: 20px;
  font-size: 30px;
  text-align: center;
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
    headerMember("Welcome!");
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

<div class="newMessages"><h3><a href="/member_support.php" style="color: #ECDBBA;">Latest messages</a></h3>
	<table class='table table-bordered table-striped' style="color: #ECDBBA;">
    <tr>
    	<td><label></label></td>
    	<td><label>Message</label></td>
    	<td><label>Date</label></td>
    	<td><label>Time</label></td>
    </tr>


	<?php $result = mysqli_query($conn,"SELECT * FROM messages WHERE receiver = '$userId' or receiver = '0'");


	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
	}
	array_reverse($rows);

	$i = 0;
	while(($row = array_pop($rows)) && ($i < 15)) {
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
    $i++;
	}
	?>
</table>
</div>

<div class="activeDiscounts"><h3><a href="/member_support.php" style="color: #ECDBBA;">Active discounts</a></h3>

	<?php $result = mysqli_query($conn,"SELECT * FROM discounts WHERE isActive = '1'");


	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
	}
	array_reverse($rows);

	$i = 0;
	while(($row = array_pop($rows)) && ($i < 15)) {
	?><div class="discount"> <?php
	$code = $row["code"];
	if($row['isPercent']){
		$symbol = '%';
	} else{
		$symbol = 'kr';
	}
	$amount = $row["amount"];
    ?>

    <b style="color: black;">CODE: <?=$code?></b><br>
    <p style="color: black;">Amount: <?=$amount?> <?=$symbol?></p>
	</div>
    <?php
    $i++;
	}
	?>
</div>

<div class="popularProducts"><h3><a href="/productsForMember.php" style="color: #ECDBBA;">Popular products</a></h3>


	<?php
	$resultProd = mysqli_query($conn, "SELECT productId FROM products");
	
	while($row = mysqli_fetch_array($resultProd)) {
		$id = $row['productId'];
		$sum = 0;
		$sums[] = array();
		$resultItemLst = mysqli_query($conn,"SELECT amount FROM itemList WHERE productId = $id");

		while($row1 = mysqli_fetch_array($resultItemLst)) {
			$sum += $row1['amount'];
		}
		$sums[$id] = $sum;
	}
	arsort($sums);?>
	<div class="grid-container">	
	<?php $i = 0;
	foreach($sums as $id => $sum) {
		if($sum > 0 && ($sum != null)){
			if($i > 15){break; }
			
			$result = mysqli_query($conn, "SELECT name, image, price FROM products WHERE productId=$id");
			$row = mysqli_fetch_array($result);
			$name = $row['name'];
			$price = $row['price'];
			$image = $row['image'];?>
			<div class= "grid-item">
				<a href="/productsForMember"><div class="dropdown1">
                    <img src="<?=$image?>" width="150" height="150">
                    <div class="dropdown1-content">
                    <img src="<?=$image?>" width="350" height="350">
                 </div></div></a>
				<p style="color: black;"><?=$name?></p>
				<p style="color: black;"><?=$price?> kr</p>
			</div>

		<?php $i++;}} ?>

	</div>
</div>

<?php disconnect();?>

</div>
</div>
</div>
</div>
</body>

</html>
