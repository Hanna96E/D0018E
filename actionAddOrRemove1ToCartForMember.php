<?php

include "init.php";
include "functions101.php";
$conn = connect();

$redirectToString = $_REQUEST['redirectToString'];
$formEnum = $_REQUEST['formEnum'];
$orderId = $_REQUEST['orderId'];
$userId = $_REQUEST['userId'];
$productIdValue = $_REQUEST['productIdValue'];
$amountInCart = $_REQUEST['amountInCart'];

$amountInNumberBox = $_POST["amountInNumberBox"];
$amountInNumberBox = hannnas_test_input($amountInNumberBox);



$valueToAddOrRemove = 1;
$targetTableName = "itemList";
$targetColumn = "amount";
$targetSqlCondition =  "userId = $userId And orderId = $orderId And productId = $productIdValue";
$columnsUsedInSqlForInsert = "(userId, orderId, productId, amount)";
$valuesUsedInSqlForInsert = "($userId, $orderId, $productIdValue, $valueToAddOrRemove)";


if($formEnum == 0){
    if(0<$amountInCart){
        $sql = "UPDATE $targetTableName SET $targetColumn = $targetColumn + $valueToAddOrRemove WHERE ".$targetSqlCondition.";";            
    }
    elseif($amountInCart<0){
        $sql = "UPDATE $targetTableName SET $targetColumn = $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
    }
    else{
        $sql = "INSERT INTO $targetTableName $columnsUsedInSqlForInsert VALUES $valuesUsedInSqlForInsert".";";
    }
    mysqli_query($conn,$sql);
    header("Location: $redirectToString", true, 303);
    exit;
}
elseif($formEnum == 1){
    if($amountInNumberBox != $amountInCart){
        if(0<$amountInNumberBox){
            if($amountInCart == 0){
                $sql = "INSERT INTO $targetTableName $columnsUsedInSqlForInsert VALUES ($userId, $orderId, $productIdValue, $amountInNumberBox)".";";       
            }
            else{
                $sql = "UPDATE $targetTableName SET $targetColumn = $amountInNumberBox WHERE ".$targetSqlCondition.";";
            }
        }
        else{
            $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";
        }

    }
}
elseif($formEnum == 2){
    if($valueToAddOrRemove<$amountInCart){
        $sql = "UPDATE $targetTableName SET $targetColumn = $targetColumn - $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
    }
    else{
        $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";    
    }
}
else{    
    echo "formEnum is wrong!!!!!!!!!";
}
mysqli_query($conn,$sql);
header("Location: $redirectToString", true, 303);
exit;
            

disconnect($conn);

?>
