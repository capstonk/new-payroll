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
					<label for="control_no">Control No:</label>
                    <input type="text" id="control_no" name="control_no" required>
					

        <label for="user_level">User Level:</label>
        <select id="user_level" name="user_level" onchange="showUserIdInput()" required>
            <option value="employee">Employee</option>
            <option value="hr">HR</option>
            <option value="admin">Admin</option>
        </select><br>

        <div id="employee_id_input" style="display: none;">
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required><br>
        </div>

        <div id="hr_id_input" style="display: none;">
            <label for="hr_id">HR ID:</label>
            <input type="text" id="hr_id" name="hr_id" required><br>
        </div>

        <div id="admin_id_input" style="display: none;">
            <label for="admin_id">Admin ID:</label>
            <input type="text" id="admin_id" name="admin_id" required><br>
        </div>

<label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required><br>

                    <label for="middle_name">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name"><br>

                    <label for="position_acquired">Position Acquired:</label>
                    <input type="text" id="position_acquired" name="position_acquired" required><br>
                  

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
	//----accounnt---//
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

 function showUserIdInput() {
        var userLevel = document.getElementById("user_level").value;

        // Hide all input boxes initially
        document.getElementById("employee_id_input").style.display = "none";
        document.getElementById("hr_id_input").style.display = "none";
        document.getElementById("admin_id_input").style.display = "none";

        // Show the relevant input box based on the selected user level
        if (userLevel === "employee") {
            document.getElementById("employee_id_input").style.display = "block";
        } else if (userLevel === "hr") {
            document.getElementById("hr_id_input").style.display = "block";
        } else if (userLevel === "admin") {
            document.getElementById("admin_id_input").style.display = "block";
        }
    }

//---create----//




</script>

</div>
</body>
</html>