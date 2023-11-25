<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Department List</h2>

    <?php
    include('db.php'); // Include your database connection file

    // Fetch data from the departments table
    $query = "SELECT * FROM departments";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching data: " . mysqli_error($conn));
    }

    // Display the data in a table
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Department</th>
                <!-- Add more columns as needed -->
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['department'] . "</td>
                <!-- Add more columns as needed -->
              </tr>";
    }

    echo "</table>";

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
