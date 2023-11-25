<?php
session_start();
include_once('db.php');

// Check if the user is logged in (you can adapt this check to your login mechanism)
if (!isset($_SESSION["user_id"])) {
    header("Location: case_worker_login.php"); // Redirect to the login page if not logged in
    exit();
}



$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the POST request
    $bill_id = $_POST["bill_id"];
    $remarks = $_POST["remarks"];

   // Insert the accepted bill and remarks into the 'accepted_bills' table
$insert_query = "INSERT INTO accepted_bills (bill_id, remarks) VALUES ('$bill_id', '$remarks')";

if (mysqli_query($conn, $insert_query)) {
    // Successfully inserted
    echo "Bill accepted and remarks saved successfully.";
} else {
    // Error inserting
    echo "Error accepting bill: " . mysqli_error($conn);
}
}

// Close the database connection
mysqli_close($conn);
?>
