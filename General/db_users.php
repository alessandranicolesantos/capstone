<?php
 session_start();
 
 $username = "";
 $email    = "";
 $usertype ="";
 $errors = array(); 

 // connect to the database
 // format: host, user, password, db
 $db = mysqli_connect('localhost', 'root', '', 'db_system'); 

    if (isset($_POST["signup"])) {

        $firstName = $_POST["first-name"];
        $middleName = $_POST["middle-name"];
        $lastName = $_POST["last-name"];
        $address = $_POST["address"];
        $birthdate = $_POST["birthdate"];
        $gender = $_POST["gender"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["confirm-password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $usertype = "patient"; 

        // Validate inputs
        if (empty($firstName)) {
            $errors['first-name'] = "First name is required.";
        }
        
        if (empty($lastName)) {
            $errors['last-name'] = "Last name is required.";
        }
        
        if (empty($address)) {
            $errors['address'] = "Address is required.";
        }
        
        if (empty($mobile)) {
            $errors['mobile'] = "Mobile number is required.";
        } elseif (!preg_match('/^\+?\d{1,3}?[-.\s]?\(?\d{1,4}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/', $mobile)) {
            $errors['mobile'] = "Invalid mobile number format."; 
        }

        if (empty($birthdate)) {
            $errors['birthdate'] = "Birthdate is required.";
        }

        if (empty($gender)) {
            $errors['gender'] = "Gender selection is required.";
        }

        if (empty($email)) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email is not valid.";
        }
        
        if (empty($username)) {
            $errors['username'] = "Username is required.";
        }
        
        if (empty($password)) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($password) < 8) {
            $errors['password'] = "Password must be at least 8 characters long.";
        }
        
        if ($password !== $passwordRepeat) {
            $errors['confirm-password'] = "Passwords do not match.";
        }

        $user_check_query_email = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt_email = mysqli_prepare($db, $user_check_query_email);
        
        mysqli_stmt_bind_param($stmt_email, "s", $email);
        mysqli_stmt_execute($stmt_email);
        
        $result_email = mysqli_stmt_get_result($stmt_email);
        
        if (mysqli_fetch_assoc($result_email)) { 
            $errors['email'] = "Email already exists";
        }

        mysqli_stmt_close($stmt_email);

        // Check for existing username in a secure way
        $user_check_query_username = "SELECT * FROM users WHERE username=? LIMIT 1";
        $stmt_username = mysqli_prepare($db, $user_check_query_username);
        
        mysqli_stmt_bind_param($stmt_username, "s", $username);
        mysqli_stmt_execute($stmt_username);
        
        $result_username = mysqli_stmt_get_result($stmt_username);
        
        if (mysqli_fetch_assoc($result_username)) { 
            $errors['username'] = "Username already exists";
        }
        
        mysqli_stmt_close($stmt_username);


    if (count($errors) == 0) {
        // Insert user data to users
        $insert_query = "INSERT INTO users (first_name, middle_name, last_name, address, birthdate, gender, mobile, email, username, password, usertype) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($db, $insert_query);

        mysqli_stmt_bind_param(
            $insert_stmt,
            "sssssssssss",
            $firstName,
            $middleName,
            $lastName,
            $address,
            $birthdate,
            $gender,
            $mobile,
            $email,
            $username,
            $passwordHash,
            $usertype
        );

        mysqli_stmt_execute($insert_stmt);

        $_SESSION['success_message'] = "You are now registered";
        header('location: patLogin.php'); 
        exit(); 
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Validate inputs
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if (count($errors) == 0) {
        $sql = "SELECT id, first_name, gender, password FROM users WHERE username = ?"; 
        $stmt_login = mysqli_prepare($db, $sql);
        
        mysqli_stmt_bind_param($stmt_login, "s", $username);
        mysqli_stmt_execute($stmt_login);
        
        $result_login = mysqli_stmt_get_result($stmt_login);
        if ($user = mysqli_fetch_assoc($result_login)) {
            if (password_verify($password, $user['password'])) {
                
                $_SESSION['id'] = htmlspecialchars($user['id']);
                $_SESSION['first_name'] = htmlspecialchars($user['first_name']);
                $_SESSION['gender'] = htmlspecialchars($user['gender']);
                $_SESSION['success'] = "You are now logged in";

                header('location: patDashboard.php'); 
                exit();
            } else {
                array_push($errors, "Invalid username or password.");
                $errors['username'] = "Invalid username or password.";
            }
        } else {
            array_push($errors, "Invalid username or password.");
        }
    }

    mysqli_stmt_close($stmt_login); 
}
?>