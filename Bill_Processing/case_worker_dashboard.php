<?php
session_start();

// Database connection parameters
include('db.php');

// Check if the user is logged in (you can adapt this check to your login mechanism)
if (!isset($_SESSION["user_id"])) {
    header("Location: case_worker_login.php"); // Redirect to the login page if not logged in
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION["user_id"]; // Define $user_id here

if (isset($_POST['accept_bill'])) {
    $billId = $_POST['bill_id'];
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

    // Query to check if the bill is already accepted
    $checkQuery = "SELECT * FROM cw_accepted_bills WHERE ID = '$billId'"; // Use 'ID' as the column name
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Bill is already accepted, show a pop-up message
        echo "<script>alert('This bill is already accepted and cannot be changed.');</script>";
    } else {
        // Bill is not accepted, proceed to accept it
        // Query to retrieve the bill details
        $billQuery = "SELECT * FROM bills WHERE bill_id = '$billId'";
        $billResult = mysqli_query($conn, $billQuery);

        if ($billRow = mysqli_fetch_assoc($billResult)) {
            // Insert the accepted bill into cw_accepted_bills table
            $insertQuery = "INSERT INTO cw_accepted_bills 
                            (ID, `Bill_Number`, `Vendor_Name`, `Vendor_Company`, `Vendor_Phone_Number`, `Amount`, `Department`, `Invoice_Date`, `Created_At`, `Status`, `user_id`, `Budget_Head`, `Actions`, `Remarks`) 
                            VALUES 
                            ('$billRow[bill_id]', '$billRow[bill_number]', '$billRow[vendor_name]', '$billRow[vendor_company]', '$billRow[phone_number]', '$billRow[amount]', '$billRow[department]', '$billRow[invoice_date]', '$billRow[created_at]', 'Accepted', '$billRow[user_id]', '$billRow[budget_head]', 'Processing', '$remarks')";
            $insertResult = mysqli_query($conn, $insertQuery);

            if ($insertResult) {
                // Successful insertion, mark the bill as accepted in the bills table
                $updateQuery = "UPDATE bills SET `Status` = 'Processing' WHERE bill_id = '$billId'"; // Use 'Status' as the column name
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    // Show a pop-up message for successful acceptance
                    echo "<script>alert('Bill accepted successfully.');</script>";
                } else {
                    echo "Error updating bill status: " . mysqli_error($conn);
                }
            } else {
                echo "Error accepting bill: " . mysqli_error($conn);
            }
        } else {
            echo "Error retrieving bill details: " . mysqli_error($conn);
        }
    }
}
if (isset($_POST['reject_bill'])) {
    $billId = $_POST['bill_id'];

    // Query to check if the bill is already accepted
    $checkQuery = "SELECT * FROM cw_accepted_bills WHERE ID = '$billId'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Bill is already accepted, show a pop-up message
        echo "<script>alert('This bill is already accepted and cannot be changed.');</script>";
    } else {
        // Check if the bill is already rejected
        $checkRejectedQuery = "SELECT * FROM bills WHERE id = '$billId' AND `Status` = 'Rejected'";
        $checkRejectedResult = mysqli_query($conn, $checkRejectedQuery);

        if (mysqli_num_rows($checkRejectedResult) > 0) {
            // Bill is already rejected, show a pop-up message
            echo "<script>alert('This bill is already rejected and cannot be changed.');</script>";
        } else {
            // Bill is not accepted or rejected, proceed to reject it
            // Query to update the status of the bill to 'Rejected' in the 'bills' table
            $rejectQuery = "UPDATE bills SET `Status` = 'Rejected' WHERE id = '$billId'";
            $rejectResult = mysqli_query($conn, $rejectQuery);

            if ($rejectResult) {
                // Show a pop-up message for successful rejection
                echo "<script>alert('Bill rejected successfully.');</script>";
            } else {
                echo "Error rejecting bill: " . mysqli_error($conn);
            }
        }
    }
}

// Query to retrieve bills that belong to the logged-in user
$query = "SELECT * FROM bills WHERE `user_id` = '$user_id'"; // Use 'User Id' as the column name
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle the query error (e.g., display an error message)
    echo "Error fetching bill details: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Case Worker Dashboard</title>
    
 <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin, 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        header {
  background-color: #007bff;
  color: #fff;
  padding: 35px; /* increased padding */
  text-align: right; 
  position: relative;
}

        header a {
            color: #fff;
            text-decoration: none;
        }

        header a:hover {
            text-decoration: underline;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0px 0px 10px #888888;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="text"] {
            width: 90%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }
        .dropdown {
  position: absolute;
  top: 50%; 
  right: 20px; /* positioning adjustments */
  transform: translateY(-50%); /* center vertically */
}

.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
.reject-button {
    background-color: #FF0000; /* Red color */
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    font-weight: bold;
    border-radius: 4px;
}

.reject-button:hover {
    background-color: #FF3333; /* Lighter shade of red on hover */
}
</style>
</head>
<body>
<header>
    <div class="dropdown">
    <button class="dropbtn">Manage Profile</button>
    <div class="dropdown-content">
      <a href="settings.php">Settings</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</header>
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
        <th>Remarks</th>
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
            <?php if ($row['status'] == 'Rejected') : ?>
                <td>Already Rejected</td>
            <?php else : ?>
                <td><?php echo $row['status']; ?></td>
            <?php endif; ?>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['budget_head']; ?></td>
            <td>
                <?php if ($row['status'] != 'Processing' && $row['status'] != 'Rejected') : ?>
                    <form method="POST" action="">
                        <button type="submit" name="accept_bill">Accept</button>
                        <button type="submit" name="reject_bill">Reject</button>
                        <td><input type="text" name="remarks" placeholder="Enter Remarks" required></td>
                        <input type="hidden" name="bill_id" value="<?php echo $row['bill_id']; ?>">
                    </form>
                <?php elseif ($row['status'] == 'Rejected') : ?>
                    <span>Already Rejected</span>
                <?php else : ?>
                    <span>Already Accepted</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
