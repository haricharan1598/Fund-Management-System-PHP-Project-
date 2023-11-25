<?php
session_start();

// Database connection parameters
include('db.php');

if (isset($_GET["id"])) {
    $billId = $_GET["id"];

    // Query to delete the bill from the "bills" table
    $deleteQuery = "DELETE FROM bills WHERE id = $billId";

    if (mysqli_query($conn, $deleteQuery)) {
        // Bill deleted successfully, you can redirect to a success page or back to the list of bills
        header("Location: view.php"); // Redirect to the list of bills
        exit();
    } else {
        echo "Error deleting bill: " . mysqli_error($conn);
    }
} else {
    // Handle the case where the bill ID is not provided in the URL
    echo "Bill ID is missing.";
}
?>
