<?php
session_start();
include('db.php');

// Check if the user is logged in as an Office Superintendent (you can replace 'user_type' with your actual user type)
if (!isset($_SESSION["user_id"])) {
    header("Location: office_superintendent_login.php"); // Redirect to login page or unauthorized page
    exit();
}



// Check if the "Reject" button is clicked for a specific bill
if (isset($_POST['reject_button'])) {
    $billNumberToReject = $_POST['bill_number_to_reject'];
    
    // Update the bill's status to "Rejected" in the cw_accepted_bills table
    $reject_query = "UPDATE cw_accepted_bills SET Status = 'Rejected' WHERE Bill_Number = '$billNumberToReject'";
    
    if (mysqli_query($conn, $reject_query)) {
        echo "Bill with Bill Number $billNumberToReject has been rejected and moved back to CW's accepted bills.";
    } else {
        echo "Error rejecting bill: " . mysqli_error($conn);
    }
}
// Check if the "Move" button is clicked for a specific bill
if (isset($_POST['move_button'])) {
    $billNumberToMove = $_POST['bill_number_to_move'];
    
    // Check if the bill has already been moved
    $check_query = "SELECT * FROM cw_accepted_bills WHERE Bill_Number = '$billNumberToMove' AND Status = 'processing'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "Bill with Bill Number $billNumberToMove has already been moved.";
    } else {
        // Update the bill's status to "processing" in the cw_accepted_bills table
        $update_query = "UPDATE cw_accepted_bills SET Status = 'processing' WHERE Bill_Number = '$billNumberToMove'";
        
        if (mysqli_query($conn, $update_query)) {
            // Move the bill to os_accepted_bills table
            $insert_query = "INSERT INTO os_accepted_bills (Bill_Number, Vendor_Name, Vendor_Company, Vendor_Phone_Number, Amount, Department, Invoice_Date, Status, user_id, Budget_Head, Actions, Remarks)
                             SELECT Bill_Number, Vendor_Name, Vendor_Company, Vendor_Phone_Number, Amount, Department, Invoice_Date, 'Accepted', user_id, Budget_Head, 'Moved', Remarks
                             FROM cw_accepted_bills
                             WHERE Bill_Number = '$billNumberToMove'";
            
            if (mysqli_query($conn, $insert_query)) {
                echo "Bill with Bill Number $billNumberToMove has been moved to processing state and added to os_accepted_bills.";
            } else {
                echo "Error moving bill: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating bill status: " . mysqli_error($conn);
        }
    }
}

// Check if the "Update Remarks" button is clicked for a specific bill
if (isset($_POST['update_remarks_button'])) {
    $billNumberToUpdateRemarks = $_POST['bill_number_to_update_remarks'];
    $newRemarks = $_POST['new_remarks'];
    
    // Update the remarks for the bill in the cw_accepted_bills table
    $updateRemarks_query = "UPDATE cw_accepted_bills SET Remarks = '$newRemarks' WHERE Bill_Number = '$billNumberToUpdateRemarks'";
    
    if (mysqli_query($conn, $updateRemarks_query)) {
        echo "Remarks updated successfully for Bill Number $billNumberToUpdateRemarks.";
    } else {
        echo "Error updating remarks: " . mysqli_error($conn);
    }
}

/// Retrieve and display bills accepted by case workers from the 'cw_accepted_bills' table
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM cw_accepted_bills WHERE user_id = '$user_id' AND (Status = 'Accepted' OR Status = 'Moved')";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error fetching accepted bills: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Office Superintendent Page</title>
    <!-- Add CSS styles for better presentation -->
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

        .move-button, .update-remarks-button {
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
            padding: 35px 30px; /* Adjust padding as needed */
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
            position: absolute; /* Remove absolute positioning */
            cursor: pointer; 
            right: 10px;
            top: 5px;
/* Make it clickable */
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
    
    <h2>Office Superintendent Page</h2>
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
                    <!-- Add a "Move" button for updating the bill to "processing" state -->
                    <form method="post">
        <input type="hidden" name="bill_number_to_move" value="<?php echo $row['Bill_Number']; ?>">
        <input type="submit" name="move_button" class="move-button" value="Move">
    </form>
    <!-- Add a "Reject" button for rejecting the bill -->
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

    <script>
        function editRemarks(billNumber, currentRemarks) {
            const newRemarks = prompt("Update Remarks:", currentRemarks);
            if (newRemarks !== null) {
                // Send an AJAX request to update the remarks
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        // Update the remarks in the table without refreshing the page
                        const remarksCell = document.querySelector(`td.editable-remarks:contains('${currentRemarks}')`);
                        remarksCell.innerHTML = newRemarks;
                    }
                };
                xhttp.open("POST", "update_remarks.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(`bill_number_to_update_remarks=${billNumber}&new_remarks=${newRemarks}`);
            }
        }
    </script>
</body>
</html>
