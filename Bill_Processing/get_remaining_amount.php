<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $budgetHead = $_POST["budget_head"];
    $department = $_POST["department"];

    // Fetch remaining amount from the 'sanctioned_amounts' table
    $remainingAmountQuery = "SELECT remaining_amount FROM sanctioned_amounts WHERE budget_head = '$budgetHead' AND department = '$department'";
    $remainingAmountResult = mysqli_query($conn, $remainingAmountQuery);

    if ($remainingAmountResult && mysqli_num_rows($remainingAmountResult) > 0) {
        $remainingAmountRow = mysqli_fetch_assoc($remainingAmountResult);
        echo $remainingAmountRow['remaining_amount'];
    } else {
        echo "0";
    }
}
?>
