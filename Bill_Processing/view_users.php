<?php
// Database connection
$host = "localhost"; // Change to your database host
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$database = "bill_process"; // Your database name

$conn = mysqli_connect($host, $username, $password, $database);

$success_message = "";
$error_message = "";

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_user'])) {
    $id = $_POST['id'];
    
    // Display a confirmation dialog using JavaScript
    echo "<script>
        if (confirm('Are you sure you want to remove this user?')) {
            window.location.href = 'view_users.php?id=$id';
        }
    </script>";
    exit();
}

// Check if the user ID is provided for removal
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM logins WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        $success_message = "User successfully removed";
    } else {
        $error_message = "Error deleting user: " . mysqli_error($conn);
    }
}

// Get all login entries
$sql = "SELECT * FROM logins";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Entries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: #5584AC;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background: #f4f4f4;
        }

        .remove-btn {
            background: #d9534f;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>

<h2>Login Entries</h2>

<?php if (!empty($success_message)) : ?>
    <div style="text-align: center; background: #5cb85c; color: #fff; padding: 10px;">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)) : ?>
    <div style="text-align: center; background: #d9534f; color: #fff; padding: 10px;">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>User Type</th>
        <th>User ID</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['user_type']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['phone_number']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button class="remove-btn" type="submit" name="remove_user">Remove</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
