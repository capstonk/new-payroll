<?php
include_once '../backend/connection.php';

// Display data from the employee table
$queryEmployee = "SELECT * FROM employee";
$resultEmployee = $conn->query($queryEmployee);

if ($resultEmployee->num_rows > 0) {
    echo "<h2>Employee Data</h2>";
    echo "<table border='1'>
            <tr>
                <th>Control Number</th>
                <th>Employee ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Position Acquired</th>
                <th>Username</th>
                <th>Password</th>
            </tr>";

    while ($row = $resultEmployee->fetch_assoc()) {
        echo "<tr>
                <td>{$row['control_no']}</td>
                <td>{$row['employee_id']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['middle_name']}</td>
                <td>{$row['position_acquired']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No employee accounts found.";
}

// Similar code for HR, Admin, and Other User tables...
// You need to adjust queries, table names, and column names based on your actual schema.

// Display data from the hr table
$queryHR = "SELECT * FROM hr";
$resultHR = $conn->query($queryHR);

if ($resultHR->num_rows > 0) {
    echo "<h2>HR Data</h2>";
    echo "<table border='1'>
            <tr>
                <th>Control Number</th>
                <th>HR ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Position Acquired</th>
                <th>Username</th>
                <th>Password</th>
            </tr>";

    while ($row = $resultHR->fetch_assoc()) {
        echo "<tr>
                <td>{$row['control_no']}</td>
                <td>{$row['hr_id']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['middle_name']}</td>
                <td>{$row['position_acquired']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No employee accounts found.";
}


// Display data from the admin table
$queryAdmin = "SELECT * FROM admin";
$resultAdmin = $conn->query($queryAdmin);

if ($resultAdmin->num_rows > 0) {
    echo "<h2>Admin Data</h2>";
    echo "<table border='1'>
            <tr>
                <th>Control Number</th>
                <th>ADMIN ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Position Acquired</th>
                <th>Username</th>
                <th>Password</th>
            </tr>";

    while ($row = $resultAdmin->fetch_assoc()) {
        echo "<tr>
                <td>{$row['control_no']}</td>
                <td>{$row['admin_id']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['middle_name']}</td>
                <td>{$row['position_acquired']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No employee accounts found.";
}



?>
