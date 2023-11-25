<?php
// Database connection parameters
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"]; // New password field

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if a case worker with the same email or phone number already exists
    $emailCheckQuery = "SELECT * FROM case_workers WHERE email = '$email'";
    $phoneCheckQuery = "SELECT * FROM case_workers WHERE phone = '$phone'";

    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);
    $phoneCheckResult = mysqli_query($conn, $phoneCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        echo "Error: A case worker with the same email already exists.";
    } elseif (mysqli_num_rows($phoneCheckResult) > 0) {
        echo "Error: A case worker with the same phone number already exists.";
    } else {
        // Insert the new case worker into the 'case_workers' table with the hashed password
        $sql = "INSERT INTO case_workers (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashedPassword')";

        if (mysqli_query($conn, $sql)) {
            echo "Case worker added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Case Worker</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2; 
    }
    
    .form-container {
      background: #fff;
      width: 400px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px #aaa; 
    }
    
    h1 {
      text-align: center;  
    }
    
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
    }
    
    input[type="submit"] {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
    
  </style>
</head>
<body>

  <div class="form-container">
  
    <h1>Add New Case Worker</h1>  

    <form id="regForm" method="post">
    
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone" required>
      
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <input type="submit" value="Add Worker">
    
    </form>

  </div>
    <br>
    <script>

const form = document.getElementById('regForm');
form.addEventListener('submit', validateForm);

function validateForm(event) {
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const password = document.getElementById('password').value;
  
  if (name === '') {
    alert('Name is required');
    event.preventDefault();
  }
  
  if (email === '') {
    alert('Email is required');
    event.preventDefault(); 
  }
  
  // Add more validation like checking if email is valid
  
  if (phone === '') {
    alert('Phone is required');
    event.preventDefault();
  }
  
  if (password === '') {
    alert('Password is required');
    event.preventDefault();
  }

}

</script>
</body>
</html>
