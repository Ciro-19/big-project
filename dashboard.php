<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM projects WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <p><a href="logout.php">Logout</a></p>
    <h2>Projects</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?php echo $project['name']; ?></td>
                    <td><?php echo $project['description']; ?></td>
                    <td>
                        <a href="edit_project.php?id=<?php echo $project['id']; ?>">Edit</a> |
                        <a href="delete_project.php?id=<?php echo $project['id']; ?>" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="add_project.php">Add a new project</a></p>
</body>
</html>