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
<tr>
<td><a href="/member_start.php"><button> Home </button></a></td>
<td><a href="/productsForMember.php"><button> View products </button></a></td>
<td><a href="/memberCart.php"><button> View cart </button></a></td>
<td><a href="/logout.php"><button> Log out </button></a></td>
</table>

<body>
<p></p>

<tr><p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<textarea id="review" name="review" rows="10" cols="50"
 placeholder="What did you think?"></textarea>

</td>
    <td><br><br>
    <input type="submit" name="submit" value="Add product"> 
    </td></form></tr>

</body>
