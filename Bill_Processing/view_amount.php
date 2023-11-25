<?php
include('db.php'); // Include your database connection file

// Fetch data from sanctioned_amounts table
$query_sanctioned_amounts = "SELECT * FROM sanctioned_amounts";
$result_sanctioned_amounts = mysqli_query($conn, $query_sanctioned_amounts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanctioned Amounts</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 20px 0 0;
        }
    </style>
</head>
<body>
    <h2>Sanctioned Amounts</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Budget Head</th>
                <th>Department</th>
                <th>Amount</th>
                <th>Total Expenses</th>
                <th>Remaining Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result_sanctioned_amounts)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['budget_head'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['total_expenses'] . "</td>";
                echo "<td>" . $row['remaining_amount'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
