<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'db_system');


if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


if (!isset($_SESSION['id'])) {
    header('location: employeeLogin.php'); 
    exit();
}


$firstName = $_SESSION['first_name'];
$gender = $_SESSION['gender'];


$total_users = 0;
$total_appointments = 0;
$total_notified = 0;

/// Query to get total patients and employees for total system users
$query_users = "
SELECT 
    (SELECT COUNT(*) FROM users WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())) AS total_patients,
    (SELECT COUNT(*) FROM users_employee WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())) AS total_employees";

$result_users = mysqli_query($db, $query_users);
if ($row_users = mysqli_fetch_assoc($result_users)) {
    $total_patients = $row_users['total_patients'];
    $total_employees = $row_users['total_employees'];
}

$total_users = $total_patients + $total_employees;

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- For current_timezone -->
    <script src="recepScript.js" defer></script>
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

    <div class="main-wrapper">
        <!-- Sidebar Menu -->
        <div class="sidebar">
            <ul class="nav">
                <li class="active"><span onclick="window.location.href='recepDashboard.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
                <li><span onclick="window.location.href='recepManagement.php';"><i class="fas fa-users"></i> User Management</span></li>
                <li><span onclick="window.location.href='.html';"><i class="fas fa-calendar-alt"></i> Calendar</span></li>
                <li><span onclick="window.location.href='recepPayment.php';"><i class="fas fa-credit-card"></i> Payments</span></li>
                <li><span onclick="window.location.href='recepSMS.php';"><i class="fas fa-sms"></i> SMS</span></li>
                <li><span onclick="window.location.href='policy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>

        <!-- Main Dashboard Content -->
        <div class="main-content">
            <!-- Greeting Section -->
            <div class="greeting">
                <h2>Good Day, <br> 
                    <?php 
                    if ($gender == 'Male') {
                        echo "Mr. " . htmlspecialchars($firstName);
                    } elseif ($gender == 'Female') {
                        echo "Ms. " . htmlspecialchars($firstName);
                    } else {
                        echo htmlspecialchars($firstName); // Fallback for other values
                    }
                    ?>
                </h2>
            </div>
            <!-- Main Dashboard Area -->
            <div class="dashboard">
                <div class="appointment-report">
                    <div class="report-header">
                        <h3>Appointment Statistical Report</h3>
                        <div class="view-buttons">
                            <button class="chart-button" data-period="monthly">Monthly</button>
                            <button class="chart-button" data-period="weekly">Weekly</button>
                            <button class="chart-button" data-period="daily">Daily</button>
                        </div>
                    </div>
                     <!-- Bar Chart -->
                     <div class="bar-chart">
                        <canvas id="bar-chart" width="1400" height="300"></canvas>
                    </div>
                </div>
            </div>
                <!-- Statistics Summary -->
                <div class="statistics">
                    <div class="stat-box">
                        <h4>Total System Users This Month</h4>
                        <p><?php echo htmlspecialchars($total_users); ?></p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Appointments This Month</h4>
                        <p>0</p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Patients Notified with SMS This Month</h4>
                        <p>0</p>
                    </div>
                </div>
        </div>
    </div>
        <!-- JavaScript for Dropdown and Chart -->
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

            document.addEventListener('DOMContentLoaded', function () {
                // Dropdown functionality
                const dropdownButtons = document.querySelectorAll('.dropdown-btn');
                dropdownButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        this.classList.toggle('active');
                        const dropdownContainer = this.nextElementSibling;
                        dropdownContainer.style.display = dropdownContainer.style.display === 'block' ? 'none' : 'block';
                    });
                });
    
                // Bar Chart with Chart.js
                const ctx = document.getElementById('bar-chart').getContext('2d');
    
                // Data for different time periods
                const chartData = {
                    monthly: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        data: [10, 5, 8, 7, 12, 20, 18, 15, 10, 8, 6, 4]
                    },
                    weekly: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        data: [25, 18, 15, 20]
                    },
                    daily: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        data: [3, 5, 2, 8, 6, 4, 7]
                    }
                };
    
                // Chart configuration
                let barChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.monthly.labels,
                        datasets: [{
                            label: 'Appointments',
                            data: chartData.monthly.data,
                            backgroundColor: 'rgba(234, 84, 85, 0.7)',
                            borderColor: 'rgba(234, 84, 85, 1)',
                            borderWidth: 1,
                            borderRadius: 5, // Rounded bar corners
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
    
                // Event listener for switching datasets
                const chartButtons = document.querySelectorAll('.chart-button');
                chartButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const period = this.dataset.period;
                        barChart.data.labels = chartData[period].labels;
                        barChart.data.datasets[0].data = chartData[period].data;
                        barChart.update();
    
                        // Highlight active button
                        chartButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            });
        </script>
</body>
</html>