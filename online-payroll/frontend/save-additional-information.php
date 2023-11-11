<?php
session_start();

// Check if the username is set in the session
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    // If the username is not set, redirect to the validation page
    header("Location: for-validation.php");
    exit();
}

include_once '../backend/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve additional information from the form
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $status = $_POST["status"];
    $gender = $_POST["gender"];

    // Prepare and execute the SQL statement to insert data into the additional_info table
    $query = "INSERT INTO additional_info (username, email, address, phone, dob, status, gender) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $username, $email, $address, $phone, $dob, $status, $gender);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        $success_message = "Additional information saved successfully!";
    } else {
        $error_message = "Error saving additional information. Please try again.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../pictures/alpha_steel_logo.png" />
    <link rel="stylesheet" href="../style/for-additional-information.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Additional Information</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            
            <?php
            // Display success or error messages
            if (isset($success_message)) {
                echo "<p style='color: green;'>$success_message</p>";
            } elseif (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Your form fields remain unchanged -->

                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</body>
</html>
