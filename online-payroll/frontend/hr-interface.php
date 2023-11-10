<?php
// Start the session
session_start();
include_once 'connection.php';

// Check if the HR user is not logged in, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'HR') {
    header("location: hr-login.php");
    exit;
}

// Display the HR username
$hr_username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="pictures/alpha_steel_logo.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/admin-dashboard.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lexend"/>
        <title>HR Interface</title>
        
        
    </head>
    
</head>
<body>

    <h2>Welcome, HR <?php echo $hr_username; ?>!</h2>

    <p>This is the HR interface. You can add HR-specific content and features here.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
