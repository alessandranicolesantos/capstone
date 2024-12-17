<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'db_system');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT id,  CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, username, email, mobile, created_at, usertype FROM users_employee
          UNION ALL SELECT id,  CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, username, email, mobile, created_at, usertype FROM users";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="adminStyles.css"> 
    <script src="AdminScript.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- For current_timezone -->

    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #5C3A31; /* Brown text color */
            background-color: #f9f1f1; /* Light pink background */
        }

        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.4); /* Dark background for modal */
            padding-top: 60px; 
        }

        .modal-content {
            background-color: #ffffff; /* White background for modal */
            margin: 5% auto; 
            padding: 20px;
            border-radius: 10px; /* Rounded corners for modal */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Slight shadow for depth */
            width: 80%; 
            max-width: 500px; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Form Styles */
        label {
            display: block;
            margin-bottom: 5px;
            color: #5C3A31; /* Brown label color */
        }

        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button[type="button"] {
            background-color: #da9393; /* Light pink for button */
            color: white; /* White text */
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition */
        }

        button[type="button"]:hover {
            background-color: #ea7575; /* Darker pink on hover */
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <div class="top-header">
        <div class="logoDental">CHARMING SMILE<br>DENTAL CLINIC</div>
        <div class="user-info">
             <div class='current-datetime'> 
                <span id="datetime"></span>
             </div>
            <div class="profile"><i class="fas fa-user-circle"></i></div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="nav">
                <li><span onclick="window.location.href='recepDashboard.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
                <li class="active"><span onclick="window.location.href='recepManagement.php';"><i class="fas fa-users"></i> User Management</span></li>
                <li><span onclick="window.location.href='calendar.php';"><i class="fas fa-calendar-alt"></i> Calendar</span></li>
                <li><span onclick="window.location.href='recepPayment.php';"><i class="fas fa-credit-card"></i> Payments</span></li>
                <li><span onclick="window.location.href='recepSMS.php';"><i class="fas fa-sms"></i> SMS</span></li>
                <li><span onclick="window.location.href='policy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>    

        <!-- Main Content -->
        <div class="main-content">
            <div class="user-management">
                <h2>User Management</h2>

                <!-- Main User Table -->
                <div class="user-table">
                    <table id="userTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Date Created</th>
                                <th>User Type</th>
                                <!-- <th>Last Login</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($row['usertype']); ?></td>
                                <td>
                                    <button class="action-button disable" onclick="disableUser(this)">Disable User</button>
                                    <button class="action-button archive" onclick="archiveUser(this)">Archive</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Close the database connection -->
                <?php mysqli_close($db); ?>


                        
            </div>
        </div>
    </div>

    <script>
        function fetchCurrentTime() {
            $.ajax({
                url: 'current_timezone.php', // URL of the PHP script
                method: 'GET',
                success: function(data) {
                    $('#datetime').html(data); // Update the HTML with the fetched data
                },
                error: function() {
                    console.error('Error fetching time.');
                }
            });
        }

        // Fetch current time every second (1000 milliseconds)
        setInterval(fetchCurrentTime, 1000);

        // Initial call to display time immediately on page load
        fetchCurrentTime();

        // Toggle password visibility
        function togglePassword(element) {
            const passwordSpan = element.previousElementSibling;
            const password = passwordSpan.getAttribute('data-password');
            
            if (passwordSpan.textContent === '********') {
                passwordSpan.textContent = password;
                element.classList.remove('fa-eye');
                element.classList.add('fa-eye-slash');
            } else {
                passwordSpan.textContent = '********';
                element.classList.remove('fa-eye-slash');
                element.classList.add('fa-eye');
            }
        }

        // Open Edit Modal
        function openEditModal(button) {
            const row = button.closest('tr');
            document.getElementById('editUsername').value = row.cells[1].textContent;
            document.getElementById('editPassword').value = row.cells[2].querySelector('.password').getAttribute('data-password');
            document.getElementById('editUserType').value = row.cells[4].textContent;

            // Store a reference to the row for later use
            document.getElementById('editModal').dataset.currentRow = row.rowIndex;

            document.getElementById('editModal').style.display = 'block';
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Save Edited User Data
        function saveEdit() {
            const username = document.getElementById('editUsername').value;
            const password = document.getElementById('editPassword').value;
            const userType = document.getElementById('editUserType').value;

            // Get the row index stored in the modal's dataset
            const rowIndex = document.getElementById('editModal').dataset.currentRow;
            const row = document.getElementById('userTable').rows[rowIndex];

            // Update the values in the selected row
            row.cells[1].textContent = username;
            row.cells[2].querySelector('.password').setAttribute('data-password', password);
            row.cells[4].textContent = userType;

            closeEditModal();
        }

        // Dummy functions for other actions
        function disableUser(button) {
            const row = button.closest('tr');
            row.cells[1].textContent += ' (Disabled)';
            button.disabled = true; // Disable button after use
        }

        function archiveUser(button) {
            const row = button.closest('tr');
            row.style.display = 'none'; // Hide the row after archiving
            alert('User archived: ' + row.cells[1].textContent);
        }
    </script>
</body>
</html>