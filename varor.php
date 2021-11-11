<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Products - bestshop</title>
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
<h2 class="pull-left">Products</h2>
</div>
<?php
$host='localhost';
    $username='19970225';
    $password='19970225';
    $dbname = "db19970225";
    $conn=mysqli_connect($host,$username,$password,$dbname);



$result = mysqli_query($conn,"SELECT * FROM products");
?>
<?php
if (mysqli_num_rows($result) > 0) {
?>
<table class='table table-bordered table-striped'>
<tr>
<!---<td>ID</td>--->
<td>Name</td>
<td>Items in stock</td>
<td>Info</td>
<td>
<td>
</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
?>
<tr>
<!---<td><?php// echo $row["id"]; ?></td>--->
<td><?php echo $row["name"]; ?></td>
<td><?php echo $row["amount"]; ?></td>
<td><?php echo $row["info"]; ?></td>
<td>
<img src="<?php echo $row['image']; ?>" style="width:50px;height:50px;"  >
<td><a href="add_to_cart.php"><button> Add to cart </button></a> </td>

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
</body>
</html>