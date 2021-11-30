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
        window.location.replace("/");

}

</script>
<?php
    //Setup
    include "init.php";

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
    // Dont forget 5 div at the end
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

$productId = $_REQUEST['productId'];
echo "star: ";
//echo $productId;

$numStar = $_POST["star"];

$reviewErr = "";

// Runs after reviewText has been given
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["reviewText"]) || empty($numStar) ) {
        $reviewErr = "Review is required";
    } else {
        $reviewText = $_POST["reviewText"];
	}

   if($reviewErr == ""){
   	insertReview($conn, $productId, $userId, $reviewText, $numStar);
    echo "<form method=\"POST\" action=\"productReview.php?productId=$productId\">";
    echo "</form><td>";
  }
}
//Set the outlook of page
?>

<p class="error">* required field</p>
<?php	// So that we send the values to the same page
/*
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
*/
echo "<form method=\"POST\" action=\"giveReview.php?productId=$productId\">";
?> 
<label for="reviewText">Thoughts? </label><br><br>

<textarea id="reviewText" name="reviewText" rows="10" cols="50"
 placeholder="What did you think?"></textarea>

<br><span class="error"> <?php echo $reviewErr;?></span>



<p>Please select star ranking of the product:</p>
  <input type="radio" id="star1" name="star" value="1">
  <label for="star1">
    <span class="fa fa-star checked"></span>
  </label><br>
  
  <input type="radio" id="star2" name="star" value="2">
  <label for="star2">
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
  </label><br>  
  
  <input type="radio" id="star3" name="star" value="3">
  <label for="star3">
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
  </label><br>
  
  
  <input type="radio" id="star4" name="star" value="4">
  <label for="star4">
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
  </label><br>  
  
  <input type="radio" id="star5" name="star" value="5">
  <label for="star5">
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
  </label><br>



    <br><br>
    <input type="submit" name="submit" value="Give Review">
</form>

<?php
// Sends a sql query to the database, so that the reviewText will be inserted
function insertReview($conn, $productId, $userId, $reviewText, $numStar){
$sql = "INSERT INTO `reviews` (`productId`, `userId`, `reviewText`, `numStar`) VALUES ('$productId', '$userId', '$reviewText', '$numStar') ";

if (mysqli_query($conn, $sql)) {
  		//echo "<script>alert('Your product was successfully added.');</script>";
	} else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
?>

</div></div></div></div></div>
</body>
</html>