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
    include_once "visualFunctions.php";

    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <title>Give a review - bestshop</title>
        <style>
        .error {color: #000000;}
        body{
            color: #ECDBBA;    
        }
        input[type=submit] {
          width: 30%;
          background-color: #0099FF;
          color: white;
          padding: 14px 20px;
          margin: 4px 0;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }

        input[type=submit]:hover {
          background-color: #0066FF;
        }

        input[type=text], input[type=password], input[type=email] {
          width: 30%;
          padding: 12px 8px;
          margin: 4px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }

        textarea {
          width: 30%;
          height: 170px;
          padding: 12px 20px;
          box-sizing: border-box;
          border: 2px solid #ccc;
          border-radius: 4px;
          background-color: #FFFFFF;
          font-size: 16px;
          resize: none;
        }


        div.prod {
          position: absolute;
          left: 25%;
          top: 20%;
          background-color: #2D4263;
          width: 50%;
          
          border: 10px solid #C84B31;
          padding: 10px;
          margin: 10px;
          overflow: auto;
          border-radius: 15px;
        }


        table {
          border-collapse: collapse;
          border-spacing: 0;
          width: 100%;
          border: 1px solid #C84B31;
          color: #ECDBBA;
        }

        th, td {
          text-align: left;
          padding: 16px;
        }

        tr:nth-child(even) {
          background-color: #191919;
        }


    .button {
      background-color: #C84B31; 
      position: relative;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }



    </style>

</head>
<body class=bodyClass>

    <?php
    headerMember("Reviews");
    ?>
        </style>
</head>
<?php
	// Formating (can be removed, but looks bad)
        include "headerTabular.php";
    // Dont forget 5 div at the end
?>

<body>
    <br><br>
    <a href="/productsForMember.php" class="button">Browse</a>
    <br><br>

    <div class="prod">
    <table>
        <td>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<p></p>

<?php
// Set error and Request Method == POST
// So that when POST is sent we can handle it

$productId = $_REQUEST['productId'];

$numStar = $_POST["star"];
$reviewErr = "";
$reviewText = $_POST["reviewText"];


// Runs after reviewText has been given
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($reviewText) || empty($numStar) ) {
        $reviewErr = "Remember to write and set the star rank";
    } else {
        
	}

   if($reviewErr == ""){
   	insertReview($conn, $productId, $userId, $reviewText, $numStar);

    // Move to next page
    echo "<script>window.location.href = '/productsForMember.php';</script>";
  }
}
//Set the outlook of page
?>
<?php
echo "<form method=\"POST\" action=\"giveReview.php?productId=$productId\">";
?> 
<label for="reviewText">Thoughts? </label><br><br>

<textarea id="reviewText" name="reviewText" rows="10" cols="50"
 placeholder="What did you think?" style="background-color:#ECDBBA;"></textarea>
<br>
<br><span> <?php echo $reviewErr;?></span>




<!--<p>Please select star ranking of the product:</p>-->
    <br><br>
  <input type="radio" id="star1" name="star" value="1">
  <label for="star1">
    <span class="fa fa-star checked" style="color:gold;"></span>
  </label><br>
  
  <input type="radio" id="star2" name="star" value="2">
  <label for="star2">
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
  </label><br>  
  
  <input type="radio" id="star3" name="star" value="3">
  <label for="star3">
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
  </label><br>
  
  
  <input type="radio" id="star4" name="star" value="4">
  <label for="star4">
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
  </label><br>  
  
  <input type="radio" id="star5" name="star" value="5">
  <label for="star5">
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
    <span class="fa fa-star checked" style="color:gold;"></span>
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

</table>
</div>

</body>
</html>