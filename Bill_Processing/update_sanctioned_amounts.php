<?php
include('db.php'); // Include your database connection file

// Update total_expenses based on the calculation: SUM(amount) for each budget_head and department
$update_total_expenses_query = "
    UPDATE sanctioned_amounts AS sa
    SET sa.total_expenses = (
        SELECT IFNULL(SUM(fb.amount), 0) 
        FROM fo_accepted_bills AS fb
        WHERE fb.budget_head = sa.budget_head 
        AND fb.department = sa.department
    )
";

// Run the query to update total_expenses
if (mysqli_query($conn, $update_total_expenses_query)) {
    echo "Total expenses updated successfully.<br>";

    // Calculate remaining_amount in PHP
    $select_sanctioned_amounts_query = "SELECT * FROM sanctioned_amounts";
    $result_sanctioned_amounts = mysqli_query($conn, $select_sanctioned_amounts_query);

    while ($row = mysqli_fetch_assoc($result_sanctioned_amounts)) {
        $amount = $row['amount'];
        $total_expenses = $row['total_expenses'];
        $remaining_amount = $amount - $total_expenses;

        // Update remaining_amount in the database
        $update_remaining_amount_query = "
            UPDATE sanctioned_amounts
            SET remaining_amount = $remaining_amount
            WHERE budget_head = '{$row['budget_head']}' AND department = '{$row['department']}'
        ";

        if (mysqli_query($conn, $update_remaining_amount_query)) {
            echo "Remaining amount for Budget Head '{$row['budget_head']}', Department '{$row['department']}' updated successfully. New value: $remaining_amount<br>";
        } else {
            echo "Error updating remaining amount: " . mysqli_error($conn) . "<br>";
            // Print the problematic query for further investigation
            echo "Query: " . $update_remaining_amount_query . "<br>";
        }
    }
} else {
    echo "Error updating total expenses: " . mysqli_error($conn) . "<br>";
    // Print the problematic query for further investigation
    echo "Query: " . $update_total_expenses_query . "<br>";
}

// Close the database connection
mysqli_close($conn);
?>
