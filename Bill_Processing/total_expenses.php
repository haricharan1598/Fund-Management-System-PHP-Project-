<?php
include('db.php');

// Fetch data from fo_accepted_bills with status "Approved" and calculate total expenses
$sql = "SELECT Budget_Head, Department, SUM(Amount) AS total_expenses
        FROM fo_accepted_bills
        WHERE status = 'Approved'
        GROUP BY Budget_Head, Department";

$result = $conn->query($sql);

// Update total_expenses in sanctioned_amounts table
while ($row = $result->fetch_assoc()) {
    $budgetHead = $row['budget_head'];
    $department = $row['department'];
    $totalAmount = $row['total_expenses'];

    // Update total_expenses in sanctioned_amounts table
    $updateSql = "UPDATE sanctioned_amounts
                  SET total_expenses = $totalAmount
                  WHERE budget_head = '$budgetHead'
                  AND department = '$department'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Total expenses updated successfully for $budgetHead and $department.<br>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
