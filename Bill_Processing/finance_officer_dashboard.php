<?php
session_start();
include("db.php");

// Function to handle update queries for sanctioned_amounts
function updateSanctionedAmounts($conn) {
    include('update_sanctioned_amounts.php');
}

// Check if the "Approve" button is clicked for a specific bill
if (isset($_POST['approve_button'])) {
    $billNumberToApprove = $_POST['bill_number_to_approve'];
    
    // Check if the bill has already been approved
    $check_query = "SELECT * FROM dfo_accepted_bills WHERE Bill_Number = '$billNumberToApprove' AND Status = 'Approved'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "Bill with Bill Number $billNumberToApprove has already been Approved.";
    } else {
        // Update the bill's status to "Approved" in the dfo_accepted_bills table
        $update_query = "UPDATE dfo_accepted_bills SET Status = 'Approved' WHERE Bill_Number = '$billNumberToApprove'";
        
        if (mysqli_query($conn, $update_query)) {
            echo "Bill with Bill Number $billNumberToApprove has been Approved.";
            
            // Insert the bill details into the fo_accepted_bills table
            $insert_query = "INSERT INTO fo_accepted_bills (Bill_Number, Vendor_Name, Vendor_Company, Vendor_Phone_Number, Amount, Department, Invoice_Date, Status, User_Id, Budget_Head, Actions, Remarks)
                             SELECT Bill_Number, Vendor_Name, Vendor_Company, Vendor_Phone_Number, Amount, Department, Invoice_Date, 'Approved', User_Id, Budget_Head, 'Moved', Remarks
                             FROM dfo_accepted_bills
                             WHERE Bill_Number = '$billNumberToApprove'";
            
            if (mysqli_query($conn, $insert_query)) {
                echo "Bill details added to FO's accepted bills.";
            } else {
                echo "Error inserting bill details: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating bill status: " . mysqli_error($conn);
        }
        
        // Run the update queries for sanctioned_amounts
        updateSanctionedAmounts($conn);
    }
}

// Check if the "Update Remarks" button is clicked for a specific bill
if (isset($_POST['update_remarks_button'])) {
    $billNumberToUpdateRemarks = $_POST['bill_number_to_update_remarks'];
    $newRemarks = $_POST['new_remarks'];
    
    // Update the remarks for the bill in the dfo_accepted_bills table
    $updateRemarks_query = "UPDATE dfo_accepted_bills SET Remarks = '$newRemarks' WHERE Bill_Number = '$billNumberToUpdateRemarks'";
    
    if (mysqli_query($conn, $updateRemarks_query)) {
        echo "Remarks updated successfully for Bill Number $billNumberToUpdateRemarks.";
    } else {
        echo "Error updating remarks: " . mysqli_error($conn);
    }
}

// Check if the "Reject" button is clicked for a specific bill
if (isset($_POST['reject_button'])) {
    $billNumberToReject = $_POST['bill_number_to_reject'];

    // Update the bill's status to "Rejected" in the dfo_accepted_bills table
    $updateRejectQuery = "UPDATE dfo_accepted_bills SET Status = 'Rejected' WHERE Bill_Number = '$billNumberToReject'";

    if (mysqli_query($conn, $updateRejectQuery)) {
        echo "Bill with Bill Number $billNumberToReject has been rejected.";
    } else {
        echo "Error rejecting bill: " . mysqli_error($conn);
    }
    
    // Run the update queries for sanctioned_amounts
    updateSanctionedAmounts($conn);
}

// Retrieve and display bills from the 'dfo_accepted_bills' table
$query = "SELECT * FROM dfo_accepted_bills WHERE Status <> 'Approved'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error fetching bills: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Officer Dashboard</title>
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
            width: 100%;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
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

        .approve-button, .update-remarks-button {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
        }

        .editable-remarks {
            cursor: pointer;
            text-decoration: underline;
            color: #2196F3;
        }

        /* Style for the input field in the "Update Remarks" prompt */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
          /* CSS styles for the header */
          header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 30px; /* Adjust padding as needed */
            display: flex;
            justify-content: space-between; /* Push elements to the right */
        }

        header a {
            color: #fff;
            text-decoration: none;
        }

        header a:hover {
            text-decoration: underline;
        }

        .dropdown {
            position: relative; /* Remove absolute positioning */
            cursor: pointer; /* Make it clickable */
        }

        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0; /* Position it to the right */
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

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
        <div>
            <!-- "Manage Profile" button is now inside the header -->
            <div class="dropdown">
                <button class="dropbtn">Manage Profile</button>
                <div class="dropdown-content">
                    <a href="os_settings.php">Settings</a>
                    <a href="../index.html">Logout</a>
                </div>
            </div>
        </div>
    </header>
</head>
<body>
    <h2>Finance Officer Dashboard</h2>
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
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['Bill_Number']; ?></td>
                <td><?php echo $row['Vendor_Name']; ?></td>
                <td><?php echo $row['Vendor_Company']; ?></td>
                <td><?php echo $row['Vendor_Phone_Number']; ?></td>
                <td><?php echo $row['Amount']; ?></td>
                <td><?php echo $row['Department']; ?></td>
                <td><?php echo $row['Invoice_Date']; ?></td>
                <td><?php echo $row['Created_At']; ?></td>
                <td><?php echo $row['Status']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['Budget_Head']; ?></td>
                <td>
                    <!-- Add an "Approve" button for updating the bill to "Approved" state -->
                    <form method="post">
                        <input type="hidden" name="bill_number_to_approve" value="<?php echo $row['Bill_Number']; ?>">
                        <input type="submit" name="approve_button" class="approve-button" value="Approve">
                    </form>
                    <!-- Add a "Reject" button for updating the bill to "Rejected" state -->
                    <form method="post">
                        <input type="hidden" name="bill_number_to_reject" value="<?php echo $row['Bill_Number']; ?>">
                        <input type="submit" name="reject_button" class="reject-button" value="Reject">
                    </form>
                </td>
                <td class="editable-remarks" onclick="editRemarks('<?php echo $row['Bill_Number']; ?>', '<?php echo $row['Remarks']; ?>')">
                    <?php echo $row['Remarks']; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- JavaScript for inline editing of remarks -->
    <script>
        function editRemarks(billNumber, currentRemarks) {
            var newRemarks = prompt("Edit Remarks:", currentRemarks);

            if (newRemarks !== null) {
                // Update the remarks via AJAX or form submission
                // For simplicity, you can add an AJAX request here
                alert("Remarks updated successfully.");
            }
        }
    </script>
</body>
</html>
