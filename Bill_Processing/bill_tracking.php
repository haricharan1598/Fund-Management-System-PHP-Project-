<!DOCTYPE html>
<html>
<head>
    <title>Bill Tracking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            background-color: #5584AC;
            color: #fff;
            padding: 10px 0;
        }

        form {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #5584AC;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #325776;
        }

        h3, p {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Track a Bill</h2>
    <form method="POST" action="bill_tracking.php">
        <label for="bill_number">Enter Bill Number: </label>
        <input type="text" name="bill_number" id="bill_number" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php
     include('db.php');
    if (isset($_POST['search'])) {
    
        $bill_number = $_POST['bill_number'];

        $locations = array(
            "cw_accepted_bills" => "Case Worker",
            "os_accepted_bills" => "Office Superintendent",
            "dfo_accepted_bills" => "Deputy Finance Officer",
            "fo_accepted_bills" => "Finance Officer"
        );

        $latest_location = "Not Found";

        // Check each table to determine the bill's latest location
        foreach ($locations as $table => $location) {
            $query = "SELECT status FROM $table WHERE bill_number = '$bill_number'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $latest_location = $location;
                $row = mysqli_fetch_assoc($result);
                $bill_status = $row['status'];
            }
        }

        if ($latest_location !== "Not Found") {
            echo "<h3>Bill Number: $bill_number</h3>";
            echo "<p>Status: $bill_status</p>";
            echo "<p>Latest Location: $latest_location</p>";
        } else {
            echo "<h3>Bill Number: $bill_number</h3>";
            echo "<p>Bill not found in any location.</p>";
        }

        mysqli_close($conn);
    }
    ?>
</body>
</html>
