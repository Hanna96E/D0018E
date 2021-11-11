<?php
$servername = "utbweb.its.ltu.se";
$username = "19970225";
$password = "19970225";
$databas = "db19970225";

// Create connection
$conn = new mysqli($servername, $username, $password, $databas);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
<p>We got it working</p>
<p> mvh Bella </p>

