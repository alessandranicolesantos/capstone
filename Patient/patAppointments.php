<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Charming Smile Dental Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="patAppointments.css"> 
    <script src="AdminScript.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
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
                <li><span onclick="window.location.href='patDashboard.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
                <button class="dropdown-btn">
                    <span onclick="window.location.href='patCalendar.php';"><i class="fas fa-calendar-alt"></i> Calendar <i class="fas fa-chevron-down dropdown-icon"></i></span>
                </button>
                    <ul class="dropdown-container">
                        <li><span onclick="window.location.href='patAppointments.php';"><i class="fas fa-notes-medical"></i> Appointments</span></li>
                    </ul>
                <li><span onclick="window.location.href='patRecord.php';"><i class="fas fa-user"></i> Patient Record</span></li>
                <li><span onclick="window.location.href='patPayment.php';"><i class="fas fa-credit-card"></i> Payment</span></li>
                <li><span onclick="window.location.href='patPolicy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>    

        <!-- Main Content -->
        <div class="main-content">
            <div class="user-management">
                <div class="appointments-section">
                    <div class="appointments-header">
                        <h2>Today's Appointments</h2>
                        <div class="header-controls">
                            <select class="sort-dropdown">
                                <option>Sort by:</option>
                                <option>Date: Newest First</option>
                                <option>Date: Oldest First</option>
                                <option>Status</option>
                            </select>
                            <input type="text" class="search-bar" placeholder="Search by name">
                        </div>
                    </div>

                    <div class="appointments-tabs">
                        <button class="tab active">Upcoming</button>
                        <button class="tab">Completed</button>
                        <button class="tab">Re-scheduled</button>
                        <button class="tab">Cancelled</button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Appointment ID</th>
                                <th>Treatment</th>
                                <th>Dentist</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09/24/24<br>2:00 PM - 3:00 PM</td>
                                <td>#A046</td>
                                <td>Regular Checkup</td>
                                <td>Dra. Zapata</td>
                                <td><span class="status">Upcoming</span></td>
                                <td class="action-buttons">
                                    <button class="btn-reschedule">Re-schedule</button>
                                    <button class="btn-cancel">Cancel</button>
                                </td>
                            </tr>
                            <tr>
                                <td>09/29/24<br>8:30 AM - 9:00 AM</td>
                                <td>#A050</td>
                                <td>Regular Checkup</td>
                                <td>Dra. Zapata</td>
                                <td><span class="status">Upcoming</span></td>
                                <td class="action-buttons">
                                    <button class="btn-reschedule">Re-schedule</button>
                                    <button class="btn-cancel">Cancel</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
