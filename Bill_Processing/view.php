<?php
session_start();

// Database connection parameters
include('db.php');

// Query to retrieve all bill details from the "bills" table
$query = "SELECT * FROM bills";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle the query error (e.g., display an error message)
    echo "Error fetching bill details: " . mysqli_error($conn);
    exit();
}

// Function to delete a bill by ID
function deleteBill($conn, $billId) {
    $deleteQuery = "DELETE FROM bills WHERE bill_id = $billId";
    if (mysqli_query($conn, $deleteQuery)) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBill"])) {
    $billId = $_POST["billId"];
    if (deleteBill($conn, $billId)) {
        header("Location: view.php"); // Redirect to the same page after successful deletion
        exit();
    } else {
        echo "Error deleting bill.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View All Bills</title>
    <style>
   table {
      border-collapse: collapse;
      width: 100%;
    }
    
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    
    th {
      background-color: #4CAF50;
      color: white;
    }
    
    tr:hover {
      background-color: #f5f5f5;
    }

    .actions {
        display: flex;
    }

    .actions a {
        margin-right: 10px;
        text-decoration: none;
    }

   
    .edit-button {
        background-color: #007bff; /* Blue color for Edit button */
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none; /* Remove underline from links */
    }

    .edit-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    .delete-button {
        background-color: #ff0000;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .delete-button:hover {
        background-color: #ff6666;
    }
  </style>
</head>
<body>
    <h2>All Bills</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Bill Number</th>
            <th>Vendor Name</th>
            <th>Vendor Company</th>
            <th>Vendor Phone Number</th>
            <th>Amount</th>
            <th>Department</th>
            <th>Invoice Date</th>
            <th>Created At</th>
            <th>Status</th>
            <th>User Id</th>
            <th>Budget Head</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['bill_id']; ?></td>
                <td><?php echo $row['bill_number']; ?></td>
                <td><?php echo $row['vendor_name']; ?></td>
                <td><?php echo $row['vendor_company']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td>Rs<?php echo $row['amount']; ?></td>
                <td><?php echo $row['department']; ?></td>
                <td><?php echo $row['invoice_date']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['budget_head']; ?></td>
                <td class="actions">
                    <a class="edit-button" href="edit_bill.php?id=<?php echo $row['bill_id']; ?>">Edit</a>
                    <button class="delete-button" onclick="confirmDelete(<?php echo $row['bill_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function confirmDelete(billId) {
            if (confirm("Are you sure you want to delete this bill?")) {
                // Redirect to delete action
                window.location.href = "delete_bill.php?id=" + billId;
            }
        }
    </script>
</body>
</html>
