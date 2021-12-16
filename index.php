<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Welcome! - bestshop</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example{
margin: 20px;
}

div.pic{

    position: absolute;
  left: 25%;
  top: 10px;
  background-color: #2D4263;
  color: #ECDBBA;
  width: 50%;
  
  border: 25px solid #C84B31;
  padding: 10px;
  overflow: auto;
  border-radius: 15px;

}

div.buttons{
    column-count: 3;
    color: #ECDBBA;

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
<script type="text/javascript">
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php
    include_once "visualFunctions.php";
?>


</head>
<body class=bodyClass>

<?php
    headerNotLoggedIn("Start Page");
?>


<div class="bs-example">
<div class="container">
<div class="row">
<div class="col-md-12">

<div class="pic">
<img src="/img/houseHome.png" style="width:100%;"  >

<div class="buttons">

<a href="products.php" class="button">View products </a>
<a href="login.php" class="button">Log in to account </a>
<a href="become_member.php" class="button">Become member </a>

</div>


</div>

</div>
</div>
</div>
</div>


<?php
    footer();
?>
</body>
</html>
