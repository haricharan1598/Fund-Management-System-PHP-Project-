<?php
include('db.php');
// Fetch fields from the 'sanctioned_amounts' table
$sql = "SELECT id, budget_head, department, amount, remaining_amount FROM sanctioned_amounts";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>View Sanctioned Amounts</title>
</head>
<body>
    <h2 style="text-align: center;">Sanctioned Amounts</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Budget Head</th>
            <th>Department</th>
            <th>Amount</th>
            <th>Remaining Amount</th>
        </tr>

        <?php
        // Display data from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['budget_head']}</td>";
            echo "<td>{$row['department']}</td>";
            echo "<td>{$row['amount']}</td>";
            echo "<td>{$row['remaining_amount']}</td>";
            echo "</tr>";
        }

        // Free result set
        mysqli_free_result($result);

        // Close connection
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
