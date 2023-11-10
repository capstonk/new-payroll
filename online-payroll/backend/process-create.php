<?php
include_once '../backend/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $control_no = $_POST['control_no'];
    $employee_id = $_POST['employee_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $position_acquired = $_POST['position_acquired'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO create_acc (control_no, employee_id, first_name, middle_name, last_name, position_acquired, email, username, password) VALUES ('$control_no', '$employee_id', '$first_name', '$middle_name', '$last_name', '$position_acquired', '$email', '$username', '$password')";
    
    if ($conn->query($query) === TRUE) {
        // Success! Send a response to the JavaScript
        echo json_encode(['status' => 'success']);
    } else {
        // Error! Send an error response to the JavaScript
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}
?>
