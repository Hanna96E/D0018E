<?php

// connection start-----------------------------------------------------------------------------------------------------------

function connect(){
	$servername = "localhost";
	$username = "gb";
	$password = "Arrug96.";
	$dbname = "shopDB";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	return $conn;
}


function disConnect($conn){
	mysqli_close($conn);
}

// connection stop -----------------------------------------------------------------------------------------------------------



// functions used by templates-ish start -----------------------------------------------------------------------------------


// programing help functions start -----------------------------------------------------------------------------------------------------------

function getPrimaryKeyColumnNameArray($conn,$tableName){ // ops!!!!!!!!! denna function måsta kollas över och förstå den
	// "SELECT * FROM products";//
	$sql =  "SHOW KEYS FROM $tableName WHERE Key_name = 'PRIMARY' "; // https://stackoverflow.com/questions/2341278/how-to-get-primary-key-of-table
	$sqlQueryResult = mysqli_query($conn,$sql);
	$number = mysqli_num_rows($sqlQueryResult);
	$a = mysqli_fetch_array($sqlQueryResult);
	
	if(false){
		echo "a: ".$a."<br>";
		echo "a[0]: ".$a[0]."<br>";
		echo "a[1]: ".$a[1]."<br>";
		echo "a[2]: ".$a[2]."<br>";
		echo "a[3]: ".$a[3]."<br>";
		echo "a[4]: ".$a[4]."<br>";
		echo "a[5]: ".$a[5]."<br>";
		echo "a[6]: ".$a[6]."<br>";
		echo "a[7]: ".$a[7]."<br>";
		echo "a[8]: ".$a[8]."<br>";
		echo "a[9]: ".$a[9]."<br>";
		echo "a[10]: ".$a[10]."<br>";
		echo "a[11]: ".$a[11]."<br>";
		echo "a[12]: ".$a[12]."<br>";
		echo "a[13]: ".$a[13]."<br>";
		echo "a[14]: ".$a[14]."<br>";
		echo "a[15]: ".$a[15]."<br>";
		echo "a[16]: ".$a[16]."<br>";
		echo "a[17]: ".$a[17]."<br>";
		echo "a[18]: ".$a[18]."<br>";
		echo "a[19]: ".$a[19]."<br>";
		echo "a[20]: ".$a[20]."<br>";
		echo "a[21]: ".$a[21]."<br>";
		echo "a[22]: ".$a[22]."<br>";
		echo "a[23]: ".$a[23]."<br>";
		echo "a[24]: ".$a[24]."<br>";
		echo "a[25]: ".$a[25]."<br>";
		echo "a[26]: ".$a[26]."<br>";
		echo "a[27]: ".$a[27]."<br>";
		echo "a[28]: ".$a[28]."<br>";
		echo "a[29]: ".$a[29]."<br>";
	}

	return $a[4];     
}


function getArrayFromSql($conn,$sqlTmp){ // for row
	$array = array();
	$sqlQueryResult = mysqli_query($conn,$sqlTmp);
	$number = mysqli_num_rows($sqlQueryResult);
	if ($number > 0) {
        while ($tmp = mysqli_fetch_assoc($sqlQueryResult))
        {
            $array[] = $tmp;
        }
    }
    return $array;
}

function getArrayFieldFromSql($conn,$sqlTmp){ // for columns
	$array = array();
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

// programing help functions stop -----------------------------------------------------------------------------------------------------------

// specialFunction1 start ----------------------------------------------------------------------------------------
// argument must be: ($formOutputArray, $additionalAgrumentArray)

function change($formOutputArray, $additionalAgrumentArray){
	$valueToSet = $formOutputArray[0];
	$conn = $additionalAgrumentArray[0];
	$tableName = $additionalAgrumentArray[1];
	$setColumnName = $additionalAgrumentArray[2];
	$sqlConditionIncluding_WHERE = $additionalAgrumentArray[3];

	$sql = "UPDATE $tableName SET $setColumnName = $value ".$sqlConditionIncluding_WHERE;
    mysqli_query($conn,$sql);
}

function change($formOutputArray, $additionalAgrumentArray){
	$valueToSet = $formOutputArray[0];
	$conn = $additionalAgrumentArray[0];
	$tableName = $additionalAgrumentArray[1];
	$setColumnName = $additionalAgrumentArray[2];
	$sqlConditionIncluding_WHERE = $additionalAgrumentArray[3];

	$sql = "UPDATE $tableName SET $setColumnName = $setColumnName + $value ".$sqlConditionIncluding_WHERE;
    mysqli_query($conn,$sql);
}


// specialFunction1 stop ----------------------------------------------------------------------------------------

// specialFormFunction1 start -----------------------------------------------------------------------------------
// at least these arguments must exist: ($uniqueNameString,$redirectToString,$specialFunction1Name,$specialFunction1ArgumentArray) 
// possibly some more constraints

function formFunctionButton($uniqueNameString,$redirectToString,$specialFunction1Name,$specialFunction1ArgumentArray,$textOnButton){

	echo "<form method=\"POST\">";
		echo "<input type=\"submit\" name=\"";
		echo $uniqueNameString;
		echo "\" value=\"".$textOnButton."\">";	
	echo "</form>";

    if(isset($_POST[$uniqueNameString])){
		unset($_POST[$uniqueNameString]);

		$formOutputArray = array();

		$specialFunction1Name($formOutputArray, $additionalAgrumentArray);
	    // can be redirect to the page itself
		header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
		exit;
    }
}

function formFunctionStringInputWithSubmitButton($uniqueNameString,$redirectToString,$specialFunction1Name,$specialFunction1ArgumentArray,$textOnSubmitButton,$placeHolder){ // ops!!!!! specialFunction must be a specialFunction  
	// specialFunction(conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue)



	$uniqueNameStringOnTextInput = $uniqueNameString."textInput";
	$uniqueNameStringOnSubmitButton = $uniqueNameString."submitButton";

	echo "<form method=\"POST\">";

		echo "<input type=\"text\" name=\"";
		echo $uniqueNameStringOnTextInput;
		echo "\" placeholder=\"".$placeHolder."\">";


		echo "<input type=\"submit\" name=\"";
		echo $uniqueNameStringOnSubmitButton;
		echo "\" value=\"".$textOnSubmitButton."\">";

	echo "</form>";

    if(isset($_POST[$uniqueNameStringOnSubmitButton])){
		unset($_POST[$uniqueNameStringOnSubmitButton]);
		
		$formOutputArray = array();
		$formOutputArray[] = $_POST[$uniqueNameStringOnTextInput];
		
		$specialFunction1Name($formOutputArray, $additionalAgrumentArray);
	    

		header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
		exit;
    }
}




// specialFormFunction1 stop -----------------------------------------------------------------------------------


// other functions start ------------------------------------------------------------------------------------------------
// no constraints



function showObjectSimple($object){
	echo $object;
}
function showObjectSimpleAsImage($image){
	echo "<img src= \"". $image. "\" style= \"width:50px;height:50px;\">"; 
}



// other functions stop ------------------------------------------------------------------------------------------------



// functions used by templates-ish start -----------------------------------------------------------------------------------

function getSpecificMultiArray1($conn, $arrayTableSpecification){

	// define the data (unnecesary???????)-------------------------

	$arrayOfTableName = array();
    $arrayOfprimaryKeyColumnNameArray = array();
    $arrayOfTableRowArray = array();
    $arrayOfNuberOfRows = array();
    $arrayOfShowColumnNameArray = array();
    $arrayOfNumberOfShowColumns = array();


    $arrayOfBooleanRunRowFunction = array();
    $arrayOfRowFunctionName = array();
    $arrayOfRowFunctionAdditionalArgumentArray = array();

  	
    $arrayOfColumnFunctionName = array();
    $arrayOfColumnFunctionAdditionalArgumentArray = array();


    // set the data------------------------------------------------
    foreach ($arrayTableSpecification as $tableSpecification) {

    	// make it more readable start --------
			
			// table name
			$tableName = $tableSpecification[0];

			// table input	
			$booleanLoadInHoleTable = $tableSpecification[1];
			$booleanUseSqlForTableData = $tableSpecification[2];
			$sqlForTable = $tableSpecification[3];
			$booleanUseColumnNameArrayForTableData = $tableSpecification[4];
			$columnNameArrayForTableData = $tableSpecification[5];

			// columns to show
			$booleanUseAllColumnsForShow = $tableSpecification[6];
			$booleanUseSqlForColumnsForShow = $tableSpecification[7];
			$sqlForColumnsForShow = $tableSpecification[8];
			$booleanUseColumnNameArrayForShow = $tableSpecification[9];
			$columnNameArrayForShow = $tableSpecification[10];	
			
			// $columnFunction 
		    $columnFunctionName = $tableSpecification[11];
		    $columnFunctionAdditionalArgumentArray = $tableSpecification[12]; 

		    // rowFunction
		    $booleanRunRowFunction = $tableSpecification[13];
		    $rowfunctionName = $tableSpecification[14]; 
		    $rowFunctionAdditionalArgumentArray = $tableSpecification[15];  

    	// make it more readable stop ---------

	    $arrayOfTableName[] = $tableName;

	    $arrayOfprimaryKeyColumnNameArray[] = getPrimaryKeyColumnNameArray($conn,$tableName);

	    
	    // Get row array---------------------------------------------------------  
	    $rowArray = array();
	    $booleanTmp = false;
	    if($booleanUseColumnNameArrayForTableData == true){
	    	$sizeTmp = count($columnNameArrayForTableData);

	    	$sqlTmp = $columnNameArrayForTableData[0];
	    	for ($iTmp=1; $iTmp < $sizeTmp; $iTmp++) { 
	    		$sqlTmp = $sqlTmp.", ".$columnNameArrayForTableData[$iTmp];
	    	}
	    	$sqlTmp = "SELECT ".$sqlTmp." FROM $tableName;";

	    	$booleanTmp = true;
	    }	
    	elseif($booleanLoadInHoleTable == true){
	    	$sqlTmp = "SELECT * FROM $tableName;";
	    	$booleanTmp = true; 
	    }
	    elseIf($booleanUseSqlForTableData == true){
	    	$sqlTmp = $sqlForTable;
	    	$booleanTmp = true;
	    }
	    if($booleanTmp == true){
		    	$rowArray = getArrayFromSql($conn,$sqlTmp);	
		}
		else{
    		echo "no table data chosen !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
		}
	    $arrayOfTableRowArray[] = $rowArray;
	    $arrayOfNuberOfRows[] = count($rowArray);




	    // get columnName array 
	    $columnNameArray = array();
	    if($booleanUseColumnNameArrayForShow == true){
			$columnNameArray = $columnNameArrayForShow;
	    }
	    else{

	    	$booleanTmp = false;
	    	if($booleanUseAllColumnsForShow == true){
	    		$sqlTmp = "SHOW COLUMNS FROM $tableName;";
	    		$booleanTmp = true;
		    }
		    elseIf($booleanUseSqlForColumnsForShow == true){
		    	$sqlTmp = $sqlForColumnsForShow;
		    	$booleanTmp = true;
		    }

		    if($booleanTmp == true){
		    	$columnNameArray = getArrayFromSql($conn,$sqlTmp);	
			}
			else{
	    		echo "no table columns for show chosen !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
	    	}
	    }
	    $arrayOfShowColumnNameArray[] = $columnNameArray;
	    $arrayOfNumberOfShowColumns[] = count($columnNameArray); 


	    $arrayOfBooleanRunRowFunction[] = $booleanRunRowFunction;
	    $arrayOfRowFunctionName[] = $rowfunctionName;
	    $arrayOfRowFunctionAdditionalArgumentArray[] = $rowFunctionAdditionalArgumentArray;

	  	
	    $arrayOfColumnFunctionName[] = $columnFunctionName;
	    $arrayOfColumnFunctionAdditionalArgumentArray[] = $columnFunctionAdditionalArgumentArray;
    
    }


    // set all arrayVariables in one array and return
    $specificMultiArray1 = array(
		$arrayOfTableName,
	    $arrayOfprimaryKeyColumnNameArray,
	    $arrayOfTableRowArray,
	    $arrayOfNuberOfRows,
	    $arrayOfShowColumnNameArray,
	    $arrayOfNumberOfShowColumns,
	    $arrayOfBooleanRunRowFunction,
	    $arrayOfRowFunctionName,
	    $arrayOfRowFunctionAdditionalArgumentArray,
	    $arrayOfColumnFunctionName,
	    $arrayOfColumnFunctionAdditionalArgumentArray
	);

    return $specificMultiArray1;
}

// functions used by templates-ish stop -----------------------------------------------------------------------------------


// templates-ish start ------------------------------------------------------------------------------------------------------

function exampleHowToUseSpecificMultiArray1($conn){

	// table name
	$tableName = "products";

	// table input	
	$booleanLoadInHoleTable = true;
	$booleanUseSqlForTableData = false;
	$sqlForTable = "SELECT * FROM products;";
	$booleanUseColumnNameArrayForTableData = false;
	$columnNameArrayForTableData = array("id","name","amount","image");

	// columns to show
	$booleanUseAllColumnsForShow = true;
	$booleanUseSqlForColumnsForShow = false;
	$sqlForColumnsForShow = "SHOW COLUMNS FROM products;";
	$booleanUseColumnNameArrayForShow = false;
	$columnNameArrayForShow = array("name","image");	
	
	// $columnFunction 
    $columnFunctionName = "showSimple"; // or changeSimple or som other columnFunction
    $columnFunctionAdditionalArgumentArray = array(); // perhaps some input in the array depending on columnFunctionName 

    // rowFunction
    $booleanRunRowFunction = true;
    $rowfunctionName = "addOrRemoveButton"; 
    $rowFunctionAdditionalArgumentArray = array(); // perhaps some input in the array depending on RowfunctionName  

	// make array of it
    $tableSpecification1 = array($tableName,$booleanLoadInHoleTable,$booleanUseSqlForTableData,$sqlForTable,$booleanUseColumnNameArrayForTableData,$columnNameArrayForTableData,$booleanUseAllColumnsForShow,$booleanUseSqlForColumnsForShow,$sqlForColumnsForShow,$booleanUseColumnNameArrayForShow,$columnNameArrayForShow,$columnFunctionName,$columnFunctionAdditionalArgumentArray,$booleanRunRowFunction,$rowfunctionName,$rowFunctionAdditionalArgumentArray);

    // repeat if one want



	// table name
	$tableName = "products";

	// table input	
	$booleanLoadInHoleTable = true;
	$booleanUseSqlForTableData = false;
	$sqlForTable = "SELECT * FROM products";
	$booleanUseColumnNameArrayForTableData = false;
	$columnNameArrayForTableData = array("id","name","amount","image");

	// columns to show
	$booleanUseAllColumnsForShow = true;
	$booleanUseSqlForColumnsForShow = false;
	$sqlForColumnsForShow = "SHOW COLUMNS FROM products";
	$booleanUseColumnNameArrayForShow = false;
	$columnNameArrayForShow = array("name","image");	
	
	// $columnFunction 
    $columnFunctionName = "showSimple"; // or changeSimple or som other columnFunction
    $columnFunctionAdditionalArgumentArray = array(); // perhaps some input in the array depending on columnFunctionName 

    // rowFunction
    $booleanRunRowFunction = true;
    $rowfunctionName = "addOrRemoveButton"; 
    $rowFunctionAdditionalArgumentArray = array(); // perhaps some input in the array depending on RowfunctionName  

	// make array of it
    $tableSpecification2 = array($tableName,$booleanLoadInHoleTable,$booleanUseSqlForTableData,$sqlForTable,$booleanUseColumnNameArrayForTableData,$columnNameArrayForTableData,$booleanUseAllColumnsForShow,$booleanUseSqlForColumnsForShow,$sqlForColumnsForShow,$booleanUseColumnNameArrayForShow,$columnNameArrayForShow,$columnFunctionName,$columnFunctionAdditionalArgumentArray,$booleanRunRowFunction,$rowfunctionName,$rowFunctionAdditionalArgumentArray);




    // the variables inside a new variable
    $arrayTableSpecification = array();
    $arrayTableSpecification[] = $tableSpecification1;
    $arrayTableSpecification[] = $tableSpecification2;

    $specificMultiArray1 = getSpecificMultiArray1($conn, $arrayTableSpecification);

}

// templates-ish stop ------------------------------------------------------------------------------------------------------




// columnFunctions start -------------------------------------------------------------------------------------------------------
// all columnFunctions must have this function argument: ($conn,$tableName,$primaryKeyColumnNameArray,$row,$showColumnName,$object,$columnFunctionAdditionalArgumentArray)

function showSimple($conn,$tableName,$primaryKeyColumnNameArray,$row,$showColumnName,$object,$columnFunctionAdditionalArgumentArray){
	if($showColumnName == "image"){
		showObjectSimpleAsImage($object);
	}
	else{
		showObjectSimple($object);
	}
}
function changeSimple($conn,$tableName,$primaryKeyColumnNameArray,$row,$showColumnName,$object,$columnFunctionAdditionalArgumentArray){
	if($showColumnName == "image"){
		showObjectSimpleAsImage($object);
		echo "<br>";
		showObjectSimple($object);
		echo "<br>";
	}
	else{
		showObjectSimple($object);
		echo "<br>";
	}
	



	$uniqueNameString

	$redirectToString = "run1.php";
	$specialFunction1Name = "";
	$specialFunction1ArgumentArray = $columnFunctionAdditionalArgumentArray[2];
	$textOnSubmitButton = $columnFunctionAdditionalArgumentArray[3];
	$placeHolder = $columnFunctionAdditionalArgumentArray[4]; 

	formFunctionStringInputWithSubmitButton($uniqueNameString,$redirectToString,$specialFunction1Name,$specialFunction1ArgumentArray,$textOnSubmitButton,$placeHolder);
}

// columnFunctions stop -------------------------------------------------------------------------------------------------------




// rowFunctions start -------------------------------------------------------------------------------------------------------
// all rowFunctions must have this function argument: ($conn,$tableName,$primaryKeyColumnNameArray,$row,$rowFunctionAdditionalArgumentArray)




// rowFunctions stop -------------------------------------------------------------------------------------------------------



function showTableHeader($showColumnNameArray){
	foreach ($showColumnNameArray as $columnName) {
    	echo "<th>";
		showObjectSimple($columnName);
	    echo "</th>";
	}
}

function showRow($conn,$tableName,$primaryKeyColumnNameArray,$row,$showColumnNameArray, $columnFunctionName, $columnFunctionAdditionalArgumentArray){

	foreach ($showColumnNameArray as $showColumnName) {
		echo "<td>";
		$object = $row[$showColumnName];
		$columnFunctionName($conn,$tableName,$primaryKeyColumnNameArray,$row,$showColumnName,$object,$columnFunctionAdditionalArgumentArray);

		echo "</td>";
	}
}


function showTableSuperGeneral($conn,$specificMultiArray1){
	// unpack--
	$arrayOfTableName = $specificMultiArray1[0];
    $arrayOfprimaryKeyColumnNameArray = $specificMultiArray1[1];
    $arrayOfTableRowArray = $specificMultiArray1[2];
    $arrayOfNuberOfRows  = $specificMultiArray1[3];
    $arrayOfShowColumnNameArray = $specificMultiArray1[4];
    $arrayOfNumberOfShowColumns = $specificMultiArray1[5];


    $arrayOfBooleanRunRowFunction = $specificMultiArray1[6];
    $arrayOfRowFunctionName = $specificMultiArray1[7];
    $arrayOfRowFunctionAdditionalArgumentArray = $specificMultiArray1[8];

  	
    $arrayOfColumnFunctionName = $specificMultiArray1[9];
    $arrayOfColumnFunctionAdditionalArgumentArray = $specificMultiArray1[10];



    // table--------------------------------------------------------------------------------------------------------------------------------


    // table header------------------------------------------
	echo "<tr>";
	$i=0;
	foreach ($arrayOfShowColumnNameArray as $showColumnNameArray) {
		showTableHeader($showColumnNameArray);
		if($arrayOfBooleanRunRowFunction[$i]==true){
			echo "<th></th>";
		}
		$i++;
	}
	echo "</tr>";


	// table data------------------------------------------

	$maxNumberOfRows = 0;
	foreach ($arrayOfNuberOfRows as $nuberOfRows) {
		if($nuberOfRows>$maxNumberOfRows){
			$maxNumberOfRows=$nuberOfRows;
		}
	}

	for($rowNumber = 0;$rowNumber<$maxNumberOfRows;$rowNumber++){
		echo "<tr>";
		$i = 0;
		foreach ($arrayOfTableName as $tableName) {
			
		    
			if($rowNumber<$arrayOfNuberOfRows[$i]){
				
				$row = $arrayOfTableRowArray[$i][$rowNumber];
				showRow($conn,$tableName,$arrayOfprimaryKeyColumnNameArray[$i],$row,$arrayOfShowColumnNameArray[$i], $arrayOfColumnFunctionName[$i], $arrayOfColumnFunctionAdditionalArgumentArray[$i]);

				if($arrayOfBooleanRunRowFunction[$i] == true){

				    $rowFunction = $arrayOfRowFunctionName[$i];
				    echo "<td>";
					$rowFunction($conn,$tableName,$arrayOfprimaryKeyColumnNameArray[$i],$row,$arrayOfRowFunctionAdditionalArgumentArray[$i]);
					echo "</td>";
				}

			}
			else{
				for($tmp = 0;$tmp<$numberOfColumns;$tmp++){
					echo "<td>";
					echo "</td>";
				}
			}
			$i++;

		}
		echo "</tr>";
	}
}


?>