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
<body>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
$productId = $_REQUEST['productId'];
$sqlHasProd = "SELECT `userId` FROM `itemList` WHERE `userId`=$userId AND `productId`=$productId";
        $sqlQueryHasProd = mysqli_query($conn,$sqlHasProd);
        $hasProd = mysqli_fetch_array($sqlQueryHasProd);
        if (($hasProd["userId"]==$userId)){
            echo "Would you like to give a review?";
            $textOnShowReviewButton = "Give a review";
            $Reviews = "giveReview.php";
            echo "<td><form method=\"POST\" action=\"$Reviews?productId=$productId\">";
            echo "<input type=\"submit\" name=\"";
            echo $textOnShowReviewButton;
            echo "\" value=\"".$textOnShowReviewButton."\">";
            echo "</form><td>";
        }
?>

</tr></table><br><br>

<?php
//Get productId
//Print the review text for productId
    $sql = "SELECT `reviewText`,`numStar` FROM `reviews` WHERE `productId`= $productId";
    $sqlQueryResult = mysqli_query($conn,$sql);
?>


<table class='table table-bordered table-striped'>
<tr> <td>Review</td> <td>Score</td> </tr>

<?php
// Running through and printing the users shopping cart
while($row = mysqli_fetch_array($sqlQueryResult)) {
?>  <tr>
    <td><?php echo $row["reviewText"]; ?></td> <td><?php 

    $rating = $row["numStar"];
    for ($i=0; $i < 5; $i++) { 
        //echo "<span class='fa fa-star checked'></span>";
        if ($i<$rating) {/**/
            echo '<span class="fa fa-star checked" style="color:gold;"></span>';
        }else{
            echo '<span class="fa fa-star checked" style="color:gray;"></span>';
        }
    }



    ?></td>
    </tr>
<?php
}
?>

</div></div></div></div></div>
</body>
</html>