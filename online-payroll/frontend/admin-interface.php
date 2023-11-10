<?php
// Start the session
session_start();
include_once '../backend/connection.php';

// Check if the admin is not logged in, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin-login.php");
    exit;
}

// Display the admin username
$admin_username = $_SESSION["username"];

// Function to fetch and display request data
function showRequestsData($conn) {
    $query = "SELECT * FROM request_account WHERE status = 'pending'"; // Modify the status condition as needed
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
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['control_no']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['middle_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['position']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No pending requests found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="../pictures/alpha_steel_logo.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../style/admin-interface.css">
       <title>Admin Interface</title>
    </head>
    
<body>

    
	<!-- Sidebar and menu toggle codes starts here-->
        <div class="menuToggle"> </div>
        <div class="sidebar">
            <ul>
                <li class="logo" style="--bg:#333;">
                    <a href="admin-interface.php">
                        <img src="../pictures/alpha_steel_logo.png">
                        <div class="text"> Alpha Steel</div>
                    </a>
                 </li>

            <div class="Menulist">
                <li style="--bg: #ed6335;">
                    <a onclick="showAccounts()" id="accounts-tab">
                        <div class="icon"><ion-icon name="person-add-outline"></ion-icon></div>
                        <div class="text">Accounts</div>
                    </a>
                </li>

                <li style="--bg: #ecae7d;">
                    <a onclick="showCreate()" id="create-tab">
						<div class="icon"><ion-icon name="add-outline"></ion-icon> </div>
						<div class="text">Create</div>
                    </a>
                 </li>
				 
                 <li style="--bg: #ecae7d;">
                    <a onclick="showRequests()" id="create-tab">
						<div class="icon"><ion-icon name="add-outline"></ion-icon> </div>
						<div class="text">Requests</div>
                    </a>
                 </li>   
				
            </div>

            <div class="bottom">
                <li style="--bg: #546b9e;">
                    <a href="logout.php">
                        <div class="icon"><ion-icon name="log-out-outline"></ion-icon> </div>
                        <div class="text">Logout</div>
                    </a>
                </li>
            </div>
			</ul>
       </div>
	<!-- Sidebar and menu toggle codes starts here-->
	
	<!-- tabs content codes starts here-->
	<div class="main">
	
		<!-- Welcome-admin codes starts here-->
			<div id="welcome-content" style="display: block;">
				<h2>Welcome, <?php echo $admin_username; ?>!</h2>
					<p>This is the admin interface. You can add your content and features here.</p>
			</div>
		<!-- Welcome-admin codes ends here-->
		

		<!-- Account content codes start here-->
			<div id="account-content" style="display: none;">
				<h2>Accounts</h2>
				<div id="account-data"></div>
			</div>
		<!-- Account content ends here -->
		
		
		<!-- Create account content starts here -->
			<div id="create-content" style="display: none;">
				<h2>Create an account for new user</h2>
				<form id="create-form">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" id="employee_id" name="employee_id" required><br>
					
					<label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required><br>

                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required><br>

                    <label for="middle_name">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name"><br>

                    <label for="position_acquired">Position Acquired:</label>
                    <input type="text" id="position_acquired" name="position_acquired" required><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br>

                    <button type="button" onclick="submitForm()">Create Account</button>
                </form>
			</div>
		<!-- Create account content ends here -->
		
		
		<!-- Request content codes starts here -->
			<div id="request-content" style="display: none;">
				<h2>Requests</h2>
					<div id="request-data"></div>
			</div>
		<!-- Request content codes ends here-->

		
	</div>
	<!-- tabs content codes ends here-->
	
	
		<!-- Icons scipt -->
			<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
			<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
		<!-- Icons scipt ends here -->
		
		
<!-- tabs content script -->
<script>
        let menuToggle = document.querySelector('.menuToggle');
    let sidebar = document.querySelector('.sidebar');
    let main = document.querySelector('.main');

    menuToggle.onclick = function () {
        menuToggle.classList.toggle('active');
        sidebar.classList.toggle('active');
        document.body.classList.toggle('sidebar-active');
    }
	
	
    let Menulist = document.querySelectorAll('.Menulist li');
    function activeLink() {
        Menulist.forEach((item) => item.classList.remove('active'));
        this.classList.add('active');
    }
    Menulist.forEach((item) => item.addEventListener('click', activeLink));
	
	function showAccounts() {
    document.getElementById('account-content').style.display = 'block';
    document.getElementById('create-content').style.display = 'none';
    document.getElementById('welcome-content').style.display = 'none';
    document.getElementById('request-content').style.display = 'none';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Assuming you have a div with id 'account-data' to display the data
            document.getElementById('account-data').innerHTML = xhr.responseText;
        }
    };

    // Assuming you have a separate PHP file to handle the database query
    xhr.open('GET', '../backend/get-accounts-data.php', true);
    xhr.send();
}

//---create----//
    function showCreate() {
    document.getElementById('create-content').style.display = 'block';
    document.getElementById('account-content').style.display = 'none';
    document.getElementById('welcome-content').style.display = 'none';
    document.getElementById('request-content').style.display = 'none';
}

function submitForm() {
    let form = document.getElementById('create-form');
    let formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            
            if (response.status === 'success') {
                // Reload the page or show a success message
                location.reload(); // This reloads the page
            } else {
                // Display an error message
                document.getElementById('create-result').innerHTML = 'Error: ' + response.message;
            }
        }
    };

    // Assuming you have a separate PHP file to handle the form submission
    xhr.open('POST', '../backend/process-create.php', true);
    xhr.send(formData);
}


function fillFormBasedOnControlNo() {
    let controlNo = document.getElementById('control_no').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let data = JSON.parse(xhr.responseText);
            console.log('Received data:', data);

            document.getElementById('first_name').value = data.first_name;
            document.getElementById('middle_name').value = data.middle_name;
            document.getElementById('last_name').value = data.last_name;
            document.getElementById('position_acquired').value = data.position_acquired;
        }
    };

    xhr.open('GET', '../backend/get-data-by-control-no.php?controlNo=' + controlNo, true);
    xhr.send();
}


// Attach the fillFormBasedOnControlNo function to the control number input's change event
document.getElementById('control_no').addEventListener('change', fillFormBasedOnControlNo);
//---create----//

//------showRequests--------//
function approveRequest(requestId) {
    sendRequest(requestId, 'approve');
}

function rejectRequest(requestId) {
    sendRequest(requestId, 'reject');
}

function sendRequest(requestId, action) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Assuming you have a div with id 'request-result' to display the result
            document.getElementById('request-result').innerHTML = xhr.responseText;
            // Refresh the requests data after approval or rejection
            showRequests();
        }
    };

    // Assuming you have a separate PHP file to handle the request processing
    xhr.open('POST', '../backend/process_request.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var data = 'action=' + action + '&requestId=' + requestId;
    xhr.send(data);
}

function showRequests() {
    document.getElementById('request-content').style.display = 'block';
    document.getElementById('create-content').style.display = 'none';
    document.getElementById('account-content').style.display = 'none';
    document.getElementById('welcome-content').style.display = 'none';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Assuming you have a div with id 'request-data' to display the data
            document.getElementById('request-data').innerHTML = xhr.responseText;
        }
    };

    // Assuming you have a separate PHP file to handle the database query
    xhr.open('GET', '../backend/process-request.php', true);
    xhr.send();
}
//------showRequests--------//


</script>

</div>
</body>
</html>