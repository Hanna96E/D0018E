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

    default:
    	window.location.replace("http://bestshop.com/");

}

</script>

<?php 
	include "functions.php";
	include "init.php";
	$conn = connect();
?>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = test_input($_REQUEST['action']);
    $id = test_input($_REQUEST['id']);
    $name = test_input($_POST['name']);
    $price = test_input($_POST['price']);
    $info = test_input($_POST['info']);
    $amount = test_input($_POST['amount']);
    $image = test_input($_POST['image']);
    switch ($action){
        case "remove":
            removeProduct($conn, $id);
            break;
        case "change":
            changeProduct($conn, $id, $name, $price, $info, $amount, $image);
            break;
    }
}


?>

<script>
window.location.replace("/admin_products.php");
</script>