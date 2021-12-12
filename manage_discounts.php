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
    	window.location.replace("/");

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
    $isActive = test_input($_REQUEST['isActive']);
    switch ($action){
        case "remove":
            removeDiscount($conn, $id);
            break;
        case "change":
            changeDiscountActiveStatus($conn, $id, $isActive);
            break;
    }

}
    
disconnect($conn);



?>

<script>
window.location.replace("/admin_discounts.php");
</script>
