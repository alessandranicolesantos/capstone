<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'db_system');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch users from the database
$query = "SELECT id,  CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, username, email, mobile, created_at, usertype FROM users_employee
          UNION ALL SELECT id,  CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, username, email, mobile, created_at, usertype FROM users";
$result = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="adminStyles.css"> 
    <script src="AdminScript.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- For current_timezone -->
    <style>

        /* Fixed Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background-color: #f8d7da; /* Light red for the header */
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd; /* Subtle border for cells */
        }

        table th {
            color: #721c24; /* Dark red for header text */
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #fdf2f4; /* Very light red for alternate rows */
        }

        table tr:nth-child(odd) {
            background-color: #fff; /* White for odd rows */
        }

        table tr:hover {
            background-color: #fdecea; /* Slightly darker light red for hover effect */
        }

        .view-btn {
            background-color: #007bff; /* Blue button */
            color: white;
            border: none;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-btn:hover {
            background-color: #0056b3; /* Darker blue for hover */
        }

        .add-payment {
            background-color: #f8b7b1;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-payment:hover {
            background-color: #f1948a;
        }

        .sort {
            float: right;
            margin-top: 10px;
        }

        .sort label {
            font-size: 14px;
            margin-right: 5px;
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
                <li><span onclick="window.location.href='recepDash.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
                <li><span onclick="window.location.href='recepManagement.php';"><i class="fas fa-users"></i> User Management</span></li>
                <li><span onclick="window.location.href='calendar.php';"><i class="fas fa-calendar-alt"></i> Calendar</span></li>
                <li class="active"><span onclick="window.location.href='recepPayments.php';"><i class="fas fa-credit-card"></i> Payments</span></li>
                <li><span onclick="window.location.href='recepSMS.php';"><i class="fas fa-sms"></i> SMS</span></li>
                <li><span onclick="window.location.href='policy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>    

        <!-- Main Content -->
        <div class="main-content">
            <div class="user-management">
            <header>
                <h1>Manage Payments</h1>
                <div class="sort">
                    <label for="sort">Sort by:</label>
                    <select id="sort">
                        <option>Newest</option>
                        <option>Oldest</option>
                    </select>
                </div>
                <button class="add-payment">+ Add Payment</button>
            </header>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Appointment ID</th>
                        <th>Date</th>
                        <th>Treatment</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0</td>
                        <td>Maria Tidoy</td>
                        <td>2024-09-02</td>
                        <td>Tooth Filling</td>
                        <td>P700</td>
                        <td>Paid</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Alessandra Santos</td>
                        <td>2024-09-02</td>
                        <td>Tooth Filling</td>
                        <td>P700</td>
                        <td>Paid</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Don Gojo Cruz Jr.</td>
                        <td>2024-09-02</td>
                        <td>Oral prophylaxis</td>
                        <td>P1000</td>
                        <td>Paid</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Wency Opiso</td>
                        <td>2024-09-03</td>
                        <td>Consultation</td>
                        <td>P500</td>
                        <td>Paid</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                </tbody>
            </table>
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

    </script>
</body>
</html>