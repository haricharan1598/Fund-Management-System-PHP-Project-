<?php
require_once('db.php'); // Include the database connection

$sql = "SELECT * FROM case_workers";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "<h3>Case Workers Data</h3>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>{$row['name']}</li>"; // Replace 'name' with your actual column name
    }
    echo "</ul>";
}

mysqli_close($conn);
?>
