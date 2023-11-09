<?php

// Start the session
session_start();

include_once 'connection.php';

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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>

    <h2>User Login</h2>

    <?php
    // Display login error if any
    if (isset($login_error)) {
        echo "<p style='color: red;'>$login_error</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

</body>
</html>
