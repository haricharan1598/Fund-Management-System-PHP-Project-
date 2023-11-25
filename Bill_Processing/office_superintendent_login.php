<?php
session_start();

// Database connection parameters
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    // Check the credentials in the database
    $query = "SELECT * FROM logins WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["password"];
        $userType = $row["user_type"]; // Get the user type from the database

        // Verify the hashed password and user type
        if (password_verify($password, $hashedPassword)) {
            // Check user type and redirect accordingly
            if ($userType == "Office Superintendent") {
                $_SESSION["user_id"] = $user_id;
                header("Location: office_superintendent_dashboard.php"); // Redirect to the Office Superintendent dashboard
                exit();
            } elseif ($userType == "Deputy Finance Officer") {
                $_SESSION["user_id"] = $user_id;
                header("Location: deputy_finance_officer_dashboard.php"); // Redirect to the Deputy Finance Officer dashboard
                exit();
            } elseif ($userType == "Finance Officer") {
                $_SESSION["user_id"] = $user_id;
                header("Location: finance_officer_dashboard.php"); // Redirect to the Finance Officer dashboard
                exit();
            } else {
                $error_message = "Unknown user type.";
            }
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "User not found.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #007bff;
            padding: 20px 0;
            text-align: center;
        }

        .header img {
            max-width: 100px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .error {
            color: #ff0000;
            text-align: center;
        }

        form {
            max-width: 250px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #888888;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="header">
        <img src="images\Tumkur_University_logo.jpg" alt="Tumkur University Logo">
    </div>

    <h2>User Login</h2>
    <?php if (isset($error_message)) : ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="office_superintendent_login.php">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</body>
</html>
