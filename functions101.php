<?php

include_once "visualFunctions.php";

// security functions start-------------------------------------------------------------------

function hannnas_test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// security functions stop-------------------------------------------------------------------

// help functions start-------------------------------------------------------------------------

function showTableHeader($columnNameToShowArray){
    foreach ($columnNameToShowArray as $columnName) {
        echo "<th>";
        echo $columnName;
        echo "</th>";
    }
}

function showSimple($conn,$columnName,$row){
    $object = $row[$columnName];
    if($columnName == "image"){
        echo "<img src= \"". $object. "\" style= \"width:50px;height:50px;\">";
    }
    else{
        echo $object;
    }
}





function showProductBetter($conn,$row,$booleanIsLoggedIn,$booleanShowCart,$userId,$orderId,$redirectToString,$amountInCart){

    $amount = $row["amount"];
    if($amount==0){
        $backgroundColor="gray";
    }
    else{
        $backgroundColor="#2D4263";
    }



    echo "<span style=\" width:100%; background-color: $backgroundColor; display: inline-block; text-align: center;\">";
    
        echo "<span style=\"font-weight: 900; font-size: 20px; background-color: #ECDBBA; width: 80%; display: inline-block;\">";
            $name = $row["name"];
            echo "$name";
            echo "<br>";
            $price = $row["price"];
            echo "price: $price";
        echo "</span>";
        echo "<br>";

        echo "<span style=\"vertical-align: top; top: 20px; position: relative;\">";
            $image = $row["image"];
            echo "<img src= \"". $image. "\" style= \"width:150px;height:150px;\">";
        echo "</span>";



        if($booleanIsLoggedIn==true){
            echo "<span style=\"display: inline-block; padding-left: 10px; padding-right: 10px; vertical-align: top; top: 20px; position: relative\">";
                addOrRemove1ToCartForMember($conn,$redirectToString,$userId,$orderId,$row,$amountInCart);
            echo "</span>";
        }

        echo "<br>";
        if($booleanShowCart==true){
            echo "<span style=\"font-weight: 900; font-size: 20px; display: inline-block; margin-top: 65px; vertical-align: top; text-align: center; background-color: #ECDBBA; width: 30%; display: inline-block;\">";
            $priceForProducts = $row["price"]*$amountInCart;
            echo "amount in cart: $amountInCart";
            echo "<br>";
            echo "price for products: $priceForProducts";
        echo "</span>";    
        }
        


        
        
        $amount = $row["amount"];
        $warningNumber = 10;


        echo "<br>";
        echo "<br>";        
        if((($amount-$amountInCart)<=$warningNumber)&&(0<$amountInCart)&&($amountInCart<=$amount)){
            echo "<span style=\"font-weight: 900; font-size: 20; width: 80%; display: inline-block\" class=errorBackground>";
                echo "amount in stock is close to amount in cart (left: $amount)";
            echo "</span>";
            echo "<br>";
            echo "<br>";
        }
        else if(($amount<=$warningNumber)&&(0<$amount)){
                echo "<span style=\"font-weight: 900; font-size: 20;\" class=errorBackground>";
                    echo "low amount (left: $amount)";
                echo "</span>";
                echo "<br>";
                echo "<br>";
        }
        else if($amount==0)
        {
                echo "<span style=\"font-weight: 900; font-size: 20; color: red;\">";
                    echo "OUT OF STOCK";
                echo "</span>";
                echo "<br>";
                echo "<br>";
        }
        else if($amount<$amountInCart){
            echo "<span style=\"font-weight: 900; font-size: 20; display: inline-block;\" class=errorBackground>";
                echo "SORRY, WE DO NOT HAVE THAT AMOUNT IN STOCK";
                echo "<br>";
                echo "WE HAVE: $amount";
            echo "</span>";
            echo "<br>";
            echo "<br>";
        }


        if($booleanShowCart==false){
        
            $productId = $row["productId"];
            $sql = "SELECT numStar FROM reviews WHERE productId = $productId;";
            $sqlQueryResult = mysqli_query($conn,$sql);
            $count=0;
            $sum=0;
            while ($rowReview = mysqli_fetch_assoc($sqlQueryResult))
            {
                $count++; // there exist a better way
                $sum = $sum + $rowReview["numStar"];
            }
            if($count!=0){
                $rating = $sum/$count;
            }
            echo "<span style=\" text-align: center\">";
                if(0<$count){
                    for($i=1;$i<=5;$i++){
                        if($i<=$rating){
                            echo "<span class=\"fa fa-star checked\" style=\"color:gold;\"></span>";
                        }
                        else{
                            echo "<span class=\"fa fa-star checked\" style=\"color:white;\"></span>";   
                        }
                    }
                    echo "<br>";
                    if($count==1){
                        echo "($count rating)";
                    }
                    else{
                        echo "($count ratings)";
                    }
                    echo "<br>";
                    
                }
                else{
                    //echo "no ratings";
                }
            echo "</span>";

            echo "<br>";

            if($booleanIsLoggedIn==true){
                echo "<span style=\"width: 50%; margin-left: auto; margin-right: auto; left: 0; right: 0; text-align: center; min-width: 100px; display: inline-block; \">";
                    showReviews($conn,$productId);
                echo "</span>";    
            }
        }
        


        if($booleanShowCart==true){
            echo "<span class=dropdown style=\" width: 100%;\">";
                echo "<button style= \"font-weight: 500; font-size: 20; margin-top: 10px;\">show more</button>";
                echo "<span class=\"dropdown-content\">";
        }
                    echo "<span style=\"font-weight: 900; background-color: $backgroundColor; display: inline-block; width: 100%;\">";
                        echo "<span style=\" background-color: #ECDBBA; display: inline-block; width: 42%; float: left; height: 150px; overflow: scroll; margin-left: 5%\">";
                            $content = $row["content"];
                            echo "<h2>content</h2>";
                            echo $content;
                        echo "</span>";

                        

                        echo "<span style=\"background-color: #ECDBBA; display: inline-block; width: 42%; float: right; height: 150px; overflow: scroll; margin-right: 5%\">";
                            $info = $row["info"];
                            echo "<h2>info</h2>";
                            echo $info;
                        echo "</span>";
                    echo "</span>";
                
        if($booleanShowCart==true){
                echo "</span>";
            echo "</span>";
        }

        echo "<br>";
        echo "<br>";
        



    echo "</span>"; 


    if($booleanShowCart==true){
        
            $priceForThisProducts = $row["price"]*$amountInCart;
            return $priceForThisProducts;      
    }


    //*/
}



function showOrderStatus($status){

    if($status==0){
        $statusString = "something have happend to order";
    }
    elseif($status==1){
        $statusString = "awaiting confirmation";
    }
    elseif($status==2){
        $statusString = "confirmed";
    }
    elseif($status==3){
        $statusString = "sent";
    }
    elseif($status==4){
        $statusString = "on the way";
    }
    elseif($status==5){
        $statusString = "delivered";
    }


    return $statusString;
}




function addOrRemove1ToCartForMember($conn,$redirectToString,$userId,$orderId,$row,$amountInCart){

    // options
    $textOnAddButton = "add";
    $textOnRemoveButton = "remove";

    $nameForNumberBox = "amountInNumberBox"; // do not change
    $textOnNumberSubmitButton = "change";
    
    $productIdValue = $row["productId"];


      echo "<form method=\"POST\" action=\"actionAddOrRemove1ToCartForMember.php?redirectToString=$redirectToString&formEnum=0&orderId=$orderId&userId=$userId&productIdValue=$productIdValue&amountInCart=$amountInCart\">";

        echo "<input type=\"submit\" name=\"";
        echo $textOnAddButton;
        echo "\" value=\"".$textOnAddButton."\">"; 
    
      echo "</form>";


    echo "<form method=\"POST\" action=\"actionAddOrRemove1ToCartForMember.php?redirectToString=$redirectToString&formEnum=1&orderId=$orderId&userId=$userId&productIdValue=$productIdValue&amountInCart=$amountInCart\">";
                
      echo "<input style= \"width:100px;\" type=\"number\" name=\"";
      echo $nameForNumberBox;
      echo "\" value=\"".$amountInCart."\">";
      
      echo "<input type=\"submit\" name=\"";
      echo $textOnNumberSubmitButton;
      echo "\" value=\"".$textOnNumberSubmitButton."\">";

    echo "</form>";


    echo "<form method=\"POST\" action=\"actionAddOrRemove1ToCartForMember.php?redirectToString=$redirectToString&formEnum=2&orderId=$orderId&userId=$userId&productIdValue=$productIdValue&amountInCart=$amountInCart\">";

      echo "<input type=\"submit\" name=\"";
      echo $textOnRemoveButton;
      echo "\" value=\"".$textOnRemoveButton."\">";
        
    echo "</form>";
}



function changeOrderStatus($conn,$orderId,$userId,$status,$redirectToString){

    $textOnPreviousStatusButton = "change to previous status";
    $uniqueNameStringPreviousStatusButton = $textOnPreviousStatusButton.$orderId.$userId."changeOrderStatus";

    $textOnNextStatusButton = "change to next status";
    $uniqueNameStringNextStatusButton = $textOnNextStatusButton.$orderId.$userId."changeOrderStatus";


    echo "<form method=\"POST\" action=\"actionChangeOrderStatus.php?redirectToString=$redirectToString&orderId=$orderId&userId=$userId&status=$status&value=-1\">";
        echo "<input type=\"submit\" name=\"";
        echo $uniqueNameStringPreviousStatusButton; // unique name
        echo "\" value=\"".$textOnPreviousStatusButton."\">";
    echo "</form>";

    echo "<form method=\"POST\" action=\"actionChangeOrderStatus.php?redirectToString=$redirectToString&orderId=$orderId&userId=$userId&status=$status&value=1\">";
        echo "<input type=\"submit\" name=\"";
        echo $uniqueNameStringNextStatusButton;  // unique name
        echo "\" value=\"".$textOnNextStatusButton."\">";
    echo "</form>";
}


function changeOrderMessage($conn,$orderId,$userId,$redirectToString,$message){

    $textOnSubmitMessageButton = "submit message"; // do not change


    echo "<form method=\"POST\" action=\"actionChangeMessageOnOrder.php?redirectToString=$redirectToString&orderId=$orderId&userId=$userId\">";
        
        
        echo "<label for=\"message\">Message: </label><br><br>";
        echo "<textarea name=\"message\" id = \"message\" rows=\"3\" cols=\"20\" style=\"box-sizing: border-box; border: 2px solid #ccc; border-radius: 4px; background-color: #ECDBBA; \">$message</textarea>";

        echo "<input type=\"submit\" name=\"";
        echo $textOnSubmitMessageButton."message";
        echo "\" value=\"".$textOnSubmitMessageButton."\">";
        



    echo "</form>";
}

function showReviews($conn,$productId){

    $textOnShowReviewButton = "show review";
    $Reviews = "review.php";
    echo "<form method=\"POST\" action=\"$Reviews?productId=$productId\">";
        echo "<input type=\"submit\" name=\"";
        echo $textOnShowReviewButton;
        echo "\" value=\"".$textOnShowReviewButton."\">";
    echo "</form>";
}





// help functions stop-------------------------------------------------------------------------



// specific functions for productsForMembers.php start --------------------------------------------------------------------------------------------------



function showProductsForMember($conn,$userId,$orderId,$tableClassName){
  
  $redirectToString = "productsForMember.php";

  $productIdInCartArray = array();
  $amountInCartArray = array(); 
  $sqlForCart = "SELECT * FROM itemList WHERE userId = $userId AND orderId = $orderId;";
  $sqlQueryResult = mysqli_query($conn,$sqlForCart);
  while ($row = mysqli_fetch_assoc($sqlQueryResult))
  {
    $productIdInCartArray[] = $row["productId"];
    $amountInCartArray[] = $row["amount"];
  }


  $sql = "SELECT * FROM products;";
  $columnNameToShowArray = array("name","price","info","image");
  echo "<table class='$tableClassName'>";

  echo "<tr>";
  showTableHeader(array("name","price","info","image"));
  echo "<th></th><th></th>";
  echo "</tr>";
  
  $sqlQueryResult = mysqli_query($conn,$sql);
  while ($row = mysqli_fetch_assoc($sqlQueryResult))
  {
      echo "<tr>";
      foreach ($columnNameToShowArray as $columnName) {
          echo "<td>";
          showSimple($conn,$columnName,$row);  
          echo "</td>";
      }

      $amountInCart = 0;
      $i = 0;
      $productId = $row["productId"];
      foreach ($productIdInCartArray as $productIdTmp) {
        if($productIdTmp == $productId){
          $amountInCart = $amountInCartArray[$i];
        }
        $i++;
      }

      echo "<td>";
      addOrRemove1ToCartForMember($conn,$redirectToString,$userId,$orderId,$row,$amountInCart);
      echo "</td>";

      $productIdTmp = $row["productId"];
      echo "<td>";
      showReviews($conn,$productIdTmp);
      echo "</td>";

      echo "</tr>";
  }

   echo "</table>";

}


// specific functions for productsForMembers.php stop ----------------------------------------------------------------------------------------------




// specific functions for products.php start --------------------------------------------------------------------------------------------------



function showProducts($conn,$tableClassName){

  $sql = "SELECT * FROM products;";
  $columnNameToShowArray = array("name","price","info","image");
  echo "<table class='$tableClassName'>";

  echo "<tr>";
  showTableHeader(array("name","price","info","image"));
  echo "</tr>";

  $sqlQueryResult = mysqli_query($conn,$sql);
  while ($row = mysqli_fetch_assoc($sqlQueryResult))
  {
      echo "<tr>";
      foreach ($columnNameToShowArray as $columnName) {
          echo "<td>";
          showSimple($conn,$columnName,$row);
          echo "</td>";
      }
      echo "</tr>";
  }
   echo "</table>";
}


function showProductsBetter($conn,$numberOfColumns,$sqlForProducts,$booleanIsLoggedIn,$booleanShowCart,$userId,$orderId,$redirectToString){



    $sqlQueryResult = mysqli_query($conn,$sqlForProducts);
    $productToShowNumber = 0;
    $modulo=0;

    $width = (80/$numberOfColumns);
    $marginOnSides = (10/$numberOfColumns);


    if($booleanShowCart==true){
        $totalCost = 0;
    }

    echo "<div style=\" width: 80%; margin-left: 10%; background-color: #C84B31; margin-bottom: 100px; margin-top: 100px;\">";

        while ($row = mysqli_fetch_assoc($sqlQueryResult))
        {

            $productToShowNumber++;
            $modulo = $productToShowNumber%$numberOfColumns;

             $amountInCart=0;
                if($booleanIsLoggedIn == true){
                    $productId = $row["productId"];
                    $sqlForCart = "SELECT amount FROM itemList WHERE userId = $userId AND orderId = $orderId AND productId = $productId;";
                    $sqlQueryResultCart = mysqli_query($conn,$sqlForCart);
                    if($rowCart = mysqli_fetch_assoc($sqlQueryResultCart))
                    {
                        $amountInCart = $rowCart["amount"];
                    }
                }
                $amount = $row["amount"];

            if(($booleanShowCart==false)||(0<$amountInCart)){
                echo "<span style=\"display: inline-block; width: $width%; background-color: #C84B31; margin-left: $marginOnSides%; margin-right: $marginOnSides%; padding-top: 20px; padding-bottom: 20px; vertical-align: top;\">";

                    $priceForThisProducts = showProductBetter($conn,$row,$booleanIsLoggedIn,$booleanShowCart,$userId,$orderId,$redirectToString,$amountInCart);
                
                echo "</span>";

                if($modulo==0){
                    echo "<br>";
                }

                if($booleanShowCart==true){
                    $totalCost = $totalCost+$priceForThisProducts;
                }

            }




        }
        if($modulo!=0){
            echo "<br>";
        }

        






    echo "</div>";

    if($booleanShowCart==true){
        
        echo "<span style=\" text-align: center; border-radius: 15px; font-weight: 900; font-size: 20; background-color: #2D4263; display: inline-block; width: 10%; margin-top: 20px; margin-left: 35%; float: left; padding-bottom: 50px; padding-top: 50px; margin-bottom: 50px; margin-top: 50px;\">";
            echo "<a style=\"color: #ECDBBA; padding: 50px; \" href=\"/productsForMember.php\"> Browse </a>";
        echo "</span>";

        echo "<span style=\" text-align: center; border-radius: 15px; font-weight: 900; font-size: 20; background-color: #2D4263; display: inline-block; width: 10%; margin-top: 20px; margin-right: 35%; float: right; padding-bottom: 50px; padding-top: 50px; margin-bottom: 50px; margin-top: 50px;\">";
            echo "<a style=\"color: #ECDBBA; padding: 50px; \" href=\"/paymentPage.php\">Pay </a>";
        echo "</span>";




        echo "<span style=\"display: inline-block; position: fixed; top: 200px; left: 10%; width: 8%;\">";
            echo "<span style=\" text-align: center; border-radius: 15px; font-weight: 900; font-size: 20; background-color: #ECDBBA; display: inline-block; width: 100%; margin-top: 20px;\">";
                echo "total cost: <br>$totalCost";
            echo "</span>";
            echo "<br>";
            echo "<span style=\" text-align: center; border-radius: 15px; font-weight: 900; font-size: 20; background-color: #2D4263; width: 100%; display: inline-block; margin-top: 20px;\">";
                echo "<a style=\"color: #ECDBBA;\" href=\"/productsForMember.php\"> Browse </a>";
            echo "</span>";
            echo "<br>";
            echo "<span style=\" text-align: center; border-radius: 15px; font-weight: 900; font-size: 20; background-color: #2D4263; width: 100%; display: inline-block; margin-top: 20px;\">";
                echo "<a style=\"color: #ECDBBA;\" href=\"/paymentPage.php\"> Pay </a>";
            echo "</span>";
        echo "</span>";
    }
}



// specific functions for products.php stop ----------------------------------------------------------------------------------------------



// specific functions for membersCart.php start ----------------------------------------------------------------------------------------------------


function showMemberCart($conn,$userId,$orderId,$tableClassName){
  
  $redirectToString = "memberCart.php";
  

  $productIdInCartArray = array();
  $amountInCartArray = array(); 
  $sqlForCart = "SELECT * FROM itemList WHERE userId = $userId AND orderId = $orderId;";
  $sqlQueryResult = mysqli_query($conn,$sqlForCart);
  $sqlForProductIdConditionArray = array();
  $itemListRowArray = array();
  while ($row = mysqli_fetch_assoc($sqlQueryResult))
  {
    $itemListRowArray[] = $row;
    $productIdInCartArray[] = $row["productId"];
    $amountInCartArray[] = $row["amount"];
  }


  
  $columnNameToShowArray = array("name","price","info","image");


  echo "<table class='$tableClassName'>";

  echo "<tr>";
  showTableHeader(array("name","price","info","image"));
  echo "<th></th>";
  echo "</tr>";

  $totalCost = 0;
  $i = 0;
  foreach ($productIdInCartArray as $productIdInCart) {
    $sql = "SELECT * FROM products WHERE productId = $productIdInCart";
    $sqlQueryResult = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($sqlQueryResult);

    echo "<tr>";
    foreach ($columnNameToShowArray as $columnName) {
        echo "<td>";
        showSimple($conn,$columnName,$row);
	
	if($columnName == "price"){
	    $priceTmp = $row["price"];
	    $amountTmp = $amountInCartArray[$i];
	    $totalCost = $totalCost + $priceTmp * $amountTmp;
	}

        
        echo "</td>";
    }

    $amountInCart = $amountInCartArray[$i];
    

    echo "<td>";
    addOrRemove1ToCartForMember($conn,$redirectToString,$userId,$orderId,$row,$amountInCart);
    echo "</td>";


    echo "</tr>";

    $i++;
  }
   echo "</table>";

   echo "<br><br>Total cost: ".$totalCost;
}

// specific functions for membersCart.php stop ----------------------------------------------------------------------------------------------------



// specific functions for distributer_start.php start -------------------------------------------------------------------------------------------------




function showForDistributer($conn, $tableClassForVisual){

                 
    $redirectToString = "distributer_start.php";


    for($orderStatusIterator = 0;$orderStatusIterator<=5;$orderStatusIterator++){
        $tmp = showOrderStatus($orderStatusIterator);
        echo "order status: ".$tmp."<br>";
        $sqlForOrders = "SELECT * FROM orders WHERE status = $orderStatusIterator;";
        $sqlForOrdersQueryResult = mysqli_query($conn,$sqlForOrders);

        //echo "<table class= '$tableClassForVisual'>";

        while($orderRowWithSpecificStatus = mysqli_fetch_assoc($sqlForOrdersQueryResult)){

            echo "<table class= '$tableClassForVisual'>";


            $userId = $orderRowWithSpecificStatus["userId"];
            $orderId = $orderRowWithSpecificStatus["orderId"];
            $adress = $orderRowWithSpecificStatus["adress"];
            $orderStatus = $orderRowWithSpecificStatus["status"]; // (unnecessarry for now, can use $orderStatusIterator)
            $orderStatusText = showOrderStatus($orderStatus);

            $sqlForUser = "SELECT * FROM users WHERE userId = $userId;";
            $sqlForUserQueryResult = mysqli_query($conn,$sqlForUser);
            $userRow = mysqli_fetch_assoc($sqlForUserQueryResult);

            $userName = $userRow["name"];
            $userEmail = $userRow["email"];



            $boldText1 = "orderId: ".$orderId;
            $boldText2 = "userId: ".$userId;
            $boldText3 = "users name: ".$userName;
            $boldText4 = "users email: ".$userEmail;
            $boldText5 = "adress: ".$adress;
            $boldText6 = "order status: ".$orderStatusText;



            echo "<tr>";
                showTableHeader(array($boldText1,$boldText2,$boldText3,$boldText4,$boldText5,$boldText6)); // used to show in bold text etc, not as table header
                echo "<th>";
                    // change orderStatusFunction
                    changeOrderStatus($conn,$orderId,$userId,$orderStatus,$redirectToString);
                echo "</th>";
            echo "</tr>";
            echo "<tr>";
                echo "<th><b>";
                    echo "products: ";
                echo "</b></th>";
                //echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>";
                    echo "productId";
                echo "</b></td>";
                echo "<td><b>";
                    echo "product name";
                echo "</b></td>";
                echo "<td><b>";
                    echo "amount";
                echo "</b></td>";
                //echo "<td></td><td></td><td></td><td></td>";
            echo "</tr>";
            $sqlForÍtemListForOneOrderAndForOneUser = "SELECT * FROM itemList WHERE userId = $userId AND orderId = $orderId;";
            $sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult = mysqli_query($conn,$sqlForÍtemListForOneOrderAndForOneUser);
            while($itemListRowWithOrderIdAndUserId = mysqli_fetch_assoc($sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult)){
                $productId = $itemListRowWithOrderIdAndUserId["productId"];
                $sqlForProductsForSpecificProductId = "SELECT * FROM products WHERE productId = $productId;";
                $sqlForProductsForSpecificProductIdQueryResult = mysqli_query($conn,$sqlForProductsForSpecificProductId);
                $productRow = mysqli_fetch_assoc($sqlForProductsForSpecificProductIdQueryResult);

                echo "<tr>";
                    echo "<td>";
                        echo $productRow["productId"];
                    echo "</td>";
                    echo "<td>";
                        echo $productRow["name"];
                    echo "</td>";
                    echo "<td>";
                        echo $itemListRowWithOrderIdAndUserId["amount"];
                    echo "</td>";
                    //echo "<td></td><td></td><td></td><td></td>";

                echo "</tr>";
            }
        }

        echo "</table>";

    }

}


// specific functions for distributer_start.php stop -------------------------------------------------------------------------------------------------



// specific functions for memberOrders.php start ------------------------------------------------------------------------------------------------


function showOrdersForUser($conn,$userId,$tableClassForVisual){


    $redirectToString = "memberOrders.php";


    for($orderStatusIterator = 0;$orderStatusIterator<=5;$orderStatusIterator++){
        $sqlForOrders = "SELECT * FROM orders WHERE status = $orderStatusIterator AND userId = $userId;";
        $sqlForOrdersQueryResult = mysqli_query($conn,$sqlForOrders);


        while($orderRowWithSpecificStatus = mysqli_fetch_assoc($sqlForOrdersQueryResult)){
	    
             echo "<table class= '$tableClassForVisual'>";

            $orderId = $orderRowWithSpecificStatus["orderId"];
            $adress = $orderRowWithSpecificStatus["adress"];
            $orderStatus = $orderRowWithSpecificStatus["status"]; // (unnecessarry for now, can use $orderStatusIterator)
            $orderStatusText = showOrderStatus($orderStatus);
            $message = $orderRowWithSpecificStatus["message"];
            $totalCost = $orderRowWithSpecificStatus["totalCost"];

            $sqlForUser = "SELECT * FROM users WHERE userId = $userId;";
            $sqlForUserQueryResult = mysqli_query($conn,$sqlForUser);
            $userRow = mysqli_fetch_assoc($sqlForUserQueryResult);

            $userName = $userRow["name"];
            $userEmail = $userRow["email"];



            $boldText1 = "orderId: ".$orderId;
            $boldText2 = "userId: ".$userId;
            $boldText3 = "users name: ".$userName;
            $boldText4 = "users email: ".$userEmail;
            $boldText5 = "adress: ".$adress;
            $boldText6 = "order status:<br>".$orderStatusText;
            $boldText7 = "message:<br>".$message;



            echo "<tr>";
                showTableHeader(array($boldText1,$boldText2,$boldText3,$boldText4,$boldText5,$boldText6,$boldText7)); // used to show in bold text etc, not as table header
            echo "</tr>";
            echo "<tr>";
                echo "<th><b>";
                    echo "products: ";
                echo "</b></th>";
                //echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>";
                    echo "productId";
                echo "</b></td>";
                echo "<td><b>";
                    echo "product name";
                echo "</b></td>";
                echo "<td><b>";
                    echo "amount";
                echo "</b></td>";
                //echo "<td></td><td></td><td></td><td></td>";
            echo "</tr>";
            $sqlForÍtemListForOneOrderAndForOneUser = "SELECT * FROM itemList WHERE userId = $userId AND orderId = $orderId;";
            $sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult = mysqli_query($conn,$sqlForÍtemListForOneOrderAndForOneUser);
            while($itemListRowWithOrderIdAndUserId = mysqli_fetch_assoc($sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult)){
                $productId = $itemListRowWithOrderIdAndUserId["productId"];
                $sqlForProductsForSpecificProductId = "SELECT * FROM products WHERE productId = $productId;";
                $sqlForProductsForSpecificProductIdQueryResult = mysqli_query($conn,$sqlForProductsForSpecificProductId);
                $productRow = mysqli_fetch_assoc($sqlForProductsForSpecificProductIdQueryResult);

                echo "<tr>";
                    echo "<td>";
                        echo $productRow["productId"];
                    echo "</td>";
                    echo "<td>";
                        echo $productRow["name"];
                    echo "</td>";
                    echo "<td>";
                        echo $itemListRowWithOrderIdAndUserId["amount"];
                    echo "</td>";
                    //echo "<td></td><td></td><td></td><td></td>";
                echo "</tr>";
            }
	    echo "</table>";
            echo "TotalCost: ".$totalCost;
	    echo "<br><br><br><br>";
        }
    }


}


// specific functions for memberOrders.php stop ------------------------------------------------------------------------------------------------


// specific functions for admin_orders.php start -------------------------------------------------------------------------------------------------



function showForAdmin_orders($conn, $tableClassForVisual){

                 
    $redirectToString = "admin_orders.php";


    for($orderStatusIterator = 0;$orderStatusIterator<=5;$orderStatusIterator++){
        $tmp = showOrderStatus($orderStatusIterator);
        echo "order status: ".$tmp."<br>";
        $sqlForOrders = "SELECT * FROM orders WHERE status = $orderStatusIterator;";
        $sqlForOrdersQueryResult = mysqli_query($conn,$sqlForOrders);

        //echo "<table class= '$tableClassForVisual'>";

        while($orderRowWithSpecificStatus = mysqli_fetch_assoc($sqlForOrdersQueryResult)){

            echo "<table class= '$tableClassForVisual'>";


            $userId = $orderRowWithSpecificStatus["userId"];
            $orderId = $orderRowWithSpecificStatus["orderId"];
            $adress = $orderRowWithSpecificStatus["adress"];
            $orderStatus = $orderRowWithSpecificStatus["status"]; // (unnecessarry for now, can use $orderStatusIterator)
            $orderStatusText = showOrderStatus($orderStatus);
            $message = $orderRowWithSpecificStatus["message"];

            $sqlForUser = "SELECT * FROM users WHERE userId = $userId;";
            $sqlForUserQueryResult = mysqli_query($conn,$sqlForUser);
            $userRow = mysqli_fetch_assoc($sqlForUserQueryResult);

            $userName = $userRow["name"];
            $userEmail = $userRow["email"];



            $boldText1 = "orderId: ".$orderId;
            $boldText2 = "userId: ".$userId;
            $boldText3 = "users name: ".$userName;
            $boldText4 = "users email: ".$userEmail;
            $boldText5 = "adress: ".$adress;
            $boldText6 = "order status: ".$orderStatusText;



            echo "<tr>";
                showTableHeader(array($boldText1,$boldText2,$boldText3,$boldText4,$boldText5,$boldText6)); // used to show in bold text etc, not as table header
                echo "<th>";
                    changeOrderStatus($conn,$orderId,$userId,$orderStatus,$redirectToString);
                echo "</th>";
                echo "<th>";
                    changeOrderMessage($conn,$orderId,$userId,$redirectToString,$message);
                echo "</th>";
            echo "</tr>";
            echo "<tr>";
                echo "<th><b>";
                    echo "products: ";
                echo "</b></th>";
                //echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>";
                    echo "productId";
                echo "</b></td>";
                echo "<td><b>";
                    echo "product name";
                echo "</b></td>";
                echo "<td><b>";
                    echo "amount";
                echo "</b></td>";
                //echo "<td></td><td></td><td></td><td></td>";
            echo "</tr>";
            $sqlForÍtemListForOneOrderAndForOneUser = "SELECT * FROM itemList WHERE userId = $userId AND orderId = $orderId;";
            $sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult = mysqli_query($conn,$sqlForÍtemListForOneOrderAndForOneUser);
            while($itemListRowWithOrderIdAndUserId = mysqli_fetch_assoc($sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult)){
                $productId = $itemListRowWithOrderIdAndUserId["productId"];
                $sqlForProductsForSpecificProductId = "SELECT * FROM products WHERE productId = $productId;";
                $sqlForProductsForSpecificProductIdQueryResult = mysqli_query($conn,$sqlForProductsForSpecificProductId);
                $productRow = mysqli_fetch_assoc($sqlForProductsForSpecificProductIdQueryResult);

                echo "<tr>";
                    echo "<td>";
                        echo $productRow["productId"];
                    echo "</td>";
                    echo "<td>";
                        echo $productRow["name"];
                    echo "</td>";
                    echo "<td>";
                        echo $itemListRowWithOrderIdAndUserId["amount"];
                    echo "</td>";
                    //echo "<td></td><td></td><td></td><td></td>";

                echo "</tr>";
            }
        }

        echo "</table>";

    }

}

// specific functions for admin_orders.php stop -------------------------------------------------------------------------------------------------



function showOrdersViaTable($conn, $tableClassForVisual, $redirectToString, $booleanShowOrdersForAllUsers, $userId, $booleanShowBigStatusHeader, $booleanShowStatusOnOrder, $booleanShowPrice, $booleanShowOrderId, $booleanShowUserId, $booleanShowUserName, $booleanShowUserEmail,$booleanShowAdress,$booleanShowChangeOrderStatus,$booleanShowChangeOrderMessage,$booleanShowProducts,$booleanShowProductId,$booleanShowProductImage,$booleanShowProductName,$booleanShowProductAmount){

    echo "<div style=\" width: 90%; margin-left: 5%; margin-right 5%; background-color: #C84B31; margin-bottom: 100px; margin-top: 100px; overflow-x: scroll; padding-top: 25px; padding-bottom: 25px;\">";

        for($orderStatusIterator = 0;$orderStatusIterator<=5;$orderStatusIterator++){

            if($booleanShowOrdersForAllUsers==true){
                $sqlForOrders = "SELECT * FROM orders WHERE status = $orderStatusIterator;";
            }
            else{
                $sqlForOrders = "SELECT * FROM orders WHERE status = $orderStatusIterator AND userId = $userId;";
            }
            
            $sqlForOrdersQueryResult = mysqli_query($conn,$sqlForOrders);

            if($booleanShowBigStatusHeader==true){
                echo "<span style=\"width: 95%; margin-left: 2.5%; margin-top: 10px; margin-bottom: 10px; background-color: #ECDBBA; display: inline-block; padding-top: 25px; padding-bottom: 25px; text-align: center; font-weight: 900; font-size: 20px;\">";
                    $tmp = showOrderStatus($orderStatusIterator);
                    echo "order status: ".$tmp."<br>";
                echo "</span>";
            }


            while($orderRowWithSpecificStatus = mysqli_fetch_assoc($sqlForOrdersQueryResult)){

                echo "<table class= '$tableClassForVisual' style=\"margin-left: 5%; margin-right: 5%; width: 90%; background-color: #2D4263; color: #ECDBBA;\">";


                    $userId = $orderRowWithSpecificStatus["userId"];
                    $orderId = $orderRowWithSpecificStatus["orderId"];
                    $adress = $orderRowWithSpecificStatus["adress"];
                    $orderStatusText = showOrderStatus($orderStatus);
                    $message = $orderRowWithSpecificStatus["message"];

                    $sqlForUser = "SELECT * FROM users WHERE userId = $userId;";
                    $sqlForUserQueryResult = mysqli_query($conn,$sqlForUser);
                    $userRow = mysqli_fetch_assoc($sqlForUserQueryResult);

                    $userName = $userRow["name"];
                    $userEmail = $userRow["email"];

                    if(($booleanShowStatusOnOrder==true)||($booleanShowPrice==true)){    
                        echo "<tr>";
                            if($booleanShowStatusOnOrder==true){
                                echo "<td>";
                                    echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                        echo "order status: ";
                                    echo "</span>";
                                    echo "<br>";
                                    $tmp = showOrderStatus($orderStatusIterator);
                                    echo $tmp;
                                echo "</td>";
                            }
                            if($booleanShowPrice==true){
                                echo "<td>";
                                    echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                        echo "total cost: ";
                                    echo "</span>";
                                    echo "<br>";
                                    echo $orderRowWithSpecificStatus["totalCost"];
                                echo "</td>";
                            }
                        echo "</tr>";
                    }
                    
                    
                    echo "<tr>";
                        if($booleanShowOrderId==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "orderId: ";
                                echo "</span>";
                                echo "<br>";
                                echo $orderId;
                            echo "</td>";
                        }
                        if($booleanShowUserId==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "userId: ";
                                echo "</span>";
                                echo "<br>";
                                echo $userId;
                            echo "</td>";
                        }
                        if($booleanShowUserName==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "users name: ";
                                echo "</span>";
                                echo "<br>";
                                echo $userName;
                            echo "</td>";
                        }
                        if($booleanShowUserEmail==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "users email: ";
                                echo "</span>";
                                echo "<br>";
                                echo $userEmail;
                            echo "</td>";
                        }
                        if($booleanShowAdress==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "adress: ";
                                echo "</span>";
                                echo "<br>";
                                echo $adress;
                            echo "</td>";
                        }
                        if($booleanShowChangeOrderStatus==true){
                            echo "<td>";
                                changeOrderStatus($conn,$orderId,$userId,$orderStatus,$redirectToString);
                            echo "</td>";
                        }
                        if($booleanShowChangeOrderMessage==true){
                            echo "<td>";
                                changeOrderMessage($conn,$orderId,$userId,$redirectToString,$message);
                            echo "</td>";
                        }
                    echo "</tr>";
                    if($booleanShowProducts==true){
                        echo "<tr>";
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "products ";
                                echo "</span>";
                           echo "</td>";   
                        echo "</tr>";

                        echo "<tr>";
                        if($booleanShowProductId==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: padding-left: 10px; inline-block;  text-align: left;\">";
                                    echo "productId ";
                                echo "</span>";
                            echo "</td>";
                        }
                        if($booleanShowProductImage==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "product image ";
                                echo "</span>";
                            echo "</td>";
                        }
                        if($booleanShowProductName==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "product name ";
                                echo "</span>";
                            echo "<td>";
                        }
                        if($booleanShowProductAmount==true){
                            echo "<td>";
                                echo "<span style=\" background-color: #ECDBBA; color: black; padding-right: 10px; padding-left: 10px; display: inline-block;  text-align: left;\">";
                                    echo "amount ";
                                echo "</span>";
                            echo "</td>";
                        }
                        echo "</tr>";
                    
                        $sqlForÍtemListForOneOrderAndForOneUser = "SELECT * FROM itemList WHERE userId = $userId AND orderId = $orderId;";
                        $sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult = mysqli_query($conn,$sqlForÍtemListForOneOrderAndForOneUser);
                        while($itemListRowWithOrderIdAndUserId = mysqli_fetch_assoc($sqlForÍtemListForOneOrderIdAndForOneUserIdQueryResult)){
                            $productId = $itemListRowWithOrderIdAndUserId["productId"];
                            $sqlForProductsForSpecificProductId = "SELECT * FROM products WHERE productId = $productId;";
                            $sqlForProductsForSpecificProductIdQueryResult = mysqli_query($conn,$sqlForProductsForSpecificProductId);
                            $productRow = mysqli_fetch_assoc($sqlForProductsForSpecificProductIdQueryResult);
                            
                            echo "<tr>";
                                if($booleanShowProductId==true){
                                echo "<td>";
                                    echo $productRow["productId"];
                                echo "</td>";
                                }
                                if($booleanShowProductImage==true){
                                    echo "<td>";
                                        $resultTmp = mysqli_query($conn,"SELECT image FROM products WHERE productId = $productId;");
                                        $rowTmp = mysqli_fetch_assoc($resultTmp);
                                        $imageTmp = $rowTmp["image"];
                                        echo "<img src= \"". $imageTmp. "\" style= \"width:50px;height:50px;\">";
                                    echo "</td>";
                                }
                                if($booleanShowProductName==true){
                                    echo "<td>";
                                        echo $productRow["name"];
                                    echo "<td>";
                                }
                                if($booleanShowProductAmount==true){
                                    echo "<td>";
                                        echo $itemListRowWithOrderIdAndUserId["amount"];
                                    echo "</td>";
                                }
                            echo "</tr>";
                            
                        }
                    }
                echo "</table>";
            }   
        }

    echo "</div>";
}


function showOrdersViaTableAdmin($conn, $tableClassForVisual, $redirectToString){
    //$conn
    //$tableClassForVisual
    //$redirectToString
    $booleanShowOrdersForAllUsers = true;
    $userId = "dummy";
    $booleanShowBigStatusHeader = true;
    $booleanShowStatusOnOrder = true;
    $booleanShowPrice = true;
    $booleanShowOrderId  = true;
    $booleanShowUserId  = true;
    $booleanShowUserName  = true;
    $booleanShowUserEmail  = true;
    $booleanShowAdress  = true;
    $booleanShowChangeOrderStatus  = true;
    $booleanShowChangeOrderMessage  = true;
    $booleanShowProducts  = true;
    $booleanShowProductId  = true;
    $booleanShowProductImage = false; // differance between Distributer and Admin
    $booleanShowProductName = true;
    $booleanShowProductAmount = true;

    showOrdersViaTable($conn, $tableClassForVisual, $redirectToString, $booleanShowOrdersForAllUsers, $userId, $booleanShowBigStatusHeader, $booleanShowStatusOnOrder, $booleanShowPrice, $booleanShowOrderId, $booleanShowUserId, $booleanShowUserName, $booleanShowUserEmail,$booleanShowAdress,$booleanShowChangeOrderStatus,$booleanShowChangeOrderMessage,$booleanShowProducts,$booleanShowProductId,$booleanShowProductImage,$booleanShowProductName,$booleanShowProductAmount);

}

function showOrdersViaTableDistributer($conn, $tableClassForVisual, $redirectToString){
    //$conn
    //$tableClassForVisual
    //$redirectToString
    $booleanShowOrdersForAllUsers = true;
    $userId = "dummy";
    $booleanShowBigStatusHeader = true;
    $booleanShowStatusOnOrder = true;
    $booleanShowPrice = true;
    $booleanShowOrderId  = true;
    $booleanShowUserId  = true;
    $booleanShowUserName  = true;
    $booleanShowUserEmail  = true;
    $booleanShowAdress  = true;
    $booleanShowChangeOrderStatus  = true;
    $booleanShowChangeOrderMessage  = false; // differance between Distributer and Admin 
    $booleanShowProducts  = true;
    $booleanShowProductId  = true;
    $booleanShowProductImage = false;
    $booleanShowProductName = true;
    $booleanShowProductAmount = true;

    showOrdersViaTable($conn, $tableClassForVisual, $redirectToString, $booleanShowOrdersForAllUsers, $userId, $booleanShowBigStatusHeader, $booleanShowStatusOnOrder, $booleanShowPrice, $booleanShowOrderId, $booleanShowUserId, $booleanShowUserName, $booleanShowUserEmail,$booleanShowAdress,$booleanShowChangeOrderStatus,$booleanShowChangeOrderMessage,$booleanShowProducts,$booleanShowProductId,$booleanShowProductImage,$booleanShowProductName,$booleanShowProductAmount);
}

function showOrdersViaTableMember($conn, $tableClassForVisual, $redirectToString,$userId){
    //$conn
    //$tableClassForVisual
    //$redirectToString
    $booleanShowOrdersForAllUsers = false;
    //$userId
    $booleanShowBigStatusHeader = true;
    $booleanShowStatusOnOrder = true;
    $booleanShowPrice = true;
    $booleanShowOrderId  = true;
    $booleanShowUserId  = false;
    $booleanShowUserName  = true;
    $booleanShowUserEmail  = true;
    $booleanShowAdress  = true;
    $booleanShowChangeOrderStatus  = false;
    $booleanShowChangeOrderMessage  = false; // differance between Distributer and Admin 
    $booleanShowProducts  = true;
    $booleanShowProductId  = true;
    $booleanShowProductImage = true;
    $booleanShowProductName = true;
    $booleanShowProductAmount = true;

    showOrdersViaTable($conn, $tableClassForVisual, $redirectToString, $booleanShowOrdersForAllUsers, $userId, $booleanShowBigStatusHeader, $booleanShowStatusOnOrder,$booleanShowPrice, $booleanShowOrderId, $booleanShowUserId, $booleanShowUserName, $booleanShowUserEmail,$booleanShowAdress,$booleanShowChangeOrderStatus,$booleanShowChangeOrderMessage,$booleanShowProducts,$booleanShowProductId,$booleanShowProductImage,$booleanShowProductName,$booleanShowProductAmount);
}


















?>
