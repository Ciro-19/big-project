<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

require_once 'db_connection.php';

if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);

  // Handle file upload
  $image = $_FILES['image']['name'];
  $target = "uploads/" . basename($image);
  $uploadOk = 1;

  // Check if image file is an actual image or a fake image
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["image"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
      $query = "INSERT INTO projects (name, description, image) VALUES ('$name', '$description', '$image')";
      if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
      } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>