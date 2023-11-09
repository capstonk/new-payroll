<?php
// Start the session
session_start();
include_once 'connection.php';

// Check if the Employee user is not logged in, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'Employee') {
    header("location: user_login.php");
    exit;
}

// Display the Employee username
$employee_username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Interface</title>
</head>
<body>

    <h2>Welcome, Employee <?php echo $employee_username; ?>!</h2>

    <p>This is the Employee interface. You can add Employee-specific content and features here.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
