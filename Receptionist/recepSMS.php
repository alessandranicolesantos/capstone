<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="adminStyles.css"> 
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
                <li><span onclick="window.location.href='recepDashboard.php';"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
                <li><span onclick="window.location.href='recepManagement.php';"><i class="fas fa-users"></i> User Management</span></li>
                <li><span onclick="window.location.href='patCalendar.php';"><i class="fas fa-calendar-alt"></i> Calendar</span></li>
                <li><span onclick="window.location.href='recepPayment.php';"><i class="fas fa-credit-card"></i> Payments</span></li>
                <li class="active"><span onclick="window.location.href='recepSMS.php';"><i class="fas fa-sms"></i> SMS</span></li>
                <li><span onclick="window.location.href='policy.php';"><i class="fas fa-file-alt"></i> Policy</span></li>
            </ul>
        </div>    

        <!-- Main Content -->
        <div class="main-content">
            <div class="user-management">
                <h2>Manage SMS - SMS Settings</h2>

                <!-- Main User Table -->
                <div class="user-table">
                    <div class="w-4/5 p-8">
                        <div class="bg-white p-8 rounded shadow-md">
                         <h3 class="text-xl font-bold text-[#8B5D5D] mb-4">
                          Send Appointment Reminder
                         </h3>
                         <form>
                          <div class="mb-4">
                           <label class="block text-[#8B5D5D] font-bold mb-2">
                            Select Accepted Appointment:
                           </label>
                           <select class="w-full p-2 border rounded">
                            <option>
                             Nicole Santos 09/25/24 at 1:00 PM
                            </option>
                           </select>
                          </div>
                          <div class="mb-4">
                           <label class="block text-[#8B5D5D] font-bold mb-2">
                            Patient's Phone No.:
                           </label>
                           <input class="w-full p-2 border rounded" type="text" value="09123456789"/>
                          </div>
                          <div class="mb-4">
                           <label class="block text-[#8B5D5D] font-bold mb-2">
                            Select Template:
                           </label>
                           <select class="w-full p-2 border rounded">
                            <option>
                             General Template
                            </option>
                           </select>
                          </div>
                          <div class="mb-4">
                           <label class="block text-[#8B5D5D] font-bold mb-2">
                            Message:
                           </label>
                           <textarea class="w-full p-2 border rounded" rows="4">Good Day Nicole, this is a reminder for your dental check-up appointment on 2024-09-24 at 1:00 PM.</textarea>
                          </div>
                          <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">
                           Send SMS
                          </button>
                         </form>
                        </div>
                       </div>
                </div>

                <!-- Edit User Modal -->
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeEditModal()">&times;</span>
                        <h2>Edit User</h2>
                        <label for="editUsername">Username:</label>
                        <input type="text" id="editUsername">
                        <label for="editPassword">Password:</label>
                        <input type="password" id="editPassword">
                        <label for="editUserType">User Type:</label>
                        <select id="editUserType">
                            <option value="Admin">Admin</option>
                            <option value="Dentist">Dentist</option>
                            <option value="Receptionist">Receptionist</option>
                            <option value="Patient">Patient</option>
                        </select>
                        <button type="button" onclick="saveEdit()">Save</button>
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
