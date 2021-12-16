
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

    case "distributer":
        //window.location.href = "/distributer_start.php";
        break;

    case "member":
        //window.location.href = "/member_start.php";
        break;

    default:
        //window.location.replace("/");

}
</script>

<?php
    include "functions.php";
    include "init.php";

    
    $conn = connect();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["name"];
    $userStatus = $_SESSION["status"];
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Manage products - bestshop</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style type="text/css"> .bs-example{margin: 20px;}</style>
        <script type="text/javascript">$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
    <style type="text/css">
.bs-example{
margin: 20px;
}


.dropdown1 {
  position: relative;
  display: inline-block;
}

.dropdown1-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown1:hover .dropdown1-content {
  display: block;
}

textarea {
  width: 100%;
  height: 170px;
  padding: 8px 10px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  background-color: #ECDBBA;
  font-size: 16px;
  resize: none;
}


select {
  width: 80%;
  padding: 5px 15px;
  border: none;
  border-radius: 4px;
  background-color: #ECDBBA;
}

div.new {
  position: absolute;
  left: 0px;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 65%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
} 

div.newLeft {
  position: absolute;
  top: 0px;
  left: 0px;
  width: 40%;
  padding: 10px;
} 
div.newRight {
  position: absolute;
  top: 20px;
  right: 10px;
  width: 60%;
  padding: 10px;
}

div.low {
  position: absolute;
  right: 0px;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 37%;
  height: 600px;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}

div.change {
  position: absolute;
  left: 0px;
  top: 580px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 100%;
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;
}

    </style>
<?php
    include_once "visualFunctions.php";
?>


</head>
<body class=bodyClass>

<?php
    headerAdmin("Products");
?>

    <div class="bs-example">
    <div class="container">
    <div class="row">
    <div class="col-md-12">


<?php

$nameErr = $priceErr = $infoErr = $amountErr = $imageErr = $contentErr = "";
$name = $price = $info = $amount = $image = $content ="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
  
  if (empty($_POST["price"])) {
    $priceErr = "Price is required";
  } else {
    $price = test_input($_POST["price"]);
  }

  if (empty($_POST["info"])) {
    $infoErr = "Info is required";
  } else {
    $info = test_input($_POST["info"]);
  }

  if (empty($_POST["amount"])) {
    $amountErr = "Amount is required";
  } else {
    $amount = test_input($_POST["amount"]);
  }

  if (empty($_POST["image"])) {
    $imageErr = "Image is required";
  } else {
    $image = test_input($_POST["image"]);
  }

  if (empty($_POST["content"])) {
    $contentErr = "Table of contents is required";
  } else {
    $content = test_input($_POST["content"]);
  }

//check if all boxen are filled correcyly
 if(($nameErr == "") && ($priceErr == "") && ($infoErr == "") && ($amountErr == "") && ($imageErr == "") && ($contentErr == "")) {
    addProduct($conn, $name, $price, $info, $amount, $image, $content);
 }

}

?>




<div class="new"><h3>New product</h3>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div cless="newLeft"> 
        <label for="name">Name: <span class="error">* <?php echo $nameErr;?></span></label><br>  
        <input type="text" id = "name" name="name" placeholder="Product name..">
        
        <br><br>
        <label for="price">Price: <span class="error">* <?php echo $priceErr;?></span></label><br>
        <input type = "number" id = "price" name="price" min = "0" placeholder="Price..">
        
        <br><br>
        <label for="amount">Amount: <span class="error">* <?php echo $amountErr;?></span></label><br>
        <input type = "number" id = "amount" name="amount" min = "0" placeholder="Number of products..">
        
        <br><br>
        <label for="image">Image: <span class="error">* <?php echo $imageErr;?></span></label><br>
        <input type="text" id = "image" name="image" placeholder="Image URL or image file name..">
        

    </div>
    <div class="newRight">
        <label for="info"> Info: <span class="error">* <?php echo $infoErr;?></span></label><br>
        <textarea name="info" id = "info" placeholder="Describe your product here..."></textarea>
         
        <br><br>
        <label for="content"> Table of contents: <span class="error">* <?php echo $contentErr;?></span></label><br>
        <textarea name="content" id = "content" placeholder="Table of contents here..."></textarea>

        <br><br>
        <input type="submit" name="submit" value="Add product">  
    </div> 
</form>
</div>

<div class="low"><h3>Low in stock </h3> 

    <table class='table table-bordered table-striped' style="color: #ECDBBA;">

    <tr>
    <td>Id</td>
    <td>Name</td>
    <td>Amount</td>
    </tr>

<?php $result = mysqli_query($conn,"SELECT productId, name, amount FROM products WHERE amount < 10"); ?>

<?php

if (mysqli_num_rows($result) > 0) {
?>
<?php
while($row = mysqli_fetch_array($result)) {
    $id = $row["productId"];
    $name = $row["name"];
    $amount = $row["amount"];
    ?>
    <tr>
    <td><label><?=$id?></label></td>
    <td><label><?=$name?></label></td>
    <td><label><?=$amount?></label></td>
    </tr>


<?php
}
?>

<?php
}
else{
echo "No result found";
}
?>
</table>
</div>

<div class="change"><h3>Edit product information or remove a product</h3>

<table class='table table-bordered table-striped' style="color: #ECDBBA;">

    <tr>
    <td>Id/Name</td>
    <td>Image</td>
    <td>Price/Amount</td>
    <td>Info</td>
    <td>Content</td>
    <td></td>
    </tr>

<?php $result = mysqli_query($conn,"SELECT * FROM products"); ?>

<?php
    disconnect($conn);
?>

<?php

if (mysqli_num_rows($result) > 0) {
?>
<?php
while($row = mysqli_fetch_array($result)) {
    $id = $row["productId"];
    $name = $row["name"];
    $price = $row["price"];
    $info = $row["info"];
    $amount = $row["amount"];
    $image = $row["image"];
    $content = $row["content"];
    ?>
    <tr>

    <form method="post" action="manage_products.php?action=change&id=<?=$id?>">
    <td>
        <br><label>Product id: <?=$id?></label><br><br>
        <label for="name">Name: </label><br>
    <input type="text" id = "name" name="name" style="width: 220px;" value="<?=$name?>"></td>


    <td>
            <label for="image"><div class="dropdown1">
                                <img src="<?=$image?>" width="60" height="60">
                                <div class="dropdown1-content">
                                <img src="<?=$image?>" width="300" height="300">
                                </div></div>
            </label>
            <textarea name="image" id = "image" style="height: 100px;"><?=$image?></textarea>
          
    </td>


    <td>
        <label for="price">Price: </label><br>
        <input type = "number" id = "price" name="price" min="0" style="width: 80px;" value=<?=$price?>>

        <br><br><label for="amount">Amount: </label><br>
        <input type = "number" id = "amount" name="amount" min = "0" style="width: 80px;" value="<?=$amount?>">

    </td>

    <td><textarea name="info" id = "info" rows="3" cols="30"><?=$info?></textarea></td>

    <td><textarea name="content" id = "content"><?=$content?></textarea></td>

    <td>
    <br>
    <input type="submit" name="submit" value="Submit changes" style="padding: 5px;">
    <br><br>
    </form>
    <form method="post" action="manage_products.php?action=remove&id=<?=$id?>">
    <input type="submit" name="submit" value="Remove product" style="padding: 5px;" onclick="return confirm('Are you sure you want to remove this product?')">
    </td> </form>
    </tr>


<?php
}
?>

<?php
}
else{
echo "No result found";
}
?>

</table>
</div>

    </div>
    </div>
    </div>
    </div>
    </body>
</html>
