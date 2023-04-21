<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

require_once 'db_connection.php';

$id = $_GET['id'];

$query = "DELETE FROM projects WHERE id=$id";
if (mysqli_query($conn, $query)) {
  header("Location: dashboard.php");
} else {
  echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
?>