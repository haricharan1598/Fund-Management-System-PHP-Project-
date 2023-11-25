<?php
// Assuming you have a database connection established
include('db.php'); // Make sure to include your database connection file

// Fetch data from the budget_heads table
$query = "SELECT * FROM budget_heads";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <!-- Display the data in a table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Budget Head</th>
            <!-- Add more columns as needed -->
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['budget_head'] ?></td>
                <!-- Add more columns as needed -->
            </tr>
        <?php endwhile; ?>

    </table>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
