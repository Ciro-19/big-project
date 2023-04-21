<?php
$servername = "localhost";
$username = "u185201249_Idriss";
$password = "Asigugar789@@";
$dbname = "u185201249_Project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>