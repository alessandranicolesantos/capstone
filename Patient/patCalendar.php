<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'db_system');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$services_query = "SELECT treatment_name FROM treatment"; 
$services_result = mysqli_query($db, $services_query);

$dentists_query = "SELECT CONCAT(first_name, middle_name, last_name) AS full_name FROM dentists"; 
$dentists_result = mysqli_query($db, $dentists_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Integration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="patStyles.css"> 
    <script src="AdminScript.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

    <style>
        /* Styling for the mini calendar and form */
        .calendar-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
            justify-content: space-between;
            margin-top: 20px;
            flex-wrap: wrap; /* Allow the content to wrap if necessary */
        }

        .mini-calendar, .appointment-form {
            background-color: #fdf2f4; /* Light background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 300px; /* Ensure each section has a minimum width */
        }

        .mini-calendar {
            max-width: 400px; /* Limit the size of the mini calendar */
        }

        .mini-calendar select {
            display: inline-block;
            width: 45%;
            margin: 5px 5% 20px 0;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .mini-calendar table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .mini-calendar th, .mini-calendar td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .mini-calendar th {
            background-color: #f8d7da;
            color: #721c24;
        }

        .mini-calendar td {
            cursor: pointer;
        }

        .mini-calendar td:hover {
            background-color: #fdecea;
        }

        .appointment-form select,
        .appointment-form input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .appointment-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .appointment-form button:hover {
            background-color: #0056b3;
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
        <li>
            <span onclick="window.location.href='patDashboard.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</span>
        </li>
        <button class="dropdown-btn">
            <span onclick="window.location.href='patCalendar.php';"><i class="fas fa-calendar-alt"></i> Calendar <i class="fas fa-chevron-down dropdown-icon"></i></span>
        </button>
            <ul class="dropdown-container">
                <li><span onclick="window.location.href='patAppointments.php';"><i class="fas fa-notes-medical"></i> Appointments</span></li>
            </ul>
        <li>
            <span onclick="window.location.href='patRecord.php';"><i class="fas fa-user"></i> Patient Record</span>
        </li>
        <li>
            <span onclick="window.location.href='patPayment.php';"><i class="fas fa-credit-card"></i> Payments</span>
        </li>
        <li>
            <span onclick="window.location.href='patPolicy.php';"><i class="fas fa-file-alt"></i> Policy</span>
        </li>
    </ul>
</div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="user-management">
            <form id="appointmentForm" method="POST" action="submit_appointment.php">
                <h2>Calendar and Appointment Management</h2>
                <div class="calendar-container">
                    <!-- Mini Calendar Section -->
                    <div class="mini-calendar">
                        <h3>Calendar</h3>

                        <!-- Month and Year Selector -->
                        <div>
                            <select id="month-selector">
                                <option value="0">January</option>
                                <option value="1">February</option>
                                <option value="2">March</option>
                                <option value="3">April</option>
                                <option value="4">May</option>
                                <option value="5">June</option>
                                <option value="6">July</option>
                                <option value="7">August</option>
                                <option value="8">September</option>
                                <option value="9">October</option>
                                <option value="10">November</option>
                                <option value="11">December</option>
                            </select>

                            <select id="year-selector">
                                <!-- Dynamically populate years -->
                            </select>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Sun</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                </tr>
                            </thead>
                            <tbody id="calendar-body">
                                <!-- Calendar rows dynamically generated -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Appointment Form Section -->
                    <div class="appointment-form">
                        <h3>Book an Appointment</h3>
                        <label for="service">Select Service:</label>
                        <select id="service" name="service_name">
                            <option value="" disabled selected>Select a service</option>
                            <?php while ($row_service = mysqli_fetch_assoc($services_result)): ?>
                                <option value="<?php echo htmlspecialchars($row_service['treatment_name']); ?>">
                                    <?php echo htmlspecialchars($row_service['treatment_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label for="dentist">Select Dentist:</label>
                        <select id="dentist">
                            <option value="" disabled selected>Select a dentist</option>
                            <?php while ($row_dentist = mysqli_fetch_assoc($dentists_result)): ?>
                                <option value="<?php echo htmlspecialchars($row_dentist['full_name']); ?>">
                                    <?php echo htmlspecialchars($row_dentist['full_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label for="timeslot">Available Time Slots:</label>
                        <div>
                            <input type="radio" id="slot1" name="timeslot" value="9:00 AM">
                            <label for="slot1">9:00 AM - 9:30 AM</label><br>
                            <input type="radio" id="slot2" name="timeslot" value="1:00 PM">
                            <label for="slot2">1:00 PM - 1:30 PM</label><br>
                            <input type="radio" id="slot3" name="timeslot" value="1:30 PM">
                            <label for="slot3">1:30 PM - 2:00 PM</label>
                        </div>

                        <button type="submit">Submit Appointment</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
    </body>

    <script>
        // JavaScript for dynamically populating the year selector and calendar
const yearSelector = document.getElementById('year-selector');
const monthSelector = document.getElementById('month-selector');
const calendarBody = document.getElementById('calendar-body');

// Set the starting year to 2025
const startingYear = 2025;
const currentYear = new Date().getFullYear();

// Populate year options starting from 2025
for (let i = 0; i < 100; i++) {
    const yearOption = document.createElement('option');
    yearOption.value = startingYear + i;
    yearOption.textContent = startingYear + i;
    yearSelector.appendChild(yearOption);
}

// Function to generate calendar for selected month and year
function generateCalendar() {
    const month = monthSelector.value;
    const year = yearSelector.value;

    // Get the first day of the selected month
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    const daysInMonth = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();

    let calendarHTML = '';
    let day = 1;

    // Create empty cells for the leading days of the month
    for (let i = 0; i < firstDayIndex; i++) {
        calendarHTML += '<td></td>';
    }

    // Generate calendar days
    for (let i = firstDayIndex; i < 7; i++) {
        calendarHTML += `<td>${day}</td>`;
        day++;
    }

    // Generate subsequent rows
    while (day <= daysInMonth) {
        calendarHTML += '<tr>';
        for (let i = 0; i < 7; i++) {
            if (day <= daysInMonth) {
                calendarHTML += `<td>${day}</td>`;
                day++;
            } else {
                calendarHTML += '<td></td>';
            }
        }
        calendarHTML += '</tr>';
    }

    calendarBody.innerHTML = calendarHTML;
}

// Event listener to generate calendar on month/year change
monthSelector.addEventListener('change', generateCalendar);
yearSelector.addEventListener('change', generateCalendar);

// Initialize calendar with current month and year
monthSelector.value = new Date().getMonth();
yearSelector.value = currentYear;

// Generate initial calendar
generateCalendar();

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
