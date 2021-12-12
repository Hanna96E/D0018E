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
<title>Discounts - bestshop</title>
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
  width: 100%;
  background-color: #0099FF;
  color: white;
  padding: 14px 20px;
  margin: 4px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=text], input[type=number] {
  width: 90%;
  padding: 12px 8px;
  margin: 4px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit]:hover {
  background-color: #0066FF;
}

select {
  width: 90%;
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
  height: 550px;
  border: 10px solid #cce6ff;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}  
div.active {
  position: absolute;
  right: -100px;
  top: 100px;
  background-color: #ffcce6;
  width: 900px;
  height: 550px;
  border: 10px solid #ffcce6;
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 15px;
}
div.inactive {
  position: absolute;
  left: -100px;
  top: 670px;
  background-color: #ccffcc;
  width: 1320px;
  border: 10px solid #ccffcc;
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
<h2 class="pull-left">Discounts </h2>

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

$codeErr = $amountErr = $isPercentErr = "";
$code = $amount = $isPercent = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["code"])) {
    $codeErr = "Code is required";
  } else {
  	$code = test_input($_POST["code"]);
  	$codeResult = checkDiscountCode($conn, $code);
  	if($codeResult == $code){
    $codeErr = "A discount with this code already exists";
  }
  } 
  
  if (empty($_POST["amount"])) {
    $amountErr = "Amount is required";
  } else {
    $amount = test_input($_POST["amount"]);
  }

  if ((empty($_POST["isPercent"])) && ($_POST["isPercent"] != "0")) {
    $isPercentErr = "Currency or percent is required";
  } else {
    $isPercent = test_input($_POST["isPercent"]);
   
  }

    //check if all boxen are filled correcyly
  if(($codeErr == "") && ($amountErr == "") && ($isPercentErr == "")) {
		createDiscount($conn, $code, $amount, $isPercent);
	}

}

?>


<div class="new"><h3>New discount</h3>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="code">Code: <span class="error">* <?php echo $codeErr;?></span></label><br>  
        <input type="text" id = "code" name="code" placeholder="Code..">
        
        <br><br>
        <label for="amount">Amount: <span class="error">* <?php echo $amountErr;?></span></label><br>
        <input type = "number" id = "amount" name="amount" min = "1" placeholder="Amount..">
          
        <br><br>
        <label for="isPercent">Currency or percent: <span class="error">* <?php echo $isPercentErr;?></span></label><br>
        <input type="radio" name="isPercent" <?php if (isset($isPercent) && $isPercent =="0") echo "checked";?> value="0"> Currency
        <br><input type="radio" name="isPercent" <?php if (isset($isPercent) && $isPercent =="1") echo "checked";?> value="1"> Percent
        
        <br><br>
        <input type="submit" name="submit" value="Create discount">  
</form>


</div>

<div class="active"><h3>Active discounts</h3>	


	<table class='table table-bordered table-striped'>
  	<tr>
    <td>Code</td>
    <td>Amount</td>
    <td>Currency or percent</td>
    <td>Active status</td>
    </tr>

    <?php $result = mysqli_query($conn,"SELECT discountId, code, amount, isPercent FROM discounts WHERE isActive = '1'"); ?>

<?php

	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
	}
	array_reverse($rows);

	
	while($row = array_pop($rows)) {
    $id = $row["discountId"];
    $code = $row["code"];
    $amount = $row["amount"];
    $isPercent = $row["isPercent"];
    if ($isPercent == 1){
    	$isPercent = 'Percent';
    } else {
    	$isPercent = 'Currency';
    }

    $notIsActive = '0';
    ?>
    <tr>
    <td><label><?=$code?></label></td>
    <td><label><?=$amount?></label></td>
    <td><label><?=$isPercent?></label></td>
    <td><label>Active</label><br>
    <form method="post" action="manage_discounts.php?action=change&id=<?=$id?>&isActive=<?=$notIsActive?>">
    <input type="submit" name="submit" value="Inactivate">
	</form>
	</td>
    </tr>

<?php
}
?>
</table>


</div>

<div class="inactive"><h3>Inactive discounts</h3>



	<table class='table table-bordered table-striped'>
  	<tr>
    <td>Code</td>
    <td>Amount</td>
    <td>Currency or percent</td>
    <td>Active status</td>
    <td>Delete discount</td>
    </tr>

    <?php $result = mysqli_query($conn,"SELECT discountId, code, amount, isPercent FROM discounts WHERE isActive = '0'"); ?>

<?php

	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
	}
	array_reverse($rows);

	
	while($row = array_pop($rows)) {
    $id = $row["discountId"];
    $code = $row["code"];
    $amount = $row["amount"];
    $isPercent = $row["isPercent"];
    if ($isPercent == 1){
    	$isPercent = 'Percent';
    } else {
    	$isPercent = 'Currency';
    }

    $notIsActive = '1';
    ?>
    <tr>
    <td><label><?=$code?></label></td>
    <td><label><?=$amount?></label></td>
    <td><label><?=$isPercent?></label></td>
    <td><label>Inactive</label><br>
    <form method="post" action="manage_discounts.php?action=change&id=<?=$id?>&isActive=<?=$notIsActive?>">
    <input type="submit" name="submit" value="Activate">
	</form></td>
	<td><label style="color: #ccffcc;"> .</label><br>
	<form method="post" action="manage_discounts.php?action=remove&id=<?=$id?>&isActive=<?=$notIsActive?>">
    <input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this discount?')">
	</form>
	</td>
    </tr>

<?php
}
?>
</table>

</div>




<?php

disconnect();
?>

</div>
</div>
</div>
</div>
</body>

</html>

