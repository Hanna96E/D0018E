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
    include "functions101.php";
    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reviews - bestshop</title>
</head>
<?php
    include "headerTabular.php";
?>

<h2> Reviews </h2>

<!--MEMBER MENUE BAR-->
<table><tr>
<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
<?php //</tr></table><br><br>
?>

<?php
// Check if user has product
// If so give them acces to give a review
//$productId = "1";
//$userId = "1";
$sqlHasProd = "SELECT `userId` FROM `itemList` WHERE `userId`=$userId AND `productId`=$productId";
        $sqlQueryHasProd = mysqli_query($conn,$sqlHasProd);
        $hasProd = mysqli_fetch_array($sqlQueryHasProd);
        if (($hasProd["userId"]==$userId)){
                echo "Would you like to give a review?";
?>
                <td><a href="/giveReview.php"><button> Give a review </button></a></td>
<?php
}   
?>

</tr>

<?php
//Get productId
    // TEST $userId = "1";
    $productId = "1";
        //$productId = $_POST["productId"];
    $productId = $_REQUEST['productId'];
//Print the review text for productId
    $sql = "SELECT `reviewText`,`numStar` FROM `reviews` WHERE `productId`= $productId";
    $sqlQueryResult = mysqli_query($conn,$sql);
//  $row = mysqli_fetch_assoc($sqlQueryResult);
?>


<table class='table table-bordered table-striped'>
<tr> <td>Review</td> <td>Score</td> </tr>

<?php
// Running through and printing the users shopping cart
while($row = mysqli_fetch_array($sqlQueryResult)) {

?>  <tr>
    <td><?php echo $row["reviewText"]; ?></td> <td><?php echo $row["numStar"]; ?></td>
    </tr>
<?php
}


<?php
// We are only looking for input on paymentpage
disconnect($conn);
?>

</div></div></div></div></div>
</body>
</html>
