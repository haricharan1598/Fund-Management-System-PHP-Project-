<?php
session_start();

// Database connection parameters
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    // Check the credentials in the database
    $query = "SELECT * FROM case_workers WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["password"];

        // Verify the hashed password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user_id"] = $user_id;
            header("Location: case_worker_dashboard.php"); // Redirect to the dashboard upon successful login
            exit();
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
    <title>Case Worker Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            color: #333;
        }
        
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 25px; /* Reduced the height by changing the top and bottom padding values */
        }
        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 100px; /* Adjust the size as needed */
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #888888;
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
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

        p.error {
            color: red;
        }
    </style>
</head>
<body>
<div class="header">
<div class="logo">
<img src="images\Tumkur_University_logo.jpg" alt="Tumkur University Logo">
</div>
</div>
    <h2>Case Worker Login</h2>
    <?php if (isset($error_message)) : ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="case_worker_login.php">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
