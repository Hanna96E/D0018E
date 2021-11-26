<?php
//
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
        window.location.replace("http://130.240.200.56");

}

</script>
<?php
    //Setup
    include "init.php";
    include "functions100.php";

    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <title>Give a review - bestshop</title>
</head>
<?php
    // Formating (can be removed, but looks bad)
        include "headerTabular.php";
?>

<h2> Give a reviews </h2>

<!--MEMBER MENUE BAR-->
<table>
<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</table>

<body>
<p></p>
<!--
<p class="error">* required field</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<label for="reviewText">Thoughts? </label><br><br> 

<textarea id="reviewText" name="reviewText" rows="10" cols="50"
 placeholder="What did you think?"></textarea>

<br><span class="error"> <?php echo $reviewErr;?></span>

    <br><br>
    <input type="submit" name="submit" value="Add product"> 
    </td></form></tr>
-->


<?php
// Set error and Request Method == POST
// So that when POST is sent we can handle it

//$userId = "2";
$productId = "1";
$reviewErr = "";

// Runs after reviewText has been given
if ($_SERVER["REQUEST_METHOD"] == "POST") {
echo "Try me!";

      if (empty($_POST["reviewText"])) {
    $reviewErr = "Review is required";
    echo $reviewErr;
  } else {
    $reviewText = $_POST["reviewText"];
    echo $reviewText;
    echo "testRe";
  }

   if($reviewErr == ""){
    insertReview($conn, $productId, $userId, $reviewText);
  }
}
//Set the outlook of page
?>

<p class="error">* required field</p>
<?php   // So that we send the values to the same page
?>  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<label for="reviewText">Thoughts? </label><br><br>

<textarea id="reviewText" name="reviewText" rows="10" cols="50"
 placeholder="What did you think?"></textarea>

<br><span class="error"> <?php echo $reviewErr;?></span>

    <br><br>
    <input type="submit" name="submit" value="Give Review">


<?php
// Sends a sql query to the database, so that the reviewText will be inserted
function insertReview($conn, $productId, $userId, $reviewText){
$sql = "INSERT INTO `reviews` (`productId`, `userId`, `reviewText`, `numStar`) VALUES ('$productId', '$userId', '$reviewText', '5') ";

if (mysqli_query($conn, $sql)) {
        //echo "<script>alert('Your product was successfully added.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<?php
// We are only looking for input on paymentpage
disconnect($conn);
?>

</div></div></div></div></div>
</body>
</html>