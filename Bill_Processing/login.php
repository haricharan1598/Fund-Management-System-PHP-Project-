<?php
// Database connection parameters
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    // $confirmPassword = $_POST["confirm_password"]; // New Confirm Password field

    // Fixed admin user details
    $fixedUsername = "admin";
    $fixedPasswordHash = password_hash('rootadmin', PASSWORD_DEFAULT); // Hashed password for 'rootadmin'

    // Check if the entered username and password match the fixed admin details
    if ($username === $fixedUsername && password_verify($password, $fixedPasswordHash)) {
          // Successfully logged in
          header("Location: index.php"); // Redirect to index.php
          exit();
    } else {
        // Invalid credentials
        echo "Login failed. Please check your username and password.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        .header img {
            max-width: 70%;
            height: 30%;
        }

        .login-container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff0000;
            margin-top: 10px;
        }
    </style>
    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            // var confirmPassword = document.getElementById("confirm_password").value;
            var errorMessage = document.getElementById("error-message");

            if (username.trim() === "" || password.trim() === "" || confirmPassword.trim() === "") {
                errorMessage.textContent = "Username, password, and confirm password are required.";
                return false;
            }

            if (password !== confirmPassword) {
                errorMessage.textContent = "Password and Confirm Password do not match.";
                return false;
            }

            return true;
        }

        function showSuccessAndRedirect() {
            alert("Login successful!");
            setTimeout(function() {
                window.location.href = "index.php";
            }, 2000);
        }
    </script>
</head>
<body>

<div class="header">

    </div>

    <div class="login-container">
 <center>   <img src="images\Tumkur_University_logo.jpg" alt="Tumkur University Logo" width="20%"></center>
        <h2>Admin Login</h2>
        <form method="post" action="login.php" onsubmit="return validateForm();">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
            <p class="error-message" id="error-message"></p>
        </form>
    </div>

</body>
</html>
