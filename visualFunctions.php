
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>

.header{
	background-color: #2D4263;
	height: 100px;
	color: #ECDBBA;
}
.centerYInHeader{
	margin-top: 25px;
	width: 100%;
	position: absolute;
}
.homeInHeader{
	font-size: xx-large;
	font-weight: 700;
}
.userNameInHeader{
	padding-right: 50px;
	font-size: xx-large;
	font-weight: 700;
	float: right;
}
.cartInHeader{
	float: right;
	display: inline-block;
	padding-right: 50px;
}
.menueBarInHeader{
	float: right;
	min-width: 300px;
	display: inline-block;
}





input[type=submit] {
  width: 100%;
  background-color: #0099FF;
  color: white;
  padding: 5px 0px;
  margin: 4px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #0066FF;
}

input[type=text], input[type=number], input[type=email], input[type=password] {
  width: 35%;
  padding: 5px 8px;
  margin: 4px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  background-color: #ECDBBA;
}


.error {color: #C84B31;}


/*https://www.w3schools.com/howto/howto_css_dropdown.asp*/

/* The container <div> - needed to position the dropdown content */ /*https://www.w3schools.com/howto/howto_css_dropdown.asp*/
.dropdown {
  display: inline-block;
  
}

/* Dropdown Content (Hidden by Default) */ /*https://www.w3schools.com/howto/howto_css_dropdown.asp*/
.dropdown-content {
  display: none;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 10;
  background-color: #ECDBBA;
  position: relative;

}

/* Links inside the dropdown */ /*https://www.w3schools.com/howto/howto_css_dropdown.asp*/
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;


}

/* Change color of dropdown links on hover */ /*https://www.w3schools.com/howto/howto_css_dropdown.asp*/
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */ /*https://www.w3schools.com/howto/howto_css_dropdown.asp*/
.dropdown:hover .dropdown-content {display: block;}




/*-----------------------------------------------------------------------------------------------------------------------------*/

.bodyClass{
	background-color: #191919;
	margin: 0;
}





</style>

<?php



function headerMember($pageName){

	$homeRef =  "member_start.php";
	$homeText = "home";

	$cartRef = "memberCart.php";
	$cartImage = "https://d29fhpw069ctt2.cloudfront.net/icon/image/38239/preview.svg"; // https://www.stockio.com/free-icon/shopping-cart-lynny-icon

	$menuebarImage = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNzUycHQiIGhlaWdodD0iNzUycHQiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDc1MiA3NTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiA8cGF0aCBkPSJtMTk4LjQxIDE2OC44MWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4aDM1NS4xOGMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ0LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwN2MxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwNmMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4eiIvPgo8L3N2Zz4K"; // https://thenounproject.com/icon/menu-bar-2321499/


	echo "<header class=header>";
		echo "<div class=centerYInHeader>";



			echo "<span style=\"vertical-align: top; padding-left: 50px;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\"> 
							<img src=\"/img/house.png\" style=\"width:50px;height:50px;\"></a>";
			echo "</span>";
			echo "<span style=\"vertical-align: top;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\">$homeText</a>";
			echo "</span>";



			echo "<span style=\"text-align: center; color: #ECDBBA; font-size: xx-large; font-weight: 700; display: inline-block; width: 20%; position: absolute; left: 40%;\" >";
				echo $pageName;
			echo "</span>";
			
			echo "<span class=menueBarInHeader>";
				echo "<span class=dropdown>";
						echo "<img src= \"". $menuebarImage. "\" style= \"width:50px;height:50px;\">";
					echo "<span class=dropdown-content>";

						echo "<a href=\"/member_start.php\"> Home </a>";
						echo "<a href=\"/productsForMember.php\"> View products </a>";
						echo "<a href=\"/memberCart.php\"> View cart </a>";
						echo "<a href=\"/paymentPage.php\"> Pay </a>";
						echo "<a href=\"/memberOrders.php\"> Your past orders </a>";
						echo "<a href=\"/member_account.php\"> My account </a>";
						echo "<a href=\"/member_support.php\"> Support </a>";
						echo "<a href=\"/logout.php\"> Log out </a>";
						
					echo "</span>";
								
				echo "</span>";					
			echo "</span>";
			
			echo "<span class=cartInHeader>";
				echo "<a href=\"/$cartRef\">";
				echo "<img src= \"". $cartImage. "\" style= \"width:50px;height:50px;\">";
				echo "</a>";
			echo "</span>";

			
			echo "<span class=userNameInHeader>";
				$nameTmp = $_SESSION["name"];
				echo "<a style=\"color: #ECDBBA;\" href=\"/member_account.php\"> $nameTmp </a>";
			echo "</span>";

		echo "</div>";


	echo "</header>";
}
function headerNotLoggedIn($pageName){
	$homeRef =  "";
	$homeText = "home";

	$menuebarImage = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNzUycHQiIGhlaWdodD0iNzUycHQiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDc1MiA3NTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiA8cGF0aCBkPSJtMTk4LjQxIDE2OC44MWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4aDM1NS4xOGMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ0LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwN2MxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwNmMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4eiIvPgo8L3N2Zz4K"; // https://thenounproject.com/icon/menu-bar-2321499/

	echo "<header class=header>";
		echo "<div class=centerYInHeader>";



			echo "<span style=\"vertical-align: top; padding-left: 50px;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\"> 
							<img src=\"/img/house.png\" style=\"width:50px;height:50px;\"></a>";
			echo "</span>";
			echo "<span style=\"vertical-align: top;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\">$homeText</a>";
			echo "</span>";

			echo "<span style=\"text-align: center; color: #ECDBBA; font-size: xx-large; font-weight: 700; display: inline-block; width: 20%; position: absolute; left: 40%;\" >";
				echo $pageName;
			echo "</span>";

			echo "<span class=menueBarInHeader>";

				echo "<span class=dropdown>";
						echo "<img src= \"". $menuebarImage. "\" style= \"width:50px;height:50px;\">";
					echo "<span class=dropdown-content>";

						echo "<a href=\"/login.php\"> Login </a>";
						echo "<a href=\"/become_member.php\"> Become member </a>";
						
					echo "</span>";
								
				echo "</span>";					
			echo "</span>";

		echo "</div>";
	echo "</header>";
}
function headerDistributer($pageName){

	$homeRef =  "distributer_start.php";
	$homeText = "home";


	$menuebarImage = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNzUycHQiIGhlaWdodD0iNzUycHQiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDc1MiA3NTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiA8cGF0aCBkPSJtMTk4LjQxIDE2OC44MWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4aDM1NS4xOGMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ0LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwN2MxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwNmMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4eiIvPgo8L3N2Zz4K";  // https://thenounproject.com/icon/menu-bar-2321499/

	echo "<header class=header>";
		echo "<div class=centerYInHeader>";



			echo "<span style=\"vertical-align: top; padding-left: 50px;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\"> 
							<img src=\"/img/house.png\" style=\"width:50px;height:50px;\"></a>";
			echo "</span>";
			echo "<span style=\"vertical-align: top;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\">$homeText</a>";
			echo "</span>";

			echo "<span style=\"text-align: center; color: #ECDBBA; font-size: xx-large; font-weight: 700; display: inline-block; width: 20%; position: absolute; left: 40%;\" >";
				echo $pageName;
			echo "</span>";

			echo "<span class=menueBarInHeader>";

				echo "<span class=dropdown>";
						echo "<img src= \"". $menuebarImage. "\" style= \"width:50px;height:50px;\">";
					echo "<span class=dropdown-content>";

						echo "<a href=\"/$homeRef\"> $homeText </a>";
						echo "<a href=\"/logout.php\"> Log out </a>";

					echo "</span>";
								
				echo "</span>";					
			echo "</span>";

			echo "<span class=\"userNameInHeader\">";
				$nameTmp = $_SESSION["name"];
				echo "$nameTmp";
			echo "</span>";

		echo "</div>";
	echo "</header>";
}
function headerAdmin($pageName){

	$homeRef =  "admin_start.php";
	$homeText = "home";


	$menuebarImage = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNzUycHQiIGhlaWdodD0iNzUycHQiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDc1MiA3NTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiA8cGF0aCBkPSJtMTk4LjQxIDE2OC44MWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4aDM1NS4xOGMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ0LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwN2MxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4em0wIDE0Ny45OWMtMTYuMzQ4IDAtMjkuNTk4IDEzLjI1LTI5LjU5OCAyOS41OTh2NTkuMTk5YzAgMTYuMzQ4IDEzLjI1IDI5LjU5OCAyOS41OTggMjkuNTk4bDM1NS4xOCAwLjAwMzkwNmMxNi4zNDggMCAyOS41OTgtMTMuMjUgMjkuNTk4LTI5LjU5OHYtNTkuMTk5YzAtMTYuMzQ4LTEzLjI1LTI5LjU5OC0yOS41OTgtMjkuNTk4eiIvPgo8L3N2Zz4K"; // https://thenounproject.com/icon/menu-bar-2321499/

	echo "<header class=header>";
		echo "<div class=centerYInHeader>";



			echo "<span style=\"vertical-align: top; padding-left: 50px;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\"> 
							<img src=\"/img/house.png\" style=\"width:50px;height:50px;\"></a>";
			echo "</span>";
			echo "<span style=\"vertical-align: top;\" class=homeInHeader>";
				echo "<a style=\"color: #ECDBBA;\" href=\"/$homeRef\">$homeText</a>";
			echo "</span>";

			echo "<span style=\"text-align: center; color: #ECDBBA; font-size: xx-large; font-weight: 700; display: inline-block; width: 20%; position: absolute; left: 40%;\" >";
				echo $pageName;
			echo "</span>";

			echo "<span class=menueBarInHeader>";

				echo "<span class=dropdown>";
						echo "<img src= \"". $menuebarImage. "\" style= \"width:50px;height:50px;\">";
					echo "<span class=dropdown-content>";

						echo "<a href=\"/$homeRef\"> $homeText </a>";
						echo "<a href=\"/admin_products.php\"> Manage products </a>";
						echo "<a href=\"/admin_orders.php\"> Manage orders </a>";
						echo "<a href=\"/admin_accounts.php\"> Manage accounts </a>";
						echo "<a href=\"/admin_messages.php\"> Manage messages </a>";
						echo "<a href=\"/admin_discounts.php\"> Manage discounts </a>";
						echo "<a href=\"/logout.php\"> Log out </a>";

					echo "</span>";
								
				echo "</span>";					
			echo "</span>";

			echo "<span class=\"userNameInHeader\">";
				$nameTmp = $_SESSION["name"];
				echo "$nameTmp";
			echo "</span>";

		echo "</div>";
	echo "</header>";
}







?>