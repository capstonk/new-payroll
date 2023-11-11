<?php
session_start();
include_once '../backend/connection.php';

if (!isset($_SESSION["username"]) || !isset($_SESSION["control_number"])) {
    header("Location: for-validation.php");
    exit();
}

$username = $_SESSION["username"];
$control_number = $_SESSION["control_number"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $status = $_POST["status"];
    $gender = $_POST["gender"];

    // Perform input validation here

    // Replace the control number prefix with the corresponding user type
    $user_type = getUserTypeFromControlNumber($control_number);
    $control_number = replaceControlNumberPrefix($control_number, $user_type);

    $query = "INSERT INTO additional_info (control_no, username, email, address, phone, dob, status, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("ssssssss", $control_number, $username, $email, $address, $phone, $dob, $status, $gender);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success_message = "Additional information saved successfully!";
            // Redirect based on user type
            redirectUser($user_type);
            exit();
        } else {
            $error_message = "Error saving additional information. Please try again.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $error_message = "Error preparing the SQL statement. Please try again.";
    }
}

// Close the database connection
$conn->close();

function getUserTypeFromControlNumber($control_number) {
    // Extract the prefix from the control number
    $prefix = substr($control_number, 0, 2);

    // Map the prefix to the corresponding user type
    $type_mapping = array(
        'EM' => 'employee',
        'AD' => 'admin',
        'HR' => 'hr'
    );

    // Return the corresponding user type or a default value
    return isset($type_mapping[$prefix]) ? $type_mapping[$prefix] : 'default';
}

function replaceControlNumberPrefix($control_number, $user_type) {
    // Replace the prefix with the corresponding user type
    return $user_type . substr($control_number, 2);
}

function redirectUser($user_type) {
    if (!empty($user_type)) {
        switch ($user_type) {
            case 'admin':
                header("Location: admin-login.php");
                break;
            case 'hr':
                header("Location: hr-login.php");
                break;
            case 'employee':
                header("Location: employee-login.php");
                break;
            default:
                header("Location: default-login.php");
                break;
        }
        exit();
    }
}
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
            <h2>Additional Information</h2>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br>
            <label for="phone">Phone Number:</label>
            <input type="int" id="phone" name="phone" required><br>
            <label for="date">Date of birth:</label>
            <input type="date" id="dob" name="dob" value="Date of Birth" required><br>
            <label for="status">Civil Status:</label>
            <select name="status"> 
                <option value="0">Select status</option>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="married">Divorced</option>
                <option value="married">Widowed</option>
            </select>
            <label for="address">Gender:</label>
            <select name="gender"> 
                <option value="0">Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select> <br>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
    
</body>
</html>
