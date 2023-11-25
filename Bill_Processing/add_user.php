<?php
session_start();

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];

    // Validate phone number format (10 digits)
    if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) {
        $error_message = "Please enter a valid 10-digit phone number.";
    } else {
        // Perform input validation (e.g., check if passwords match)

        // Hash the password for security (you should use better hashing methods)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generate a random 4-digit code starting with "FD" for user_id
        $user_id = "FD" . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Insert the user into the "logins" table, including the "phone_number" field
        $insert_query = "INSERT INTO logins (username, password, user_type, phone_number, email, user_id) VALUES ('$username', '$hashedPassword', '$userType', '$phoneNumber', '$email', '$user_id')";

        if (mysqli_query($conn, $insert_query)) {
            // Email configuration
            $to = $email;
            $subject = 'Your User ID and Password';
            $message = "Your User ID: $user_id\nYour Password: $password";
            $headers = 'From: your_email@example.com' . "\r\n" .
                       'Reply-To: your_email@example.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            // Send the email
            if (mail($to, $subject, $message, $headers)) {
                echo "User added successfully. An email with user details has been sent.";
            } else {
                echo "User added successfully, but there was an error sending the email.";
            }
        } else {
            echo "Error adding user: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            height: 40px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<h2>Add User</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label> 
        <input type="password" id="password" name="password" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" title="Please enter a 10-digit phone number (digits only)">

        <label for="password">Email:</label> 
        <input type="text" id="email" name="email" required>

        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type">
            <option value="Office Superintendent">Office Superintendent</option>
            <option value="Deputy Finance Officer">Deputy Finance Officer</option>
            <option value="Finance Officer">Finance Officer</option>
        </select>

        <input type="submit" value="Add User">
    </form>
</body>
</html>