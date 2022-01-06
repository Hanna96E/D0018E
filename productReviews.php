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
    include_once "visualFunctions.php";
    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];

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

    </style>

</head>
<body class=bodyClass>

    <?php
    headerMember("Reviews");
    ?>

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<?php
// Check if user has product
// If so give them acces to give a review
$productId = $_REQUEST['productId'];
$sqlHasProd = "SELECT `userId` FROM `itemList` WHERE `userId`=$userId AND `productId`=$productId";
        $sqlQueryHasProd = mysqli_query($conn,$sqlHasProd);
        $hasProd = mysqli_fetch_array($sqlQueryHasProd);
        if (($hasProd["userId"]==$userId)){?>

        <div class="prod">
        <table><tr>
        <td>
            <?php            
            echo "Would you like to give a review?";
            $textOnShowReviewButton = "Give a review";
            $Reviews = "giveReview.php";
            echo "<td><form method=\"POST\" action=\"$Reviews?productId=$productId\">";
            echo "<input type=\"submit\" name=\"";
            echo $textOnShowReviewButton;
            echo "\" value=\"".$textOnShowReviewButton."\">";
            echo "</form><td>";?>
        </tr></table><br><br>
        </div>



        <div class="prod">
    
        <form method="post" action="manage_products.php?action=change&id=<?=$id?>">

        <?php 
        $info = "information";
        ?>         

        <td><textarea name="info" id = "info" rows="3" cols="30"><?=$info?></textarea></td>

        <td>
        <input type="submit" name="submit" value="Submit changes" style="padding: 5px;">
        </td>
        
        <br><br>
        </form>
    
        </div>





<?php  
        }
?>



<div class="prod">

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
?>

</div></div></div></div></div></div>
</body>
</html>