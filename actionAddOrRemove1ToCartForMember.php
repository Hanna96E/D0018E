<?php

include "init.php";
include "functions101.php";
$conn = connect();




$redirectToString = $_REQUEST['redirectToString'];
$formEnum = $_REQUEST['formEnum'];
$userId = $_REQUEST['userId'];
$orderId = $_REQUEST['orderId'];
$productIdValue = $_REQUEST['productIdValue'];
$amountInCart = $_REQUEST['amountInCart'];





$valueToAddOrRemove = 1;
$targetTableName = "itemList";
$targetColumn = "amount";
$targetSqlCondition =  "userId = $userId And orderId = $orderId And productId = $productIdValue";
$columnsUsedInSqlForInsert = "(userId, orderId, productId, amount,price)";
$valuesUsedInSqlForInsert = "($userId, $orderId, $productIdValue, $valueToAddOrRemove,700)";



$amount=0;
$sql = "SELECT * FROM products WHERE productId = $productIdValue;";
$sqlQueryResult = mysqli_query($conn,$sql);
if($rowTmp = mysqli_fetch_assoc($sqlQueryResult))
{
    $amount = $rowTmp["amount"];
}

if(0<$amount){
    if($formEnum == 0){ // add button
        if(0<$amountInCart){
            if(($amountInCart+$valueToAddOrRemove)<=$amount){
                $sql = "UPDATE $targetTableName SET $targetColumn = $targetColumn + $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
            }
            else{
                $sql = "UPDATE $targetTableName SET $targetColumn = $amount WHERE ".$targetSqlCondition.";";   
            }
        }
        elseif($amountInCart<0){
            if(($valueToAddOrRemove)<=$amount){
                $sql = "UPDATE $targetTableName SET $targetColumn = $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
            }
        }
        else{
            if(($valueToAddOrRemove)<=$amount){
                $sql = "INSERT INTO $targetTableName $columnsUsedInSqlForInsert VALUES $valuesUsedInSqlForInsert".";";
            }
        }
    }
    elseif($formEnum == 1){ // number box

        $amountInNumberBox = $_POST["amountInNumberBox"];
        $amountInNumberBox = hannnas_test_input($amountInNumberBox);


        if(0<$amountInNumberBox){
            if(0<$amountInCart){
                if($amount<=$amountInNumberBox){
                    $sql = "UPDATE $targetTableName SET $targetColumn = $amount WHERE ".$targetSqlCondition.";";
                }
                else{
                    $sql = "UPDATE $targetTableName SET $targetColumn = $amountInNumberBox WHERE ".$targetSqlCondition.";";
                } 
            }
            else{

                if($amount<=$amountInNumberBox){
                    $sql = "INSERT INTO $targetTableName $columnsUsedInSqlForInsert VALUES ($userId, $orderId, $productIdValue, $amount)".";";
                }
                else{
                    $sql = "INSERT INTO $targetTableName $columnsUsedInSqlForInsert VALUES ($userId, $orderId, $productIdValue, $amountInNumberBox)".";";
                }    
        
            }
        }
        else{
            $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";    
        }
    }
    elseif($formEnum == 2){ // romove button
        if($valueToAddOrRemove<$amountInCart){
            if($amount<($amountInCart-$valueToAddOrRemove)){
                $sql = "UPDATE $targetTableName SET $targetColumn = $amount WHERE ".$targetSqlCondition.";";    
            }
            else{
                $sql = "UPDATE $targetTableName SET $targetColumn = $targetColumn - $valueToAddOrRemove WHERE ".$targetSqlCondition.";";
            }
        }
        else{
            $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";    
        }
    }
    else{    
        echo "formEnum is wrong!!!!!!!!!";
    }

}
else{
        $sql = "DELETE FROM $targetTableName WHERE ".$targetSqlCondition.";";
}
mysqli_query($conn,$sql);
header("Location: $redirectToString", true, 303);
exit;

            

disconnect($conn);

?>
