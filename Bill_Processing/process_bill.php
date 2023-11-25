<?php
include('db.php');

$success_message = "";

// Fetch user IDs and names from the case_workers table
$usersData = array();
$query = "SELECT user_id, name FROM case_workers";
$result = mysqli_query($conn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usersData[$row['user_id']] = $row['name'];
    }
}

// Fetch departments from the 'departments' table
$departmentsData = array();
$queryDepartments = "SELECT id, department FROM departments";
$resultDepartments = mysqli_query($conn, $queryDepartments);
if ($resultDepartments) {
    while ($row = mysqli_fetch_assoc($resultDepartments)) {
        $departmentsData[$row['id']] = $row['department'];
    }
}

// Fetch budget heads from the 'budget_heads' table
$budgetHeadsData = array();
$queryBudgetHeads = "SELECT id, budget_head FROM budget_heads";
$resultBudgetHeads = mysqli_query($conn, $queryBudgetHeads);
if ($resultBudgetHeads) {
    while ($row = mysqli_fetch_assoc($resultBudgetHeads)) {
        $budgetHeadsData[$row['id']] = $row['budget_head'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $budget_head = isset($_POST["budget_head"]) ? $_POST["budget_head"] : null;
    $department = isset($_POST["department"]) ? $_POST["department"] : null;
    $bill_number = isset($_POST["bill_number"]) ? $_POST["bill_number"] : null;
    $vendor_name = isset($_POST["vendor_name"]) ? $_POST["vendor_name"] : null;
    $vendor_company = isset($_POST["vendor_company"]) ? $_POST["vendor_company"] : null;
    $phone_number = isset($_POST["phone_number"]) ? $_POST["phone_number"] : null;
    $amount = isset($_POST["amount"]) ? floatval($_POST["amount"]) : null;
    $invoice_date = isset($_POST["invoice_date"]) ? $_POST["invoice_date"] : null;
    $status = isset($_POST["status"]) ? $_POST["status"] : null;
    $selected_user_id = isset($_POST["selected_user_id"]) ? $_POST["selected_user_id"] : null;

    
    // Fetch the department_id based on the selected department_name
    $departmentName = $_POST["department"];
    $queryDepartmentId = "SELECT id FROM departments WHERE department = ?";
    $stmtDepartmentId = mysqli_prepare($conn, $queryDepartmentId);
    mysqli_stmt_bind_param($stmtDepartmentId, "s", $departmentName);
    mysqli_stmt_execute($stmtDepartmentId);
    mysqli_stmt_bind_result($stmtDepartmentId, $departmentId);
    mysqli_stmt_fetch($stmtDepartmentId);
    mysqli_stmt_close($stmtDepartmentId);

    // Fetch the budget_head_id based on the selected budget_head_name
    $budgetHeadName = $_POST["budget_head"];
    $queryBudgetHeadId = "SELECT id FROM budget_heads WHERE budget_head = ?";
    $stmtBudgetHeadId = mysqli_prepare($conn, $queryBudgetHeadId);
    mysqli_stmt_bind_param($stmtBudgetHeadId, "s", $budgetHeadName);
    mysqli_stmt_execute($stmtBudgetHeadId);
    mysqli_stmt_bind_result($stmtBudgetHeadId, $budgetHeadId);
    mysqli_stmt_fetch($stmtBudgetHeadId);
    mysqli_stmt_close($stmtBudgetHeadId);



    // Insert the bill details into the 'bills' table
    $sql = "INSERT INTO bills (bill_number, vendor_name, vendor_company, phone_number, amount, department, invoice_date, status, user_id, `budget_head`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssdsssss", $bill_number, $vendor_name, $vendor_company, $phone_number, $amount, $department, $invoice_date, $status, $selected_user_id, $budget_head);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Set success message
        $success_message = "Bill details added successfully!";

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        input[type=text], select, input[type=tel], input[type=number], input[type=date], textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            width: 80%; /* Adjust the width as needed */
            margin: 0 auto; /* Center the container horizontally */
        }

        .col-25 {
            float: left;
            width: 25%;
            margin-top: 6px;
        }

        .col-75 {
            float: left;
            width: 75%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
            .col-25, .col-75, input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }
    </style>
    <title>Enter Bill Details</title>
</head>
<body>

    <h2>Enter Bill Details</h2>

    <div class="container">
        <form action="process_bill.php" method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="budget_head">Budget Head</label>
                </div>
                <div class="col-75">
                    <select id="budget_head" name="budget_head" required>
                        <?php foreach ($budgetHeadsData as $budgetHeadId => $budgetHeadName) : ?>
                            <option value="<?= $budgetHeadName ?>"><?= $budgetHeadName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="department">Department</label>
                </div>
                <div class="col-75">
                    <select id="department" name="department" required>
                        <?php foreach ($departmentsData as $departmentId => $departmentName) : ?>
                            <option value="<?= $departmentName ?>"><?= $departmentName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="bill_number">Bill Number</label>
                </div>
                <div class="col-75">
                    <input type="text" id="bill_number" name="bill_number" placeholder="Bill number.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="vendor_name">Vendor Name</label>
                </div>
                <div class="col-75">
                    <input type="text" id="vendor_name" name="vendor_name" placeholder="Vendor name.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="vendor_company">Vendor Company</label>
                </div>
                <div class="col-75">
                    <input type="text" id="vendor_company" name="vendor_company" placeholder="Vendor company.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="phone_number">Vendor's Phone Number</label>
                </div>
                <div class="col-75">
                    <input type="tel" id="phone_number" name="phone_number" placeholder="Phone number.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="amount">Amount</label>
                </div>
                <div class="col-75">
                    <input type="number" id="amount" name="amount" placeholder="Amount.." step="0.01" min="0" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="invoice_date">Invoice Date</label>
                </div>
                <div class="col-75">
                    <input type="date" id="invoice_date" name="invoice_date" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="status">Status</label>
                </div>
                <div class="col-75">
                    <select id="status" name="status" required>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="selected_user_id">User</label>
                </div>
                <div class="col-75">
                    <select id="selected_user_id" name="selected_user_id" required>
                        <?php foreach ($usersData as $userId => $userName) : ?>
                            <option value="<?= $userId ?>"><?= $userId . ' - ' . $userName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                    <input type="submit" value="Submit">
                    <input type="button" value="Previous" onclick="window.history.back()">
                    <a href="view_remaining_amount.php" class="button">View Remaining Amount</a>
            </div>
        </form>
        <!-- Display success message -->
        <?php if ($success_message): ?>
            <p><?= $success_message ?></p>
        <?php endif; ?>

    <!-- JavaScript to validate the Invoice Date -->
    <script>
        const invoiceDateInput = document.getElementById('invoice_date');
        const currentDate = new Date().toISOString().split('T')[0];

        invoiceDateInput.addEventListener('change', () => {
            const selectedDate = invoiceDateInput.value;

            if (selectedDate > currentDate) {
                alert("Invoice Date cannot be in the future.");
                invoiceDateInput.value = currentDate; // Reset to current date
            }
        });
    </script>
<script>
  <?php if ($submitted) : ?>
    // Display a popup message
    alert("<?= $success_message ?>");
  <?php endif; ?>
</script>
</body>
</html>
