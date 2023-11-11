<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $control_no = $_POST['control_no'];
    $user_level = $_POST['user_level'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $position_acquired = $_POST['position_acquired'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Additional fields for different user levels
    $employee_id = $_POST['employee_id'] ?? null;
    $hr_id = $_POST['hr_id'] ?? null;
    $admin_id = $_POST['admin_id'] ?? null;
    $other_user_id = $_POST['other_user_id'] ?? null;

    // Determine the table based on the user level
    $table = '';
    switch ($user_level) {
        case 'employee':
            $table = 'employee';
            break;
        case 'hr':
            $table = 'hr';
            break;
        case 'admin':
            $table = 'admin';
            break;
        default:
            // Handle invalid user level
            echo json_encode(['status' => 'error', 'message' => 'Invalid user level']);
            exit;
    }

    $query = "INSERT INTO $table (control_no, first_name, middle_name, last_name, position_acquired, username, password";

    // Add specific fields based on user level
    switch ($user_level) {
        case 'employee':
            $query .= ", employee_id";
            break;
        case 'hr':
            $query .= ", hr_id";
            break;
        case 'admin':
            $query .= ", admin_id";
            break;
    }

    $query .= ") VALUES ('$control_no', '$first_name', '$middle_name', '$last_name', '$position_acquired', '$username', '$password'";

    // Add specific values based on user level
    switch ($user_level) {
        case 'employee':
            $query .= ", '$employee_id'";
            break;
        case 'hr':
            $query .= ", '$hr_id'";
            break;
        case 'admin':
            $query .= ", '$admin_id'";
            break;

    }

    $query .= ")";

    if ($conn->query($query) === TRUE) {
        // Success! Send a response to the JavaScript
        echo json_encode(['status' => 'success']);
    } else {
        // Error! Send an error response to the JavaScript
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}
?>
