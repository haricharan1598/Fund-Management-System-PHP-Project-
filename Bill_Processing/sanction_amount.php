<?php
include('db.php'); // Include your database connection file

// Fetch data from budget_heads table
$query_budget_heads = "SELECT * FROM budget_heads";
$result_budget_heads = mysqli_query($conn, $query_budget_heads);

// Fetch data from departments table
$query_departments = "SELECT * FROM departments";
$result_departments = mysqli_query($conn, $query_departments);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $budget_head = mysqli_real_escape_string($conn, $_POST['budget_head']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    // Calculate total expenses
    $total_expenses_query = "SELECT SUM(amount) AS total_expenses FROM fo_accepted_bills WHERE budget_head = '$budget_head' AND department = '$department'";
    $total_expenses_result = mysqli_query($conn, $total_expenses_query);
    $total_expenses_row = mysqli_fetch_assoc($total_expenses_result);
    $total_expenses = $total_expenses_row['total_expenses'];

    // Insert data into the sanctioned_amounts table
    $sql = "INSERT INTO sanctioned_amounts (budget_head, department, amount, total_expenses) VALUES ('$budget_head', '$department', '$amount', '$total_expenses')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanction Amount</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        select,
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Sanction Amount</h2>

        <label for="budget_head">Budget Head:</label>
        <select name="budget_head" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_budget_heads)) {
                echo "<option value='" . $row['budget_head'] . "'>" . $row['budget_head'] . "</option>";
            }
            ?>
        </select>

        <label for="department">Department:</label>
        <select name="department" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_departments)) {
                echo "<option value='" . $row['department'] . "'>" . $row['department'] . "</option>";
            }
            ?>
        </select>

        <label for="amount">Amount:</label>
        <input type="text" name="amount" required>

        <button type="submit">Sanction Amount</button>
    </form>
</body>
</html>

<?php
// Process form submission here if needed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $budget_head = $_POST['budget_head'];
    $department = $_POST['department'];
    $amount = $_POST['amount'];


    // You can now use these variables to insert data into another table or perform any other actions.
    // For example:
    $sql = "INSERT INTO sanctioned_amounts (budget_head, department, amount) VALUES ('$budget_head', '$department', '$amount')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
