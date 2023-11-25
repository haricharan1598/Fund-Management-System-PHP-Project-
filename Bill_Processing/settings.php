<?php
session_start();

// Database connection parameters
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: case_worker_login.php"); // Redirect to the login page if not logged in
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION["user_id"];

// Check if the "Update" button is clicked
if (isset($_POST["update"])) {
    $newName = mysqli_real_escape_string($conn, $_POST["new_name"]);
    $newEmail = mysqli_real_escape_string($conn, $_POST["new_email"]);
    $newPhoneNumber = mysqli_real_escape_string($conn, $_POST["new_phone_number"]);
    $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT); // You should hash and salt the password for security.

    // Update the case worker's details in the database
    $updateQuery = "UPDATE case_workers SET name = '$newName', email = '$newEmail', phone = '$newPhoneNumber', password = '$newPassword' WHERE user_id = '$user_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Details updated successfully
        echo "<script>alert('Case worker details updated successfully.');</script>";
    } else {
        echo "Error updating case worker details: " . mysqli_error($conn);
    }
}

// Query to retrieve the case worker's details from the case_workers table
$caseWorkerQuery = "SELECT * FROM case_workers WHERE user_id = '$user_id'";
$caseWorkerResult = mysqli_query($conn, $caseWorkerQuery);

if (!$caseWorkerResult) {
    // Handle the query error (e.g., display an error message)
    echo "Error fetching case worker details: " . mysqli_error($conn);
    exit();
}

// Fetch the case worker's details
$caseWorkerDetails = mysqli_fetch_assoc($caseWorkerResult);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Case Worker Profile</title>
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
            margin-top: 20px;
        }
        
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #888888;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Case Worker Profile</h2>
    <form method="POST" action="">
        <label for="new_name">New Name:</label>
        <input type="text" name="new_name" value="<?php echo $caseWorkerDetails['name']; ?>" required>

        <label for="new_email">New Email:</label>
        <input type="email" name="new_email" value="<?php echo $caseWorkerDetails['email']; ?>" required>

        <label for="new_phone_number">New Phone Number:</label>
        <input type="text" name="new_phone_number" value="<?php echo $caseWorkerDetails['phone']; ?>" required>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
