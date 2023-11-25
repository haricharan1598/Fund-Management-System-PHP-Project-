<?php
session_start();
include('db.php');

// Check if the user is logged in as an Office Superintendent (you can replace 'user_type' with your actual user type)
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Office Superintendent") {
    header("Location: case_worker_login.php"); // Redirect to login page or unauthorized page
    exit();
}



if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];
    $query = "SELECT * FROM cw_accepted_bills WHERE bill_id = '$bill_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error fetching bill details: " . mysqli_error($conn);
        exit();
    }

    $bill = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve updated values from the form
        $amount = $_POST['amount']; // Add more fields as needed

        // Update the bill in the database
        $update_query = "UPDATE cw_accepted_bills SET amount = '$amount' WHERE bill_id = '$bill_id'";

        if (mysqli_query($conn, $update_query)) {
            echo "Bill updated successfully.";
        } else {
            echo "Error updating bill: " . mysqli_error($conn);
        }
    }
} else {
    echo "Bill ID not provided.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Bill</title>
</head>
<body>
    <h2>Update Bill</h2>
    <form method="post" action="">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="<?php echo $bill['amount']; ?>"><br><br>
        <!-- Add more fields for updating bill details as needed -->

        <input type="submit" value="Update Bill">
    </form>
</body>
</html>
