 <?php
$servername 	= "utbweb.its.ltu.se";
$username 	= "19970225";
$password 	= "19970225";
$dbname 	= "db19970225";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ID, NAME FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["ID"]. " - Name: " . $row["NAME"].  "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?> 
