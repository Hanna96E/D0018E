<?php
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
        //window.location.href = "/member_start.php";
        break;

    default:
        window.location.replace("/");

}

</script>
<?php
    include "init.php";
    include "functions100.php";
    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
    

    $sql = "SELECT orderId FROM users WHERE userId = $userId";
    $sqlQueryResult = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($sqlQueryResult);
    $orderId = $row["orderId"];

?>


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

<body>

<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header clearfix">
<h2 class="pull-left">Payment Page</h2>
<!--MEMBER MENUE BAR-->
<table>
<tr>

<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</tr>
</table>
<br><br>

</div>

<?php
// Welcome the user
$userName = "SELECT `name` FROM `users` WHERE `userId`=$userId";
$userName = mysqli_query($conn,$userName);
$name = mysqli_fetch_array($userName);
?>
	<h4> Welcome <?php echo $name[name];?> </h4>

<?php
// Tell of what products are in the shoping cart
$sqlItems = "SELECT `productId`, `amount` FROM `itemList` WHERE `orderId`=$orderId AND `userId`=$userId";
$items = mysqli_query($conn,$sqlItems); //Items in cart
$prodInfo = mysqli_query($conn,"SELECT `name`,`price`,`image` FROM products");

?>
<?php
if (mysqli_num_rows($prodInfo) > 0 && mysqli_num_rows($items) > 0 ) {
?>
<table class='table table-bordered table-striped'>
<tr> <td>Product</td> <td>Price</td> <td>Amount</td> <td></td> </tr>

<?php
$totalCost = "0";
// Running through and printing the users shopping cart
while($amount = mysqli_fetch_array($items)) {
	$row = mysqli_fetch_array($prodInfo);

	$totalCost = $totalCost + $row["price"]*$amount["amount"];

?>	<tr>
	<td><?php echo $row["name"]; ?></td>
	<td><?php echo $row["price"]; ?></td>
        <td><?php echo $amount["amount"]; ?></td>
	<td><img src="<?php echo $row['image']; ?>" style="width:50px;height:50px;"  >
	</tr>
<?php
}
echo $totalCost;
}
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
