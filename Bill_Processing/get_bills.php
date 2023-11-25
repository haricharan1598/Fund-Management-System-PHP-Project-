<?php
// Database connection parameters
include('db.php');

// SQL query to fetch data from the "bills" table
$sql = "SELECT * FROM bills";

// Execute the query
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bills</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>View Bills</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Bill Number</th>
            <th>Vendor Name</th>
            <th>Vendor Company</th>
            <th>Phone Number</th>
            <th>Amount</th>
            <th>Department</th>
            <th>Invoice Date</th>
            <th>Created At</th>
            <th>Status</th>
            <th>User ID</th>
            <th>Budget Head</th>
        </tr>
        <?php
        // Fetch and display data from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['bill_number'] . "</td>";
            echo "<td>" . $row['vendor_name'] . "</td>";
            echo "<td>" . $row['vendor_company'] . "</td>";
            echo "<td>" . $row['phone_number'] . "</td>";
            echo "<td>" . $row['amount'] . "</td>";
            echo "<td>" . $row['department'] . "</td>";
            echo "<td>" . $row['invoice_date'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['Budget Head'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
