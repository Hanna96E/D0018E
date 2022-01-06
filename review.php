<?php
	/*
	* Start session
	* Get: 
	* 		ProductId
	*		userId
	
	* Get:
	*		Review_UserID
	*		Review_ProductID
	*		Review_Text
	*		Review_NumStar
	
	* Check if they can give review
	* Check if reviw have been given from user
	* -> Print review form if have 
    * -> and add what they have previously set 

	* Print all the reviews
	* If the review is from the user
	* Then let the user edit it
	*
	*/
?>


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
    include "functions.php";
    include_once "visualFunctions.php";
    
    $conn = connect();
    $userId = $_SESSION["userId"];
//    $userName = $_SESSION["name"];
//    $userStatus = $_SESSION["status"];
    $productId = $_REQUEST['productId'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reviews - bestshop</title>

<style>
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
          width: 100%;
          height: 170px;
          padding: 12px 20px;
          box-sizing: border-box;
          border: 2px solid #C84B31;
          border-radius: 4px;
          background-color: #ECDBBA;
          font-size: 16px;
          resize: none;
        }


        div.prod {
          position: relative;
          left: 10%;
          top: 20%;
          background-color: #2D4263;
          width: 70%;
          
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





.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  border-radius: 5px;
  background: #ECDBBA;
  outline: none;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  border-radius: 0%;
  background: #C84B31;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 100%;
  background: #C84B31;
  cursor: pointer;
}

    </style>

</head>
<body class=bodyClass>

    <?php
    headerMember("Reviews");
    ?>

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<?php
    // ----------- ABOVE IS STYLE ------------ //
?>
<?php
// Check for when submit

$reviewErr = "";
$review = $rating = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (empty($_POST["review"])) {
    $reviewErr = "review is required";
  } else {
    $review = test_input($_POST["review"]);
  }

$rating = test_input($_POST["rating"]);
//check if all boxen are filled correcyly
 if(($reviewErr == "")) {
    // SQL addreview ($conn, $review, $rating);

    // check if first review
    $sqlFirstReviCheck = "SELECT `userId` FROM `reviews` WHERE `userId`=$userId AND `productId`=$productId";
    $sqlQueryDoneRevi = mysqli_query($conn,$sqlFirstReviCheck);

    if (mysqli_num_rows($sqlQueryDoneRevi) > 0) {
        // Update their old review
        $sqlReviewUpdate = "UPDATE `reviews` SET `reviewText`='$review',`numStar`= '$rating' WHERE `userId`='$userId' AND `productId`='$productId'";
        mysqli_query($conn,$sqlReviewUpdate);
    } else {
       $sqlReviewInsert = "INSERT INTO `reviews`( `productId`, `userId`, `reviewText`, `numStar`) VALUES ('$productId','$userId','$review','$rating')";
       mysqli_query($conn,$sqlReviewInsert);
    }

 }
}

?>
<?php 
	// ----------- BELOW IS CODE  ------------ //
?>
<?php 
// Check Has Product
$sqlHasProd = "SELECT `userId` FROM `itemList` WHERE `userId`=$userId AND `productId`=$productId";
        $sqlQueryHasProd = mysqli_query($conn,$sqlHasProd);
        $hasProd = mysqli_fetch_array($sqlQueryHasProd);

// Check Has given Review
$sqlHasReview = "SELECT `userId` FROM `reviews` WHERE `userId`=$userId AND `productId`=$productId";
        $sqlQueryHasReview = mysqli_query($conn,$sqlHasReview);
        $hasReview = mysqli_fetch_array($sqlQueryHasReview);
/*
* Check if they can give review
* Check if reviw have been given from user
* -> Print review form if have
*/
if (($hasProd["userId"]==$userId)){

// Get Review info
$sqlReview = "SELECT `userId`,`reviewText`,`numStar` FROM `reviews` WHERE `userId`=$userId AND `productId`=$productId";
$result = mysqli_query($conn, $sqlReview); ?>


<div class="change">
<div class="prod">
<table class='table table-bordered table-striped' style="color: #ECDBBA;">

    <tr>
    <td>Review</td>
    <td>Rating</td>

    

    <?php
    $row = mysqli_fetch_array($result);

    $id = $row["userId"];
    $review = $row["reviewText"];
    $rating = $row["numStar"];

    ?><td><?php echo "$rating";?></td>
    </tr>

    <tr>

    <form method="post" action="/review.php?productId=<?=$productId?>">

    <td><textarea name="review" id = "review" rows="30" cols="50"><?=$review?></textarea></td>

<td>
  <div class="slidecontainer">
  <input type="range" name="rating" id="rating" min="0" max="5" value=<?="$rating"?>>

  <p>Rating: <span id="demo"></span></p>
  </div>

    <script>
    var slider = document.getElementById("rating");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
      <?php $numStar = "<script> this.value; </script>";?>
    }
    </script>
</td> 


    <td><br>
    <input type="submit" name="submit" value="Submit changes" style="padding: 10px; width: 200px; ">
    <br><br>
    </form>
    </td></tr>




    <?php


?>



</table>
</div>

<?php
}?> 

<?php

    // ABOVE IS CHECK FOR IF THE GIVE FIRST REVIEW
    // BELOW IS REVIEWS AND ABILITY TO EDIT OWN  

// Get:
//       Review_UserID    
//       Review_ProductID 
//       Review_Text
//       Review_NumStar
//
// Need prodID and userID for check
//$sqlReview = "SELECT `productId`,`userId`,`reviewText`,`numStar` FROM `reviews` WHERE 1";

?>



<?php
//Get productId
//Print the review text for productId
    $sql = "SELECT `reviewText`,`numStar` FROM `reviews` WHERE `productId`= $productId";
    $sqlQueryResult = mysqli_query($conn,$sql);
?>
<div class="prod">
<table class='table table-bordered table-striped'>

<?php
if (mysqli_num_rows($sqlQueryResult) > 0) {
    



?>


<tr> <td>Review</td> <td>Score</td> </tr>

<?php
// Running through and printing the users shopping cart
while($row = mysqli_fetch_array($sqlQueryResult)) {?>  
    <tr>
    <td><?php echo $row["reviewText"]; ?></td> <td><?php 

    $rating = $row["numStar"];
    for ($i=0; $i < 5; $i++) { 
        if ($i<$rating) {
            echo '<span class="fa fa-star checked" style="color:gold;"></span>';
        }else{
            echo '<span class="fa fa-star checked" style="color:gray;"></span>';
        }
    }



    ?></td>
    </tr>
<?php
    }
} else {
    echo "<h1>No Reviews found</h1>";

}
?>
</div>
</div>
    </div>
    </div>
    </div>

    </table></div>

<?php
    disconnect($conn);
?>
    </body>
</html>