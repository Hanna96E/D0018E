x<?php


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


function showOrderStatus($status){
    return $status;
}




function addOrRemove1ToCartForMember($conn,$redirectToString,$userId,$orderId,$row,$amountInCart){

    // options
    $textOnAddButton = "+";
    $textOnRemoveButton = "-";

    $nameForNumberBox = "amountInNumberBox"; // do not change
    $textOnNumberSubmitButton = "change";
    
    $productIdValue = $row["productId"];


      echo "<form method=\"POST\" action=\"actionAddOrRemove1ToCartForMember.php?redirectToString=$redirectToString&formEnum=0&orderId=$orderId&userId=$userId&productIdValue=$productIdValue&amountInCart=$amountInCart\">";

        echo "<input type=\"submit\" name=\"";
        echo $textOnAddButton;
        echo "\" value=\"".$textOnAddButton."\">"; 
    
      echo "</form>";


    echo "<form method=\"POST\" action=\"actionAddOrRemove1ToCartForMember.php?redirectToString=$redirectToString&formEnum=1&orderId=$orderId&userId=$userId&productIdValue=$productIdValue&amountInCart=$amountInCart\">";
                
      echo "<input type=\"number\" name=\"";
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

    echo "<form method=\"POST\" action=\"actionChangeOrderMessage.php?redirectToString=$redirectToString&orderId=$orderId&userId=$userId\">";
        
        
        echo "<label for=\"message\">Message: </label><br><br>";
        echo "<textarea name=\"message\" id = \"message\" rows=\"3\" cols=\"20\">$message</textarea>";

        echo "<input type=\"submit\" name=\"";
        echo $textOnSubmitMessageButton."message";
        echo "\" value=\"".$textOnSubmitMessageButton."\">";
        



    echo "</form>";
}

function showReviews($conn,$productId){

    $textOnShowReviewButton = "show review";
    $Reviews = "productReviews.php";
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






// specific functions for membersCart.php start ----------------------------------------------------------------------------------------------------


function showMemberCart($conn,$userId,$orderId,$tableClassName){
  
  $redirectToString = "memberCart.php";

  $totalCost = 0;

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


  $i = 0;
  foreach ($productIdInCartArray as $productIdInCart) {
    $sql = "SELECT * FROM products WHERE productId = $productIdInCart";
    $sqlQueryResult = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($sqlQueryResult);

    echo "<tr>";
    foreach ($columnNameToShowArray as $columnName) {
        echo "<td>";
        showSimple($conn,$columnName,$row);
        echo "</td>";
    }

    $amountInCart = $amountInCartArray[$i];
    

    echo "<td>";
    addOrRemove1ToCartForMember($conn,$redirectToString,$userId,$orderId,$row,$amountInCart);
    echo "</td>";

    
    $tableName = "itemList";
    $primaryKeyColumnNameArray = array("listId");
    $row = $itemListRowArray[$i];
    deleteRow($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$row);
    
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
            $boldText6 = "orders status: ".$orderStatusText;



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

        echo "<table class= '$tableClassForVisual'>";

        while($orderRowWithSpecificStatus = mysqli_fetch_assoc($sqlForOrdersQueryResult)){
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
            $boldText6 = "orders status:<br>".$orderStatusText;
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

            echo "<tr></tr>";
            echo "<tr>";
            echo "TotalCost: ".$totalCost;
            echo "</tr>";
            echo "<tr></tr>";

        }

        echo "</table>";

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
            $boldText6 = "orders status: ".$orderStatusText;



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




?>
