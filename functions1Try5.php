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

// programing help functions start -----------------------------------------------------------------------------------------------------------

function getPrimaryKeyColumnNames($conn,$tableName){ // ops!!!!!!!!! denna function måsta kollas över och förstå den
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



// specialFunctions_1 start -----------------------------------------------------------------------------------------------------------
// specialFunctions_1 must have this arguments: ($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue)

function change($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue){
	$sql = "UPDATE $tableName SET $SetcolumnName = $value WHERE $conditionColumnName = $conditionColumnValue;";
    mysqli_query($conn,$sql);
}					
function addAmount($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue){
	$sql = "UPDATE $tableName SET $SetcolumnName = $SetcolumnName + $value WHERE $conditionColumnName = $conditionColumnValue;";
    mysqli_query($conn,$sql);
}

// specialFunctions_1 stop -----------------------------------------------------------------------------------------------------------



// specialFunctions_2 start -----------------------------------------------------------------------------------------------------------
// specialFunctions_2 uses specialFunctions_1.
// specialFunctions_2 must at least have this arguments: ($specialFunction,$conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue)


function functionButton($textOnButton,$uniqueNameString,$redirectToString,$specialFunction,$conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue){ // ops!!!!! specialFunction must be a specialFunction  
	// specialFunction(conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue)
	
	echo "<form method=\"POST\">";
		echo "<input type=\"submit\" name=\"";
		echo $uniqueNameString;
		echo "\" value=\"".$textOnButton."\">";	
	echo "</form>";

    if(isset($_POST[$uniqueNameString])){
		unset($_POST[$uniqueNameString]);
		$specialFunction($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue);
	    // can be redirect to the page itself
		header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
		exit;
    }
}

function functionStringInputWithSubmitButton($textOnSubmitButton,$uniqueNameString,$placeHolder,$redirectToString,$specialFunction,$conn,$tableName,$SetcolumnName,$conditionColumnName,$conditionColumnValue){ // ops!!!!! specialFunction must be a specialFunction  
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
		$value = $_POST[$uniqueNameStringOnTextInput];
		$specialFunction($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue);
	    // can be redirect to the page itself
		header("Location: $redirectToString", true, 303); // "post redirect get" // https://www.phptutorial.net/php-tutorial/php-prg/ 
		exit;
    }
}

// specialFunctions_2 stop -----------------------------------------------------------------------------------------------------------


function AddOrRemoveButtonGeneral($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue){ // has arguments as a special function
	$NameString = "AddOrRemoveButtonGeneral".$tableName.$SetcolumnName.$value.$conditionColumnName.$conditionColumnValue;
	$uniqueAddNameString = "add".$NameString;
	$uniqueRemoveNameString = "remove".$NameString;

	$redirectToString = "run1.php"; // ops!!!!!!!!!!!!!!!!!!!!!!!!
	$specialFunction = "addAmount";
	

	$textOnButton = "add ".$value;
	$uniqueNameString = $uniqueAddNameString;
	functionButton($textOnButton,$uniqueNameString,$redirectToString,$specialFunction,$conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue); 
	
	$value = -$value;
	$textOnButton = "remove ".$value;
	$uniqueNameString = $uniqueRemoveNameString; 
	functionButton($textOnButton,$uniqueNameString,$redirectToString,$specialFunction,$conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue); 
	
}







			   //$function($conn, $sourceColumnName, $row, $targetTableName, $targetColumnName, $targetConditionColumnName);
function addOrRemoveButton($conn, $sourceColumnName, $row, $targetTableName, $targetColumnName, $targetConditionColumnName){ //
// $sql = "UPDATE $targetTableName SET $targetColumnName = $targetColumnName + "some chosen value ($value)" WHERE $targetConditionColumnName = $row[$sourceColumnName];";

	
	$tableName = $targetTableName;
	$SetcolumnName = $targetColumnName;
	$value = 1; // only add 1 or remove 1
	$conditionColumnName = $targetConditionColumnName;
	$conditionColumnValue = $row[$sourceColumnName];
	AddOrRemoveButtonGeneral($conn,$tableName,$SetcolumnName,$value,$conditionColumnName,$conditionColumnValue);
}





function changeWithStringInputWithSubmitButton($conn, $tableName, $columnName, $primaryKeyName, $primaryKeyValue){


	$textOnSubmitButton = "submit change";
	$uniqueNameString = $tableName.$columnName.$primaryKeyName.$primaryKeyValue;
	$placeHolder = "write here";
	$redirectToString = "run1.php"; 
	$specialFunction = "change";
	// $conn  
	// $tableName 
	$SetcolumnName = $columnName;
	$conditionColumnName = $primaryKeyName;
	$conditionColumnValue = $primaryKeyValue;

	functionStringInputWithSubmitButton($textOnSubmitButton,$uniqueNameString,$placeHolder,$redirectToString,$specialFunction,$conn,$tableName,$SetcolumnName,$conditionColumnName,$conditionColumnValue);
}

// showFunctions_1 start -----------------------------------------------------------------------------------------------------------
// visualization of a function, (show,change,etc), on a specific atribute on a specific object.



function showObjectSimple($object){
	echo $object;
}
function showObjectSimpleAsImage($image){
	echo "<img src= \"". $image. "\" style= \"width:50px;height:50px;\">"; 
}


function changeObject($object,$conn, $tableName, $columnName,$primaryKeyName,$primaryKeyValue){

	showObjectSimple($object);
	changeWithStringInputWithSubmitButton($conn, $tableName, $columnName, $primaryKeyName, $primaryKeyValue);
}
function changeImage($image,$conn, $tableName, $columnName,$primaryKeyName,$primaryKeyValue){
	
	showObjectSimpleAsImage($image);
	$object = $image;
	showObjectSimple("<br> image url: <br>");
	showObjectSimple("<br>$object<br>");
	changeWithStringInputWithSubmitButton($conn, $tableName, $columnName, $primaryKeyName, $primaryKeyValue);
}

// showFunctions_1 stop -----------------------------------------------------------------------------------------------------------




// tableFunctions_1 start -----------------------------------------------------------------------------------------------------------
// this functions must assume they are inside a table


function showRow($conn,$tableName,$primaryKeyName,$row,$columnNames,$optionString){
	foreach ($columnNames as $columnName) {
		echo "<td>";

		if($columnName=="image"){
			
			$image = $row['image'];
			if($optionString=="simple"){
				showObjectSimpleAsImage($image);
			}
			elseif($optionString=="change"){

				$primaryKeyValue = $row[$primaryKeyName];

				changeImage($image,$conn, $tableName, $columnName,$primaryKeyName,$primaryKeyValue);
			}
			else{
				echo "unknown optionString";
			}
		}
		else{

			$object = $row[$columnName];
			if($optionString=="simple"){
				showObjectSimple($object);
			}
			elseif($optionString=="change"){
				
				$primaryKeyValue = $row[$primaryKeyName];
				changeObject($object,$conn, $tableName, $columnName,$primaryKeyName,$primaryKeyValue);
			}

		}

		echo "</td>";
	}
}


function showTableHeader($showColumnNameArray){
	foreach ($showColumnNameArray as $columnName) {
    	echo "<th>";
		showObjectSimple($columnName);
	    echo "</th>";
	}
}



// tableFunctions_1 stop -----------------------------------------------------------------------------------------------------------



function getspecificArrayInput($tableName,$primaryKeyName,$booleanUseSqlForTable,$booleanUseAllColumns,$booleanUseSqlForColumns,$sqlForTable,$sqlForColumns,$columnNames,$optionString,$booleanRunFunction,$function,$functionArgumentSourceColumnName,$functionArgumentTargetTableName,$functionArgumentTargetColumnName,$functionArgumentTargetConditionColumnName){
	// A class instead of specificArrayInput would be prefarably but it did not work when I tried it, (it was vary weird)
	/* the class the function tryies to replace
class elementInsideInputToShowTableGeneral
{
	// what to show options:----------------------------
    public $tableName; // is probably sent down to a specialFuntion
    public $primaryKeyName; // the primaryKey in the $tableName
    public $sqlForTable;
    public $booleanUseSqlForTable; // if not true the hole table will be used
    public $sqlForColumns;
    public $booleanUseAllColumns; // if true all columns in $tableName are used
    public $booleanUseSqlForColumns; // if true and $booleanUseAllColumns is false then $sqlForColumns is used. if both are false $arrayOfColumnNames are used
    public $columnNames;
    
    // how to show options:----------------------------
    public $optionString; // how to show it: "simple" means just show, "change" means that you want to change it. possibly more alternatives


    // function options:----------------------------
    public $booleanRunFunction; // if true the function will run
    public $function; // function name. //function must look like this function($conn, $sourceColumnName, $row, $targetTableName, $targetColumnName, $targetConditionColumnName) 
    public $functionArgumentSourceColumnName; // the column name that we possibly are intrested in inside $row 
    public $functionArgumentTargetTableName;
    public $functionArgumentTargetColumnName;
    public $functionArgumentTargetConditionColumnName; // it can for example be used in sql as: ".... WHERE $targetConditionColumnName = $row[$sourceColumnName];"
}
	*/
	return array($tableName,$primaryKeyName,$booleanUseSqlForTable,$booleanUseAllColumns,$booleanUseSqlForColumns,$sqlForTable,$sqlForColumns,$columnNames,$optionString,$booleanRunFunction,$function,$functionArgumentSourceColumnName,$functionArgumentTargetTableName,$functionArgumentTargetColumnName,$functionArgumentTargetConditionColumnName);
}


function testGetArrayOfspecificArrayInput(){
	
	// copy form:
	/*
	$tableName = 
	$primaryKeyName = 
	$booleanUseSqlForTable = 
	$booleanUseAllColumns = 
	$booleanUseSqlForColumns = 
	$sqlForTable = 
	$sqlForColumns = 
	$columnNames = 
	$optionString = 
	$booleanRunFunction = 
	$function = 
	$functionArgumentSourceColumnName = 
	$functionArgumentTargetTableName = 
	$functionArgumentTargetColumnName = 
	$functionArgumentTargetConditionColumnName = 
	$variable1 = getspecificArrayInput($tableName,$primaryKeyName,$booleanUseSqlForTable,$booleanUseAllColumns,$booleanUseSqlForColumns,$sqlForTable,$sqlForColumns,$columnNames,$optionString,$booleanRunFunction,$function,$functionArgumentSourceColumnName,$functionArgumentTargetTableName,$functionArgumentTargetColumnName,$functionArgumentTargetConditionColumnName);
	*/


	$tableName = "products";
	$primaryKeyName = "id";
	$booleanUseSqlForTable = true;
	$booleanUseAllColumns = false;
	$booleanUseSqlForColumns = true;
	$sqlForTable = "SELECT * FROM products";
	$sqlForColumns = "SHOW COLUMNS FROM products";
	$columnNames = array("id","name");
	$optionString = "simple";
	$booleanRunFunction = true; 
	$function = "addOrRemoveButton";
	$functionArgumentSourceColumnName = "id"; 
	$functionArgumentTargetTableName = "products";
	$functionArgumentTargetColumnName = "amount";
	$functionArgumentTargetConditionColumnName = "id";

	$specificArrayInput1 = getspecificArrayInput($tableName,$primaryKeyName,$booleanUseSqlForTable,$booleanUseAllColumns,$booleanUseSqlForColumns,$sqlForTable,$sqlForColumns,$columnNames,$optionString,$booleanRunFunction,$function,$functionArgumentSourceColumnName,$functionArgumentTargetTableName,$functionArgumentTargetColumnName,$functionArgumentTargetConditionColumnName);
//*/	

	$tableName = "products";
	$primaryKeyName = "id";
	$booleanUseSqlForTable = true;
	$booleanUseAllColumns = false;
	$booleanUseSqlForColumns = true;
	$sqlForTable = "SELECT * FROM products";
	$sqlForColumns = "SHOW COLUMNS FROM products";
	$columnNames = array("id","name");
	$optionString = "change";
	$booleanRunFunction = false; 
	$function = "addOrRemoveButton";
	$functionArgumentSourceColumnName = "id"; 
	$functionArgumentTargetTableName = "products";
	$functionArgumentTargetColumnName = "amount";
	$functionArgumentTargetConditionColumnName = "id";
	
	$specificArrayInput2 = getspecificArrayInput($tableName,$primaryKeyName,$booleanUseSqlForTable,$booleanUseAllColumns,$booleanUseSqlForColumns,$sqlForTable,$sqlForColumns,$columnNames,$optionString,$booleanRunFunction,$function,$functionArgumentSourceColumnName,$functionArgumentTargetTableName,$functionArgumentTargetColumnName,$functionArgumentTargetConditionColumnName);

	$ArrayOfspecificArrayInput = array();
	$ArrayOfspecificArrayInput[] = $specificArrayInput1;
	$ArrayOfspecificArrayInput[] = $specificArrayInput2;

	return $ArrayOfspecificArrayInput;


}

function getSpecialMultiArray1($conn,$ArrayOfspecificArrayInput){ // if adding somthing to $specificMultiArray1, do it in the end so existing indexes doesent chang
	// create variables-----------------------------------

	$arrayOfTableName = array();
    $arrayOfprimaryKeyName = array();

    
    $arrayOfOptionString = array();
    
    $arrayOfBooleanRunFunction = array();
    $arrayOfFunction = array();
    $arrayOfFunctionArgumentSourceColumnName = array();
    $arrayOfFunctionArgumentTargetTableName = array();
    $arrayOfFunctionArgumentTargetColumnName = array();
    $arrayOfFunctionArgumentTargetConditionColumnName = array();


    $arrayOfTableRows = array();
    $arrayOfNuberOfRows = array();

    $arrayOfColumnNames = array();
    $arrayOfNumberOfColumns = array();

    // set variables--------------------------------------
    foreach ($ArrayOfspecificArrayInput as $var) {    	
    	// make it more readable start---------------------------------
    	$tableName = $var[0]; 
    	$primaryKeyName = $var[1];
    	
    	$booleanUseSqlForTable = $var[2];
    	$booleanUseAllColumns = $var[3];
    	$booleanUseSqlForColumns = $var[4];
    	$sqlForTable = $var[5];
    	$sqlForColumns = $var[6];
    	$columnNames = $var[7];
    	
    	$optionString = $var[8];
    	$booleanRunFunction = $var[9];
    	$function = $var[10];
    	$functionArgumentSourceColumnName = $var[11];
    	$functionArgumentTargetTableName = $var[12];
    	$functionArgumentTargetColumnName = $var[13];
    	$functionArgumentTargetConditionColumnName = $var[14];
    	// make it more readable stop---------------------------------
    	

    	$arrayOfTableName[] = $tableName;
	    $arrayOfprimaryKeyName[] = $primaryKeyName;

	    
	    $arrayOfOptionString[] = $optionString;
	    
	    $arrayOfBooleanRunFunction[] = $booleanRunFunction;
	    $arrayOfFunction[] = $function;
	    $arrayOfFunctionArgumentSourceColumnName[] = $functionArgumentSourceColumnName;
	    $arrayOfFunctionArgumentTargetTableName[] = $functionArgumentTargetTableName;
	    $arrayOfFunctionArgumentTargetColumnName[] = $functionArgumentTargetColumnName;
	    $arrayOfFunctionArgumentTargetConditionColumnName[] = $functionArgumentTargetConditionColumnName;


	    // tableRows
	    if($booleanUseSqlForTable == true){
	    	
	    	$sqlTmp = $sqlForTable;
	    }
	    else{
	    	
	    	$sqlTmp = "SELECT * FROM $tableName";
	    }
	    $tmp = getArrayFromSql($conn,$sqlTmp);
	   	$arrayOfTableRows[]= $tmp;
	    $arrayOfNuberOfRows[] =count($tmp);


	    // columnNames
	    $booleanUseSqlTmp = false;
	    if($booleanUseAllColumns == true){
	    	$sqlTmp = "SHOW COLUMNS FROM $tableName"; // will this work?? will it cause som sort of problem? it did when I used $classObject->tableName
	    	$booleanUseSqlTmp = true;
	    }
	    elseif($booleanUseSqlForColumns){
	    	$sqlTmp = $sqlForColumns;
	    	$booleanUseSqlTmp = true; 
	    }
	    if($booleanUseSqlTmp == true){
    		$tmp = getArrayFieldFromSql($conn,$sqlTmp);
	        $arrayOfColumnNames[] = $tmp;
	        $numberOfColumns = count($tmp);
	    }
	    else{
	    	$numberOfColumns = count($columnNames);
    		$arrayOfColumnNames[] = $columnNames;
	    }

	    $arrayOfNumberOfColumns[] = $numberOfColumns;

    }



    // set all arrayVariables in one array and return

    $specificMultiArray1 = array(
	    $arrayOfTableName,
	    $arrayOfprimaryKeyName,
	    $arrayOfOptionString,
	    $arrayOfBooleanRunFunction,
	    $arrayOfFunction,
	    $arrayOfFunctionArgumentSourceColumnName,
	    $arrayOfFunctionArgumentTargetTableName,
	    $arrayOfFunctionArgumentTargetColumnName,
	    $arrayOfFunctionArgumentTargetConditionColumnName,
	    $arrayOfTableRows,
	    $arrayOfNuberOfRows, 
	    $arrayOfColumnNames,
	    $arrayOfNumberOfColumns
    );

    return $specificMultiArray1;
}


function showTableSuperGeneral($conn,$specificMultiArray1){ //$function($conn, $sourceColumn, $row, $targetTable, $targetColumn);
	
	// unpack $specificMultiArray1
	$arrayOfTableName = $specificMultiArray1[0];
    $arrayOfprimaryKeyName = $specificMultiArray1[1];
    $arrayOfOptionString = $specificMultiArray1[2];
    $arrayOfBooleanRunFunction = $specificMultiArray1[3];
    $arrayOfFunction = $specificMultiArray1[4];
    $arrayOfFunctionArgumentSourceColumnName = $specificMultiArray1[5];
    $arrayOfFunctionArgumentTargetTableName = $specificMultiArray1[6];
    $arrayOfFunctionArgumentTargetColumnName = $specificMultiArray1[7];
    $arrayOfFunctionArgumentTargetConditionColumnName = $specificMultiArray1[8];
    $arrayOfTableRows = $specificMultiArray1[9];
    $arrayOfNuberOfRows  = $specificMultiArray1[10];
    $arrayOfColumnNames = $specificMultiArray1[11];
    $arrayOfNumberOfColumns = $specificMultiArray1[12];

	


	// fast show for verifiying that it works:
	/*
	$i = 0;
    foreach ($arrayOfTableName as $tableName) {
    	echo "tableName = ".$tableName."----------------------------------------------------------------<br>";
    	echo "rows: name -----------------------------<br>";
    	foreach ($arrayOfTableRows[$i] as $row) {
    		
    			echo "name: ".$row["name"]."<br>";
    	}
    	echo "columnNames-----------------------------<br>";
    	foreach ($arrayOfColumnNames[$i] as $columnName) {
    		echo $columnName."<br>";
    	}

    	$i++;
    }
   
   //*/


	// table--------------------------------------------------------------------------------------------------------------------------------
	echo "<table>";
	

	// table header------------------------------------------
	echo "<tr>";

	$i=0;
	foreach ($arrayOfColumnNames as $columnNames) {
		showTableHeader($columnNames);
		if($arrayOfBooleanRunFunction[$i]==true){
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
			
			// to make it more readable start---------------------------------
		    $primaryKeyName = $arrayOfprimaryKeyName[$i];
		    $tableRows = $arrayOfTableRows[$i];
		    $nuberOfRows = $arrayOfNuberOfRows[$i];
		    $columnNames = $arrayOfColumnNames[$i];
		    $numberOfColumns = $arrayOfNumberOfColumns[$i];

		    $optionString = $arrayOfOptionString[$i];


		    $booleanRunFunction = $arrayOfBooleanRunFunction[$i];
 

		    // to make it more readable stop---------------------------------

			if($rowNumber<$nuberOfRows){
				
				$row = $tableRows[$rowNumber];
				showRow($conn,$tableName,$primaryKeyName,$row,$columnNames,$optionString);

				if($booleanRunFunction == true){

				    $function = $arrayOfFunction[$i];
				    $sourceColumnName = $arrayOfFunctionArgumentSourceColumnName[$i];
				    $targetTableName = $arrayOfFunctionArgumentTargetTableName[$i];
				    $targetColumnName = $arrayOfFunctionArgumentTargetColumnName[$i];
				    $targetConditionColumnName = $arrayOfFunctionArgumentTargetConditionColumnName[$i];
				    //echo "bbbbbbbbbbbb".$function.$sourceColumnName.$targetTableName.$targetColumnName.$targetConditionColumnName;
					echo "<td>";
					$function($conn, $sourceColumnName, $row, $targetTableName, $targetColumnName, $targetConditionColumnName);
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




	echo "</table>";
	
}


function showHoleTableOnlyOneTableGeneral($conn, $tableName, $primaryKeyName, $optionString, $booleanRunFunction, $function, $functionArgumentSourceColumnName, $functionArgumentTargetTableName, $functionArgumentTargetColumnName, $functionArgumentTargetConditionColumnName){

	// $tableName = "products";
	// $primaryKeyName = "id";
	$booleanUseSqlForTable = false;
	$booleanUseAllColumns = true;
	$booleanUseSqlForColumns = false;
	$sqlForTable = "";    // "SELECT * FROM products";
	$sqlForColumns = "";  // "SHOW COLUMNS FROM products";
	$columnNames = "";    // array("id","name");
	// $optionString = "change";
	// $booleanRunFunction = false; 
	// $function = "addOrRemoveButton";
	// $functionArgumentSourceColumnName = "id"; 
	// $functionArgumentTargetTableName = "products";
	// $functionArgumentTargetColumnName = "amount";
	// $functionArgumentTargetConditionColumnName = "id";
	
	$specificArrayInput1 = getspecificArrayInput($tableName,$primaryKeyName,$booleanUseSqlForTable,$booleanUseAllColumns,$booleanUseSqlForColumns,$sqlForTable,$sqlForColumns,$columnNames,$optionString,$booleanRunFunction,$function,$functionArgumentSourceColumnName,$functionArgumentTargetTableName,$functionArgumentTargetColumnName,$functionArgumentTargetConditionColumnName);

	$ArrayOfspecificArrayInput = array();
	$ArrayOfspecificArrayInput[] = $specificArrayInput1;
	

	$specificMultiArray1 = getSpecialMultiArray1($conn,$ArrayOfspecificArrayInput);

	showTableSuperGeneral($conn,$specificMultiArray1);
}




// superAdmin things-----------------------------------------------------------------------------------------------------------





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


function showOneTableToAdmin($conn,$tableName,$optionString){

	//$conn
	//$tableName
	$primaryKeyName = getPrimaryKeyColumnNames($conn,$tableName);
	//$optionString
	$booleanRunFunction = false;
	$function = "";
	$functionArgumentSourceColumnName = "";
	$functionArgumentTargetTableName = "";
	$functionArgumentTargetColumnName = "";
	$functionArgumentTargetConditionColumnName = "";


	showHoleTableOnlyOneTableGeneral($conn, $tableName, $primaryKeyName, $optionString, $booleanRunFunction, $function, $functionArgumentSourceColumnName, $functionArgumentTargetTableName, $functionArgumentTargetColumnName, $functionArgumentTargetConditionColumnName);
}

function showAllTablesToAdmin($conn,$tableNames,$optionString){
	foreach ($tableNames as $tableName) {
		echo "<br><br>tableName: ".$tableName." -----------------------------------------------------------------<br><br>";
		showOneTableToAdmin($conn,$tableName,$optionString);
		echo "<br><br>-----------------------------------------------------------------<br><br>";
	}
}

function runSuperAdmin($conn){
	$tableNames = getTableNames($conn);
	
	showAllTableNames($tableNames);

	$optionString = "change";
	showAllTablesToAdmin($conn,$tableNames,$optionString);

	
}








?>