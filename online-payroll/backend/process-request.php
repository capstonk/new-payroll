<?php
include_once '../backend/connection.php';

// Function to fetch and return request data as an HTML table
function showRequestsData($conn) {
    $query = "SELECT * FROM request_account WHERE status = 'Pending'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Control Number</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['control_no']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['middle_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['position']}</td>
                    <td>
                        <button onclick='approveRequest({$row['id']})'>Approve</button>
                        <button onclick='rejectRequest({$row['id']})'>Reject</button>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No pending requests found.";
    }
}

// Call the function to fetch and return request data
showRequestsData($conn);

// Handle approve request
if (isset($_POST['action']) && $_POST['action'] == 'approve' && isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];
    $approveQuery = "UPDATE request_account SET status = 'Approved' WHERE id = $requestId";
    $conn->query($approveQuery);
    // You may add additional logic or error handling here
    exit;
}

// Handle reject request
if (isset($_POST['action']) && $_POST['action'] == 'reject' && isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];
    $rejectQuery = "UPDATE request_account SET status = 'Rejected' WHERE id = $requestId";
    $conn->query($rejectQuery);
    // You may add additional logic or error handling here
    exit;
}
?>
