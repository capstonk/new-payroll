<?php

// Start the session
session_start();

include_once '../backend/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_username = $_POST["username"];
    $entered_password = $_POST["password"];

    // Query the database to get the user credentials
    $sql = "SELECT * FROM users WHERE username = '$entered_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password against the hashed password in the database
        if (password_verify($entered_password, $row["password"])) {
            // Set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $entered_username;
            $_SESSION["user_type"] = $row["user_type"];

            // Redirect based on user type
            if ($_SESSION["user_type"] == 'HR') {
                header("location: hr_interface.php");
            } elseif ($_SESSION["user_type"] == 'Employee') {
                header("location: employee_interface.php");
            }
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
		<title>HR Login</title>
</head>
<body>
<div class="container">
       <img class="logo" src="../pictures/alpha_steel_logo.png" alt="logo">
    <h2>HR Login</h2>

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
</div>
	<script src="../script/show-password.js"></script>
</body>
</html>
