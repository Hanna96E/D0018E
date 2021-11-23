<?php

// connection start-----------------------------------------------------------------------------------------------------------



// connection stop------------------------------------------------------------------------------

// help functions start-------------------------------------------------------------------------

function getUniqueNameString($tableName,$primaryKeyColumnNameArray,$columnName,$row){
    $primarKeyValueArrayString = $row[$primaryKeyColumnNameArray[0]];
    $size = count($primaryKeyColumnNameArray);
    for($i=1;$i<$size;$i++){
        $primarKeyValueArrayString = $primarKeyValueArrayString.$row[$primaryKeyColumnNameArray[$i]];
    }

    $uniqueNameString = $tableName.$columnName.$primarKeyValueArrayString;
    return $uniqueNameString;
}

function goToButton($conn,$textOnButton,$redirectToString){ // textOnButton should be unique
    echo "<form action=$redirectToString method=\"POST\">";
        echo "<input type=\"submit\" name=\"";
        echo $textOnButton."goToButton";
        echo "\" value=\"".$textOnButton."\">";
    echo "</form>";       
}


function showOrderStatus($status){
    echo "status: ".$status;
}



// help functions stop-------------------------------------------------------------------------


// columnFunctions start-------------------------------------------------------------------------
// argument must be: ($conn,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument)

function showSimple($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument){
    $object = $row[$columnName];
    if($booleanTreatAsImage == "image"){
        echo "<img src= \"". $object. "\" style= \"width:50px;height:50px;\">";
    }
    else{
        echo $object;
    }
}

function changeSimple($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument){
    showSimple($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument);

    $placeHolder = "write here";
    $textOnSubmitButton = "submit change";

    $uniqueNameString = getUniqueNameString($tableName,$primaryKeyColumnNameArray,$columnName,$row);
    $uniqueNameStringOnTextInput = "textInput".$uniqueNameString."changeSimple";
    $uniqueNameStringOnSubmitButton = "submitButton".$uniqueNameString."changeSimple";

    echo "<form method=\"POST\">";

        echo "<input type=\"text\" name=\"";
        echo $uniqueNameStringOnTextInput;
        echo "\" placeholder=\"".$placeHolder."\">";

        echo "<br>";

        echo "<input type=\"submit\" name=\"";
        echo $uniqueNameStringOnSubmitButton;
        echo "\" value=\"".$textOnSubmitButton."\">";

    echo "</form>";



    //echo "<br>unique submbit change name: <br>$uniqueNameStringOnSubmitButton<br>";

    if(isset($_POST[$uniqueNameStringOnSubmitButton])){
        unset($_POST[$uniqueNameStringOnSubmitButton]);
        
        $value = $_POST[$uniqueNameStringOnTextInput];

        $size = count($primaryKeyColumnNameArray);
        $primaryKeyColumnName = $primaryKeyColumnNameArray[0];
        $tmp = $row[$primaryKeyColumnNameArray[0]];
        $sqlCondition = "$primaryKeyColumnName = $tmp ";
        for($i=1;$i<$size;$i++){
            $primaryKeyColumnName = $primaryKeyColumnNameArray[$i];
            $tmp = $row[$primaryKeyColumnNameArray[$i]];
            $sqlCondition = $sqlCondition."AND $primaryKeyColumnName = $tmp ";
        }

        $sql = "UPDATE $tableName SET $columnName = $value WHERE ".$sqlCondition.";";
        mysqli_query($conn,$sql);

        header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
        exit;
    }
}


function showCartForMember($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument){ // this function assumes alot. At least table names and column names in the data base. !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


    $productTableName = "products";
    $columnsToShowFromProductTable = array("name","info","image");
    $productIdValue = $row["productId"];

    if($columnName=="productId"){
        
        $sql = "SELECT * FROM $productTableName WHERE $columnName = $productIdValue;";
        $sqlQueryResult = mysqli_query($conn,$sql);
        $productRow = mysqli_fetch_assoc($sqlQueryResult);

        $i = 1; // i shall start at 1 (dont change)
        $size = count($columnsToShowFromProductTable);
        foreach ($columnsToShowFromProductTable as $columnNameToShow) {
            $booleanTreatAsImage = false;
            if($columnNameToShow == "image"){
                $booleanTreatAsImage = true;
            }

            // all are dummies except $columnName, $row and $booleanTreatAsImage
            $columnName =  $columnNameToShow;
            $row = $productRow;
            showSimple($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument);

            if($i<$size){
                echo "</td><td>";
            }
            $i++;
        }
    }
    elseif($columnName=="amount"){

        // unpack---
        $userId = $additionalSpecificColumnFunctionArgument[0];
        $orderId = $additionalSpecificColumnFunctionArgument[1];


        $amount = $row[$columnName];
        $uniqueNameString = $productIdValue."showCartForMember";
        $uniqueNameStringAdd = "add".$uniqueNameString;
        $uniqueNameStringRemove = "remove".$uniqueNameString;
        $uniqueNameStringNumber = "number".$uniqueNameString;


        // add button---------------------------------------------------
        echo "<form method=\"POST\">";
            echo "<input type=\"submit\" name=\"";
            echo $uniqueNameStringAdd;
            echo "\" value=\""."add 1"."\">"; 
        echo "</form>";

        if(isset($_POST[$uniqueNameStringAdd])){
            unset($_POST[$uniqueNameStringAdd]);
    
            $sql = "UPDATE itemList SET amount = amount + 1 WHERE userId = $userId And orderId = $orderId And productId = $productIdValue;";
                                        
            mysqli_query($conn,$sql);
            header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
            exit;
        }

        // number field and remmove button-----------------------

        echo "<form method=\"POST\">";
            
            // echo "<br>";            
            echo "<input type=\"number\" name=\"";
            echo $uniqueNameStringNumber;
            echo "\" value=\"".$amount."\">";

            echo "<br>";
            echo "<input type=\"submit\" name=\"";
            echo $uniqueNameStringRemove;
            echo "\" value=\""."remove 1"."\">";
            
        echo "</form>";


        if(isset($_POST[$uniqueNameStringRemove])){
            unset($_POST[$uniqueNameStringRemove]);

            $amountInNumberBox = $_POST[$uniqueNameStringNumber];
            if($amountInNumberBox == $amount){
                
                if(1<$amount){
                    $sql = "UPDATE itemList SET amount = amount - 1 WHERE userId = $userId And orderId = $orderId And productId = $productIdValue;";
                    }
                else{
                    $sql = "DELETE FROM itemList WHERE userId = $userId And orderId = $orderId And productId = $productIdValue;";
                }
            }
            else{
                if(0<$amountInNumberBox){
                $sql = "UPDATE itemList SET amount = $amountInNumberBox WHERE userId = $userId And orderId = $orderId And productId = $productIdValue;";
                }
                else{
                    $sql = "DELETE FROM itemList WHERE userId = $userId And orderId = $orderId And productId = $productIdValue;";
                }                
            }
            mysqli_query($conn,$sql);
            header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
            exit;
        }
    }
    else{
        echo "error, showCartForMember, this function is supose only to take productId and amount as columnNames";
    }
}

// columnFunctions stop-------------------------------------------------------------------------


// rowFunctions start-------------------------------------------------------------------------
// argument must be: ($conn,$tableName,$primaryKeyColumnNameArray,$row,$additionalSpecificRowFunctionArgument)
                                           
function addOrRemove1ToChartFromProductPage($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$row,$additionalSpecificRowFunctionArgument){


    // unpack---
    $userId = $additionalSpecificRowFunctionArgument[0];
    $orderId = $additionalSpecificRowFunctionArgument[1];
    $productIdAndAmountTheUserHaveInCartArray = $additionalSpecificRowFunctionArgument[2]; 
    // $productIdAndAmountTheUserHaveInCartArray[0][0] = first productId that exist in cart for user  
    // $productIdAndAmountTheUserHaveInCartArray[0][1] = amount of the product that have the fist productId that exist in cart for user

    // echo "<br>userId: $userId <br>";
    // echo "<br>userId: $orderId <br>";

    
    // options
    $textOnAddButton = "add";
    $textOnRemoveButton = "remove";
    $valueToAddOrRemove = 1;
    $targetTableName = "itemList";
    $targetColumn = "amount";
    $productIdValue = $row[$primaryKeyColumnNameArray[0]];
    $targetSqlCondition =  "userId = $userId And orderId = $orderId And productId = $productIdValue";
    $columnsUsedInSqlForInsert = "(userId, orderId, productId, amount)";
    $valuesUsedInSqlForInsert = "($userId, $orderId, $productIdValue, $valueToAddOrRemove)";


    // get if productId exist in cart, if true get amount 
    $booleanProductIdExistInCart = false;
    $amount = 0;
    foreach ($productIdAndAmountTheUserHaveInCartArray as $idAndAmount) {
        $productIdTmp = $idAndAmount[0];
        $amountTmp = $idAndAmount[1];
        // echo "<br>productId: $productIdTmp <br>";
        // echo "<br>amount in cart: $amountTmp <br>";

        if($productIdValue == $idAndAmount[0]){
            $booleanProductIdExistInCart = true;
            $amount = $idAndAmount[1];
            break;
        }
    }
    // echo "<br>amount: $amount <br>";    

    // echo $amount;


    // get unique names
    $columnName = "dummy";
    $uniqueNameString = getUniqueNameString($tableName,$primaryKeyColumnNameArray,$columnName,$row);
    $uniqueNameStringAdd = "add".$uniqueNameString."addOrRemove1ToChartFromProductPage";
    $uniqueNameStringRemove = "remove".$uniqueNameString."addOrRemove1ToChartFromProductPage";
    $uniqueNameStringNumber = "number".$uniqueNameString."addOrRemove1ToChartFromProductPage";


    // add button-----------------------------------------------------------------------------------------------------------------------
    echo "<form method=\"POST\">";
        echo "<input type=\"submit\" name=\"";
        echo $uniqueNameStringAdd;
        echo "\" value=\"".$textOnAddButton."\">"; 
    echo "</form>";

    if(isset($_POST[$uniqueNameStringAdd])){
        unset($_POST[$uniqueNameStringAdd]);

        if($booleanProductIdExistInCart == true){

            if($amount<1){
                $sql = "UPDATE $targetTableName SET $targetColumn = $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
            }
            else{
                $sql = "UPDATE $targetTableName SET $targetColumn = $targetColumn + $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
            }            
        }
        else{
            $sql = "INSERT INTO $targetTableName $columnsUsedInSqlForInsert VALUES $valuesUsedInSqlForInsert".";";
        }
        mysqli_query($conn,$sql);
        header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
        exit;
    }

    // remove button and number box ---------------------------------------------------------------------------------------------------
    if($booleanProductIdExistInCart == true){

        echo "<form method=\"POST\">";
            
            // echo "<br>";            
            echo "<input type=\"number\" name=\"";
            echo $uniqueNameStringNumber;
            echo "\" value=\"".$amount."\">";

            echo "<br>";
            echo "<input type=\"submit\" name=\"";
            echo $uniqueNameStringRemove;
            echo "\" value=\"".$textOnRemoveButton."\">";
            
        echo "</form>";


        if(isset($_POST[$uniqueNameStringRemove])){
            unset($_POST[$uniqueNameStringRemove]);

            $amountInNumberBox = $_POST[$uniqueNameStringNumber];
            if($amountInNumberBox == $amount){
                
                if($valueToAddOrRemove<$amount){
                    $sql = "UPDATE $targetTableName SET $targetColumn = $targetColumn - $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
                }
                else{
                    $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";
                }
            }
            else{
                if(0<$amountInNumberBox){
                    $sql = "UPDATE $targetTableName SET $targetColumn = $amountInNumberBox WHERE ".$targetSqlCondition.";";
                }
                else{
                    $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";
                }                
            }
            mysqli_query($conn,$sql);
            header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
            exit;
        }
    }
    


    

    //*/    
}


function deleteRow($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$row,$additionalSpecificRowFunctionArgument){
    $columnName = "dummy";
    $uniqueNameString = getUniqueNameString($tableName,$primaryKeyColumnNameArray,$columnName,$row);
    $uniqueNameStringDelete = "delete".$uniqueNameString."deleteRow";


    
    echo "<form method=\"POST\">";
        
        echo "<input type=\"submit\" name=\"";
        echo $uniqueNameStringDelete;
        echo "\" value=\""."delete"."\">";

    echo "</form>";

    if(isset($_POST[$uniqueNameStringDelete])){
        unset($_POST[$uniqueNameStringDelete]);

        $size = count($primaryKeyColumnNameArray);
        $primaryKeyColumnName = $primaryKeyColumnNameArray[0];
        $tmp = $row[$primaryKeyColumnNameArray[0]];
        $sqlCondition = "$primaryKeyColumnName =  $tmp ";
        echo "<br>before for loop<br>";
        for($i=1;$i<$size;$i++){
            $primaryKeyColumnName = $primaryKeyColumnNameArray[$i];
            $tmp = $row[$primaryKeyColumnNameArray[$i]];
            $sqlCondition = $sqlCondition."AND $primaryKeyColumnName = $tmp ";
        }
        echo "<br>after for loop<br>";

        $sql = "DELETE FROM $tableName  WHERE ".$sqlCondition.";";
        echo "<br>after for sql<br>";
        mysqli_query($conn,$sql);
        echo "<br>after query <br>";
        header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
        exit;
    }

}


// rowFunctions stop-------------------------------------------------------------------------



function showTableHeader($columnNameToShowArray){
    foreach ($columnNameToShowArray as $columnName) {
        echo "<th>";
        echo $columnName;
        echo "</th>";
    }
}


function showDataInsideTable($conn,$redirectToString,$tableName,$booleanLoadHoleTable,$sqlForTable,$primaryKeyColumnNameArray,$columnNameToShowArray,$columnNameToTreatAsImageArray,$columnFunctionName,$additionalSpecificColumnFunctionArgument,$booleanRunRowFunction,$rowFunctionName,$additionalSpecificRowFunctionArgument){


    /*
    echo "<tr>";
    showTableHeader($columnNameToShowArray);
    echo "</tr>";
    */

    if($booleanLoadHoleTable == true){
        $sql = "SELECT * FROM $tableName;";
    }
    else{
        $sql = $sqlForTable;
    }

    $sqlQueryResult = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_assoc($sqlQueryResult))
    {
        echo "<tr>";
        foreach ($columnNameToShowArray as $columnName) {
            echo "<td>";
            $booleanTreatAsImage = false;
            foreach ($columnNameToTreatAsImageArray as $columnNameToTreatAsImage) {
                if($columnNameToTreatAsImage == $columnName){
                    $booleanTreatAsImage = true;
                    break;
                }
            }
            $columnFunctionName($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$columnName,$booleanTreatAsImage,$row,$additionalSpecificColumnFunctionArgument);            
            echo "</td>";
        }

        if($booleanRunRowFunction == true){
            echo "<td>";
            $rowFunctionName($conn,$redirectToString,$tableName,$primaryKeyColumnNameArray,$row,$additionalSpecificRowFunctionArgument);            
            echo "</td>";
        }
        echo "</tr>";
    }
}



// specific functions start-------------------------------------------------------------------------------------------------------------------------


// specific functions for productsForMembers.php start --------------------------------------------------



function showDataInsideTableSpecificForProductsForMember($conn,$userId,$orderId){

    // $conn             
    $redirectToString = "productsForMember.php";
    $tableName = "products";
    $booleanLoadHoleTable = true;
    $sqlForTable = "dummy";
    $primaryKeyColumnNameArray = array("productId");
    $columnNameToShowArray = array("name","info","image");
    $columnNameToTreatAsImageArray = array("image");
    $columnFunctionName = "showSimple";
    $additionalSpecificColumnFunctionArgument = "dummy";
    $booleanRunRowFunction = true;
    $rowFunctionName = "addOrRemove1ToChartFromProductPage";
    $additionalSpecificRowFunctionArgument = array();
        /*
        // unpack---
        $userId = $additionalSpecificRowFunctionArgument[0];
        $orderId = $additionalSpecificRowFunctionArgument[1];
        $productIdAndAmountTheUserHaveInCartArray = $additionalSpecificRowFunctionArgument[2]; 
        // $productIdAndAmountTheUserHaveInCartArray[0][0] = first productId that exist in cart for user  
        // $productIdAndAmountTheUserHaveInCartArray[0][1] = amount of the product that have the fist productId that exist in cart for user
        */
        $additionalSpecificRowFunctionArgument[] = $userId;
        $additionalSpecificRowFunctionArgument[] = $orderId;
            $sql = "SELECT productId, amount FROM itemList WHERE orderId = $orderId AND userId = $userId;";
            $sqlQueryResult = mysqli_query($conn,$sql);
            $arrayTmp = array();
            while ($row = mysqli_fetch_assoc($sqlQueryResult))
            {
                $tmp = array();
                $tmp[] = $row["productId"];
                $tmp[] = $row["amount"];
                $arrayTmp[] = $tmp;
            }
    $additionalSpecificRowFunctionArgument[] = $arrayTmp;

    echo "<tr>";
    showTableHeader($columnNameToShowArray);
    echo "</tr>";

    showDataInsideTable($conn,$redirectToString,$tableName,$booleanLoadHoleTable,$sqlForTable,$primaryKeyColumnNameArray,$columnNameToShowArray,$columnNameToTreatAsImageArray,$columnFunctionName,$additionalSpecificColumnFunctionArgument,$booleanRunRowFunction,$rowFunctionName,$additionalSpecificRowFunctionArgument);    
}





// specific functions for productsForMembers.php stop --------------------------------------------------



// specific functions for membersCart.php start --------------------------------------------------


function showDataInsideTableSpecificForMemberCart($conn,$userId,$orderId){

    // $conn             
    $redirectToString = "memberCart.php";
    $tableName = "itemList";
    $booleanLoadHoleTable = false;
    $sqlForTable = "SELECT listId, productId, amount FROM itemList WHERE orderId = $orderId AND userId = $userId;";
    $primaryKeyColumnNameArray = array("listId");
    $columnNameToShowArray = array("productId","amount");
    $columnNameToTreatAsImageArray = array("dummy"); // it will asume the name "image", the column function
    $columnFunctionName = "showCartForMember";
    $additionalSpecificColumnFunctionArgument = array();
        //$userId = $additionalSpecificColumnFunctionArgument[0];
        //$orderId = $additionalSpecificColumnFunctionArgument[1];
        $additionalSpecificColumnFunctionArgument[0] = $userId;
        $additionalSpecificColumnFunctionArgument[1] = $orderId;

    $booleanRunRowFunction = true;
    $rowFunctionName = "deleteRow";
    $additionalSpecificRowFunctionArgument = array();

    echo "<tr>";
    showTableHeader(array("name","info","image")); // wy this header: special columnFunction that show part of productTable
    echo "</tr>";
        
    showDataInsideTable($conn,$redirectToString,$tableName,$booleanLoadHoleTable,$sqlForTable,$primaryKeyColumnNameArray,$columnNameToShowArray,$columnNameToTreatAsImageArray,$columnFunctionName,$additionalSpecificColumnFunctionArgument,$booleanRunRowFunction,$rowFunctionName,$additionalSpecificRowFunctionArgument);    
}






// specific functions for membersCart.php stop --------------------------------------------------



// specific functions for merer orders start --------------------------------------------------





// specific functions for merer orders stop --------------------------------------------------



// link buttons etc------------------------------

// from product side-----------
function goToMemberCartButton($conn){
    $textOnButton = "Cart";
    $redirectToString = "memberCart.php";
    goToButton($conn,$textOnButton,$redirectToString);
}
function goToMemberAcountButton($conn){
    $textOnButton = "Acount";
    $redirectToString = "memberAcount.php";
    goToButton($conn,$textOnButton,$redirectToString);
}



// from cart side---------- 
/*
function goToProductsForMemberButton($conn){
    $textOnButton = "Products";
    $redirectToString = "productsForMember.php";
    goToButton($conn,$textOnButton,$redirectToString);
}
function goToPayButton($conn){
    $textOnButton = "Pay";
    $redirectToString = "";
    goToButton($conn,$textOnButton,$redirectToString);
}
function goToMemberOrderButton($conn){
    $textOnButton = "Orders";
    $redirectToString = "";
    goToButton($conn,$textOnButton,$redirectToString);
}
*/
// specific functions stop-------------------------------------------------------------------------------------------------------------------------







// super user -----------------------------------------------------------------------------------------------------------------------------------







function getTableNames($conn){
    $result = mysqli_query($conn,"SHOW TABLES ");
    $tableNames = array();
    while($table = mysqli_fetch_array($result)) { // go through each row that was returned in $result
        $tableNames[] = $table[0];    // print the table that was returned on that row
    }
    return $tableNames;
}


function showAllTableNames($tableNames){
    echo "<br>";
    echo "tableNames: ";
    foreach ($tableNames as $name) {
        echo $name." ";
    }
    echo "<br>";
    echo "<br>";
}


function getAllColumnNames($conn,$tableName){ // for columns
    $array = array();
    $sqlTmp = "SHOW COLUMNS FROM $tableName;";
    $sqlQueryResult = mysqli_query($conn,$sqlTmp);
    $number = mysqli_num_rows($sqlQueryResult);
    if ($number > 0) {
        while ($tmp = mysqli_fetch_assoc($sqlQueryResult))
        {
            $array[] = $tmp["Field"];
        }
    }
    return $array;  
}

function showOneTableInGodMod($conn,$tableName,$primaryKeyColumnNameArray){

    echo "<br><br>---------------------$tableName in God mod----------------------------------------------------<br><br>";

    echo "<table>";



    // $conn
    $redirectToString = "superAdmin.php";
    // $tableName
    $booleanLoadHoleTable = true;
    $sqlForTable = "dummy";
    //$primaryKeyColumnNameArray
    $columnNameToShowArray = getAllColumnNames($conn,$tableName); 
    $columnNameToTreatAsImageArray = array("image");
    $columnFunctionName = "changeSimple";
    $additionalSpecificColumnFunctionArgument = "dummy";
    $booleanRunRowFunction = true;
    $rowFunctionName = "deleteRow";
    $additionalSpecificRowFunctionArgument = "dummy";


    echo "<tr>";
    showTableHeader($columnNameToShowArray);
    echo "</tr>";

    showDataInsideTable($conn,$redirectToString,$tableName,$booleanLoadHoleTable,$sqlForTable,$primaryKeyColumnNameArray,$columnNameToShowArray,$columnNameToTreatAsImageArray,$columnFunctionName,$additionalSpecificColumnFunctionArgument,$booleanRunRowFunction,$rowFunctionName,$additionalSpecificRowFunctionArgument);    


    echo "</table>";
}


function showAllTablesInGodMod($conn){


    $tableName = "users";
    $primaryKeyColumnNameArray = array("userId");
    showOneTableInGodMod($conn,$tableName,$primaryKeyColumnNameArray);

    $tableName = "products";
    $primaryKeyColumnNameArray = array("productId");
    showOneTableInGodMod($conn,$tableName,$primaryKeyColumnNameArray);
    

    $tableName = "reviews";
    $primaryKeyColumnNameArray = array("reviewId");
    showOneTableInGodMod($conn,$tableName,$primaryKeyColumnNameArray);

    
    $tableName = "itemList";
    $primaryKeyColumnNameArray = array("listId");
    showOneTableInGodMod($conn,$tableName,$primaryKeyColumnNameArray);
    
   
    $tableName = "orders";
    $primaryKeyColumnNameArray = array("orderId","userId");
    showOneTableInGodMod($conn,$tableName,$primaryKeyColumnNameArray);
    

}

function showAllSpecificTables($conn,$userId,$orderId){

}

function runSuperAdmin($conn){



    $tableNames = getTableNames($conn);
    
    showAllTableNames($tableNames);

        // show all tables
    echo "<br><br>all tables in God mod---------------------------------------------<br><br>";

    

    showAllTablesInGodMod($conn);


}






?>