<?php

// Start the session
session_start();

// Database connection details
include_once '../backend/connection.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_username = $_POST["username"];
    $entered_password = $_POST["password"];

    // Query the database to get the admin credentials
    $sql = "SELECT * FROM admins WHERE username = 'AlphaAdmin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password against the actual password in the database
        if ($entered_password == 'AlphaAdmin12*') {
            // Set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = "AlphaAdmin";

            // Redirect to the admin interface
            header("location: admin-interface.php");
            exit;
        } else {
            $login_error = "Invalid username or password";
        }
    } else {
        $login_error = "Invalid username or password";
    }
}

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../pictures/alpha_steel_logo.png" />
		<link rel="stylesheet" href="../style/for-admin.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
		<title>Admin</title>
</head>
<body>
<div class="container">
       <img class="logo" src="../pictures/alpha_steel_logo.png" alt="logo">
    <h2>Admin Login</h2>

    <?php
    // Display login error if any
    if (isset($login_error)) {
        echo "<p style='color: red;'>$login_error</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" id="password"required> <i class="fa-solid fa-eye" id="show-password"></i>

       <button type="submit">Login</button>
    </form>
	<script src="../script/show-password.js"></script>
</body>
</html>
