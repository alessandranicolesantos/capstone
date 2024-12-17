<?php
session_start(); 
include 'config.php'; 

if (!isset($_SESSION['id'])) {
    header('location: patLogin.php'); 
    exit();
}

$id = $_SESSION['id']; 
$query = "SELECT first_name, middle_name, last_name, email, gender, birthdate, mobile, address FROM users WHERE id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    $firstName = htmlspecialchars($user['first_name']);
    $middleName = htmlspecialchars($user['middle_name']);
    $lastName = htmlspecialchars($user['last_name']);
    $email = htmlspecialchars($user['email']);
    $gender = htmlspecialchars($user['gender']);
    $birthdate = htmlspecialchars($user['birthdate']);
    $mobile = htmlspecialchars($user['mobile']);
    $address = htmlspecialchars($user['address']);
} else {
    echo "No user found.";
}

mysqli_stmt_close($stmt); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charming Smile Dental Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="patRecord.css">
    <script src="AdminScript.js" defer></script>
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
                <li><span onclick="window.location.href='patPayment.php';"><i class="fas fa-credit-card"></i> Payment</li></span>
                <li><span onclick="window.location.href='patPolicy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="patient-details">
                <div class="patient-header">
                    <div class="patient-avatar">
                        <i class="fas fa-user-circle fa-3x"></i>
                    </div>
                    <div class="patient-info">
                        <h3><?php echo "$firstName $middleName $lastName"; ?></h3>
                        <p><?php echo $email; ?></p>
                    </div>
                </div>
                <div class="patient-info-grid">
                    <div><strong>Gender:</strong> <?php echo $gender; ?></div>
                    <div><strong>Birthdate:</strong> <?php echo $birthdate; ?> </div>
                    <div><strong>Phone no.:</strong> <?php echo $mobile; ?></div>
                    <div><strong>Address:</strong> <?php echo $address; ?></div>
                </div>
                <div class="appointments-section">
                    <button class="tab-button active">Upcoming Appointments</button>
                    <button class="tab-button">Follow-Up Appointments</button>
                    <div class="appointment-card">
                        <p><strong>24 Sep 2024</strong></p>
                        <p>2:00PM - 3:00PM</p>
                        <p><strong>Treatment:</strong> Dental implant</p>
                        <p><strong>Dentist:</strong> Dra. Zapata</p>
                    </div>
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
