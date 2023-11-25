<?php
session_start();

// Database connection parameters
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: office_superintendent_login.php"); // Redirect to the login page if not logged in as an Office Superintendent
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION["user_id"];

// Fetch the Office Superintendent's details from the 'logins' table
$loginQuery = "SELECT * FROM logins WHERE user_id = '$user_id'";
$loginResult = mysqli_query($conn, $loginQuery);

if ($loginResult) {
    $loginDetails = mysqli_fetch_assoc($loginResult);

    // Check if a user with the provided 'user_id' exists in the 'logins' table
    if ($loginDetails) {
        // Now, you can fetch the corresponding Office Superintendent details based on 'user_id'
        $osQuery = "SELECT * FROM logins WHERE user_id = '$user_id'";
        $osResult = mysqli_query($conn, $osQuery);

        if ($osResult) {
            $osDetails = mysqli_fetch_assoc($osResult);
        } else {
            // Handle the query error (e.g., display an error message)
            echo "Error fetching Office Superintendent details: " . mysqli_error($conn);
        }
    } else {
        // Handle the case where the 'user_id' from the session does not exist in the 'logins' table
        echo "User not found.";
    }
} else {
    // Handle the query error (e.g., display an error message)
    echo "Error fetching user details: " . mysqli_error($conn);
}

// Check if the "Update" button is clicked
if (isset($_POST["update"])) {
    $newName = mysqli_real_escape_string($conn, $_POST["new_name"]);
    $newEmail = mysqli_real_escape_string($conn, $_POST["new_email"]);
    $newPhoneNumber = mysqli_real_escape_string($conn, $_POST["new_phone_number"]);
    $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    // Handle image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $image = file_get_contents($_FILES["image"]["tmp_name"]); // Get the binary image data
    } else {
        // Handle cases where no image is uploaded
        $image = null;
    }

    // Update the Office Superintendent's details in the database
    $updateQuery = "UPDATE logins SET username = '$newName', email = '$newEmail', phone_number = '$newPhoneNumber', password = '$newPassword', images = ? WHERE user_id = '$user_id'";
    $updateStatement = mysqli_prepare($conn, $updateQuery);
    
    if ($updateStatement) {
        mysqli_stmt_bind_param($updateStatement, "b", $image); // "b" is used for BLOB data
        mysqli_stmt_send_long_data($updateStatement, 0, $image); // Send the image data
        $updateResult = mysqli_stmt_execute($updateStatement);

        if ($updateResult) {
            // Details updated successfully
            echo "<script>alert('Office Superintendent details updated successfully.');</script>";
        } else {
            echo "Error updating Office Superintendent details: " . mysqli_error($conn);
        }
    } else {
        echo "Error preparing the update statement: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Profile</title>
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
<h2>Manage Profile</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="new_name">New Name:</label>
    <input type="text" name="new_name" value="<?php echo $osDetails['username']; ?>" required>

    <label for="new_email">New Email:</label>
    <input type="email" name="new_email" value="<?php echo $osDetails['email']; ?>" required>

    <label for="new_phone_number">New Phone Number:</label>
    <input type="text" name="new_phone_number" value="<?php echo $osDetails['phone_number']; ?>" required>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>

    <label for="image">Profile Image:</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="update">Update</button>
</form>
</body>
</html>
