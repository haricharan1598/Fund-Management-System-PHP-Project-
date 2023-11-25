<?php
// Connect to database 
include('db.php');

// Get bill details
if(isset($_GET['id'])){
  
  $bill_id = $_GET['id'];

  $sql = "SELECT * FROM bills WHERE bill_id=$bill_id";
  $result = mysqli_query($conn, $sql);
  $bill = mysqli_fetch_assoc($result);

}else{
  echo "Error - No bill ID found";
  exit();
}

// Update bill
if(isset($_POST['update_bill'])){
  $vendor_name = $_POST['vendor_name'];
  $vendor_company = $_POST['vendor_company'];
  $phone_number = $_POST['phone_number'];
  $amount = $_POST['amount'];
  $department = $_POST['department'];
  $invoice_date = $_POST['invoice_date'];
  $budget_head = $_POST['budget_head'];

  $sql = "UPDATE bills SET vendor_name=?, vendor_company=?, 
          phone_number=?, amount=?, department=?, 
          invoice_date=?, budget_head=? WHERE bill_id=?";
  
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ssdssssi", $vendor_name, $vendor_company, $phone_number, $amount, $department, $invoice_date, $budget_head, $bill_id);

  if(mysqli_stmt_execute($stmt)){
    echo "Bill updated successfully!";
  }else{
    echo "Error updating bill: " . mysqli_error($conn);
  }

  mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>


<!-- HTML form -->

<!DOCTYPE html>
<html>
<head>
  <title>Edit Bill</title>
  
  <style>
    /* CSS styling */
    body {
      font-family: Arial, sans-serif;
      background: #f1f1f1;
    }
    
    .form-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background: #fff;
      border-radius: 5px;
    }
    
    h2 {
      color: #333;
    }
    
    label {
      display: block;
      margin-bottom: 5px;
    }
    
    input[type="text"],
    input[type="number"], 
    input[type="date"] {
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
    
    button[type="submit"] {
      width: 100%;
      padding: 10px; 
      border: none;
      background: #007bff;
      color: #fff;
      border-radius: 4px;
      cursor: pointer;
    }
    
    button[type="submit"]:hover {
      background: #0062cc;
    }

  </style>

</head>

<body>

  <div class="form-container">
    <h2>Edit Bill</h2>

    <form method="POST" onsubmit="return validateForm()">
    
      <input type="hidden" name="id" value="<?php echo $bill['bill_id']; ?>">

      <label>Vendor Name:</label>
      <input type="text" id="vendor_name" name="vendor_name" value="<?php echo $bill['vendor_name']; ?>" required>

      <label>Vendor Company:</label>  
      <input type="text" id="vendor_company" name="vendor_company" value="<?php echo $bill['vendor_company']; ?>" required>

      <label>Phone Number:</label>
      <input type="number" id="phone_number" name="phone_number" value="<?php echo $bill['phone_number']; ?>" required>

      <label>Amount:</label>
      <input type="number" id="amount" name="amount" value="<?php echo $bill['amount']; ?>" required>

      <label>Department:</label>
      <input type="text" id="department" name="department" value="<?php echo $bill['department']; ?>" required>

      <label>Invoice Date:</label>
      <input type="date" id="invoice_date" name="invoice_date" value="<?php echo $bill['invoice_date']; ?>" required>

      <label>Budget Head:</label>
      <input type="text" id="budget_head" name="budget_head" value="<?php echo $bill['budget_head']; ?>" required>


      <button type="submit" name="update_bill">Update Bill</button>

    </form>

  </div>

  <script>

    function validateForm() {
      let vendorName = document.getElementById("vendor_name").value;
      let vendorCompany = document.getElementById("vendor_company").value;
      // Validate other fields
      
      if(vendorName === "" || vendorCompany === "") {
        alert("All fields are required");
        return false;
      }

      return true;
    }

  </script>

</body>
</html>