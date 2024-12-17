<?php
session_start(); 

if (!isset($_SESSION['id'])) {
    header('location: patLogin.php'); // Redirect to login if not logged in
    exit();
}

$firstName = $_SESSION['first_name'];
$gender = $_SESSION['gender'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- For current_timezone -->
    <link rel="stylesheet" href="patDashboard.css"> 

</head>
<body>
    <div class="top-header">
        <div class="logoDental">
            CHARMING SMILE<br>DENTAL CLINIC
        </div>
        <div class="user-info">
            <div class='current-datetime'> 
                <span id="datetime"></span>
            </div>
            <i class="fas fa-user-circle fa-2x"></i>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="sidebar">
            <ul class="nav">
                <li><span onclick="window.location.href='patDashboard.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</li></span>
                <button class="dropdown-btn">
                    <span onclick="window.location.href='patCalendar.php';"><i class="fas fa-calendar-alt"></i> Calendar <i class="fas fa-chevron-down dropdown-icon"></i></span>
                </button>
                    <ul class="dropdown-container">
                        <li><span onclick="window.location.href='patAppointments.php';"><i class="fas fa-notes-medical"></i> Appointments</span></li>
                    </ul>
                <li><span onclick="window.location.href='patRecord.php';"><i class="fas fa-user"></i> Patient Record</li></span>
                <li><span onclick="window.location.href='patPayment.php';"><i class="fas fa-credit-card"></i> Payment</span></li>
                <li><span onclick="window.location.href='patpolicy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="user-management">
            <div class="greeting">
                <h1>Good day,<br> 
                    <?php 
                    if ($gender == 'Male') {
                        echo "Mr. " . htmlspecialchars($firstName);
                    } elseif ($gender == 'Female') {
                        echo "Ms. " . htmlspecialchars($firstName);
                    } else {
                        echo htmlspecialchars($firstName); // Fallback for other values
                    }
                    ?>
                </h1>
            </div>

            <div class="appointment-section">
                <h3>YOUR NEXT APPOINTMENT</h3>
                <div class="appointment-card">
                    <div class="date-display"> </div>
                    <div class="appointment-details">
                        <p>No upcoming appointment.</p>
                    </div>
                </div>
            </div>

            <div class="appointment-section">
                <h3>PREVIOUS APPOINTMENT</h3>
                <div class="appointment-card">
                    <div class="date-display">20 SEP 2024</div>
                    <div class="appointment-details">
                        <div>
                            <strong>Treatment</strong><br>
                            Oral prophylaxis
                        </div>
                        <div>
                            <strong>Time</strong><br>
                            10:00 AM - 11:00 AM
                        </div>
                        <div>
                            <strong>Dentist</strong><br>
                            Dra. Zapata
                        </div>
                    </div>
                </div>
            
            </div>

            <div class="payment-section">
                <h3>PAYMENTS</h3>
                <p>No pending payments.</p>
            </div>
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

        document.addEventListener('DOMContentLoaded', function() {
    var dropdownButtons = document.querySelectorAll('.dropdown-btn');

    dropdownButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Toggle active class on the button
            this.classList.toggle('active');

            // Find the next sibling dropdown container
            var dropdownContainer = this.nextElementSibling;
            
            // Toggle dropdown visibility
            if (dropdownContainer.style.display === 'block') {
                dropdownContainer.style.display = 'none';
            } else {
                dropdownContainer.style.display = 'block';
            }
        });
    });
});
    </script>
</body>
</html>