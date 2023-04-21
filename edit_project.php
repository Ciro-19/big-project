<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

require_once 'db_connection.php';

$id = $_GET['id'];

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
      $query = "UPDATE projects SET name='$name', description='$description', image='$image' WHERE id=$id";
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

$query = "SELECT * FROM projects WHERE id=$id";
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Project</title>
</head>
<body>
  <h1>Edit Project</h1>
  <form action="edit_project.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $project['name']; ?>" required>
    <br>
    <label for="description">Description:</label>
    <textarea name="description" id="description" required><?php echo $project['description']; ?></textarea>
    <br>
    <label for="image">Image:</label>
    <?php if ($project['image']) { ?>
      <img src="uploads/<?php echo $project['image']; ?>" alt="<?php echo $project['name']; ?>" width="100">
    <?php } ?>
    <input type="file" name="image" id="image">
    <br>
    <input type="submit" name="submit" value="Update Project">
  </form>
</body>
</html>