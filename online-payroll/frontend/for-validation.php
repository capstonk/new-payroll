<?php
session_start();
include_once '../backend/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $control_number = $_POST["control_number"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $tables = array("admin", "hr", "employee");
    $found = false;

    foreach ($tables as $table) {
        $query = "SELECT * FROM $table WHERE control_no = ? AND username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $control_number, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $_SESSION["username"] = $username;
            $_SESSION["control_number"] = $control_number;
            header("Location: for-additional-information.php");
            exit();
        }
    }

    $login_error = "Invalid credentials";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../pictures/alpha_steel_logo.png" />
    <link rel="stylesheet" href="../style/for-validation.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Verification</title>
</head>
<body>
    <div class="container">
        <img class="logo" src="pictures/alpha_steel_logo.png" alt="logo">
        <h2>Verification</h2>
        <p>Please fill out the following fields.</p>

        <?php
        // Display login error if any
        if (isset($login_error)) {
            echo "<p style='color: red; text-align:center;'>$login_error</p>";
        }
        ?>

        <!-- Form Method -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="control_number" placeholder="Enter control number" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" id="password" required> <i class="fa-solid fa-eye" id="show-password"></i>
            <button type="submit">Validate</button>
        </form>
        <script src="script/show-password.js"></script>
    </div>
</body>
</html>
