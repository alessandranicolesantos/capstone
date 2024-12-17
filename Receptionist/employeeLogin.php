<?php
require_once('db_users_employee.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="employeeLogin.css">
    <!-- css for user type -->
    <style>
    .input-box select {
        width: 100%;
        padding: 14px;
        border-radius: 8px;
        background-color: #f0f0f0;
        border: none;
    }
</style>
</head>
<body>
    <div class="wrapper">
        <form action="employeeLogin.php" method="post"> 
            <!-- Add a flex container for the logo and text -->
            <div class="logo-text">
                <img src="pfp.jpg" alt="Profile Picture" class="profile-pic">
                <div>
                    <h1>CHARMING SMILE</h1>
                    <p>DENTAL CLINIC</p>
                </div>
            </div>
            <p1>Login into your account</p1>

            <!-- User Type Selection -->
            <p>Select User Type</p>
            <div class="input-box">
                <select name="usertype" id="usertype" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="dentist">Dentist</option>
                    <option value="clinic_receptionist">Clinic Receptionist</option>
                </select>
                <?php if (!empty($errors['usertype'])): ?>
                    <div class='error-message'><?php echo htmlspecialchars($errors['usertype']); ?></div>
                <?php endif; ?>
            </div>

            <!-- Username field -->
            <p>Username</p>
            <div class="input-box">
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
                <img src="user.png" alt="User Icon" class="icon">
                <?php if (!empty($errors['username'])): ?>
                    <div class='error-message'><?php echo htmlspecialchars($errors['username']); ?></div>
                <?php endif; ?>
            </div>
            <!-- Password field -->
            <p>Password</p>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <img src="password.png" alt="Password Icon" class="icon">
                <?php if (!empty($errors['password'])): ?>
                    <div class='error-message'><?php echo htmlspecialchars($errors['password']); ?></div>
                <?php endif; ?>
            </div>
        
            <!-- Forgot password and buttons -->
            <div class="extras">
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            <button type="submit" id="login" name="login" class="btn login-btn">Login Now</button>
            <div class="divider">
                <span>OR</span>
            </div>            
            <a href="employeeSignup.php" class="btn signup-btn">Signup Now</a>
        </form>
    </div>
    
</body>
</html>
