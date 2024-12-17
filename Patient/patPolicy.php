<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="patPolicy.css"> 
    <script src="AdminScript.js" defer></script>
    <style>

    </style>
</head>
<body>
    <div class="top-header">
        <div class="logoDental">
            <div>
                <div style="font-weight: bold;">CHARMING SMILE</div>
                <div style="font-size: 0.9rem;">DENTAL CLINIC</div>
            </div>
        </div>
        <div class="user-info">
            <div class='current-datetime'> 
                <span id="datetime"></span>
            </div>
            <div class="profile"><i class="fas fa-user-circle"></i></div>
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
                <li><span onclick="window.location.href='patPolicy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="user-management">
                <!-- Policies Title Box -->
                <div class="policy-title-box">
                    <h1>Policies</h1>
                </div>
        
                <!-- Main Content Box -->
                <div class="policy-content-box">
                    <div class="section">
                        <h2 class="section-title">Terms and Conditions</h2>
                        <div class="section-content">
                            Welcome to our online dental clinic appointment system. By accessing and using this system, you agree to be bound by these terms and conditions. If you do not agree with any part of these terms, please do not use our online appointment system.
                        </div>
                    </div>
        
                    <div class="section">
                        <h2 class="section-title">Timezone</h2>
                        <div class="section-content">
                            All appointment times are displayed and recorded in the Philippine Time (GMT +8). It is the responsibility of the patient to ensure they book appointments in the correct time zone.
                        </div>
                    </div>
        
                    <div class="section">
                        <h2 class="section-title">Reservation Policy</h2>
                        <div class="section-content">
                            <ul>
                                <li>Appointments are charged with 20% downpayment of service to avoid no-show appointments.</li>
                                <li>A valid email address and contact number is required to complete the booking process.</li>
                                <li>Patients must provide complete and accurate information when booking appointments.</li>
                                <li>Patients under the age of 18 must have a parent or legal guardian book their appointment.</li>
                            </ul>
                        </div>
                    </div>
        
                    <div class="section">
                        <h2 class="section-title">Cancellation Policy</h2>
                        <div class="section-content">
                            <ul>
                                <li>Appointments must be cancelled at least 24 hours prior to the scheduled time.</li>
                                <li>Patients who fail to show up for an appointment or cancel with less than 24 hours notice will be charged at least 20% of the dental treatment fee for no-show.</li>
                            </ul>
                        </div>
                    </div>
        
                    <div class="section">
                        <h2 class="section-title">User Data Privacy</h2>
                        <div class="section-content">
                            <ul>
                                <li>All patient information is kept confidential and secure.</li>
                                <li>Patient data will not be shared with any third parties without explicit consent.</li>
                                <li>According to the Data Privacy Act of 2012, personal data such as appointment records are retained for as long as necessary for the purposes for which it was collected.</li>
                                <li>Patients have the right to access their records upon request.</li>
                            </ul>
                        </div>
                    </div>
        
                    <div class="section-content">
                        By booking an appointment, you acknowledge that you have read, understood, and agree to abide by these terms and conditions. We reserve the right to modify these terms at any time. Your continued use of the online appointment system indicates your acceptance of any changes.
                    </div>
        
                    <div class="contact-info">
                        If you have any questions or concerns, please contact our office at 0915-123-4567 or charmingsmiledc@gmail.com
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
        