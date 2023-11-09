<?php
// Start the session
session_start();

// Check if the admin is not logged in, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_login.php");
    exit;
}

// Display the admin username
$admin_username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
</head>
<body>

    <h2>Welcome, <?php echo $admin_username; ?>!</h2>

    <p>This is the admin interface. You can add your content and features here.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
