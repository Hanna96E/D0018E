<?php
// Start the session
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
	window.location.href = "/distributerStart.php";
        break;

    case "member":
        break;

    default:
//       window.location.replace("http://130.240.200.56/paymentPage.php");

}

</script>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Payment Page - bestshop</title>
</head>

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

<?php 
	include "init.php";
	$conn = connect();
?>
<body>

<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header clearfix">
<h2 class="pull-left">Payment Page</h2>
</div>

<?php
// Welcome the user
$userId = "2"; //member=2, admin=1
$orderId = "1";

$userName = "SELECT `name` FROM `users` WHERE `userId`=$userId";
$userName = mysqli_query($conn,$userName);
$name = mysqli_fetch_array($userName);
?>
	<h4> Welcome <?php echo $name[name];?> </h4>

<?php
// Tell of what products are in the shoping cart
$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
$items = mysqli_query($conn,$sqlItems); //Items in cart
$prodInfo = mysqli_query($conn,"SELECT `name`,`image` FROM products");

?>
<?php
if (mysqli_num_rows($prodInfo) > 0 && mysqli_num_rows($items) > 0 ) {
?>
<table class='table table-bordered table-striped'>
<tr> <td>Product</td> <td>Amount</td> <td></td> </tr>

<?php
// Running through and printing the users shopping cart
while($row = mysqli_fetch_array($prodInfo)) {
	$amount = mysqli_fetch_array($items);
?>	<tr>
	<td><?php echo $row["name"]; ?></td> <td><?php echo $amount["amount"]; ?></td>
	<td><img src="<?php echo $row['image']; ?>" style="width:50px;height:50px;"  >
	</tr>
<?php
}}
?>
</table>

	<form action="/paymentDone.php" method="post">
	Adress: <input type="text" name="adress"><br>
	E-mail: <input type="text" name="email"><br>
	Buy: <input type="submit">
	</form>

<?php
// We are only looking for input on paymentpage
disconnect($conn);
?>
</body>
