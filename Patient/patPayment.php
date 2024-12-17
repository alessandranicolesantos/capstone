<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - Charming Smile Dental Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="patStyles.css"> 
    <script src="AdminScript.js" defer></script>
    <style>
        .payment-history {
            padding: 20px;
        }

        .payment-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .payment-header h1 {
            color: #8b4513;
            margin: 0;
            font-size: 24px;
        }

        .payment-controls {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
            padding: 0 20px;
        }

        .sort-dropdown {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #8b4513;
            background: white;
        }

        .payment-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8d7da;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #8b4513;
            font-weight: 600;
        }

        td {
            color: #333;
        }

        .view-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-btn:hover {
            background-color: #0056b3;
        }

        .status {
            color: #28a745;
            font-weight: 500;
        }

        .price {
            font-weight: 500;
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
            <div class="payment-history">
                <div class="payment-header">
                    <h1>Payment History</h1>
                </div>


                <div class="payment-table">
                    <div class="payment-controls">
                        <select class="sort-dropdown">
                            <option>Sort by : Newest</option>
                            <option>Sort by : Oldest</option>
                            <option>Sort by : Price</option>
                            <option>Sort by : Name</option>
                        </select>
                    </div>
                    <table>
                        <thead>
                            <tr>
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
                                <td>A001</td>
                                <td>2024-09-02</td>
                                <td>Tooth Filling</td>
                                <td class="price">P700</td>
                                <td class="status">Paid</td>
                                <td>
                                    <button class="view-btn">View</button>
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