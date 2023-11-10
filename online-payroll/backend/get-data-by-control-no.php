    <?php
    include_once '../backend/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Get the control number from the URL parameter
        $controlNo = $_GET['controlNo'];

        // Fetch data from the database based on the control number
        $query = "SELECT * FROM request_account WHERE control_no = '$controlNo'";
        $result = $conn->query($query);

        // Check if data is found
        if ($result->num_rows > 0) {
            // Fetch the first row (assuming control_no is unique)
            $row = $result->fetch_assoc();
            $response = [
                'first_name' => $row['first_name'],
                'middle_name' => $row['middle_name'],
                'last_name' => $row['last_name'],
                'position_acquired' => $row['position'],
                // Add other fields as needed
            ];
            echo json_encode($response);
        } else {
            // If no data is found, return an empty JSON object
            echo json_encode(['error' => 'No data found for the given control number']);
        }
    } else {
        // If the request method is not GET, return an empty JSON object
        echo json_encode(['error' => 'Invalid request method']);
    }
    ?>
