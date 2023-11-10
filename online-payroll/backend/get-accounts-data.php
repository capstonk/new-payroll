<?php
include_once '../backend/connection.php';

$query = "SELECT * FROM create_acc";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Control Number</th>
                <th>Employee ID</th>
				<th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Position Acquired</th>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['control_no']}</td>
                <td>{$row['employee_id']}</td>
				<td>{$row['last_name']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['middle_name']}</td>
                <td>{$row['position_acquired']}</td>
                <td>{$row['email']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No accounts found.";
}
?>
