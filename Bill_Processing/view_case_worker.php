<?php
// Database connection

$host = "localhost";
$username = "root";
$password = "";
$database = "bill_process";

$conn = mysqli_connect($host, $username, $password, $database);

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $id = $_GET['id'];

    $sql = "DELETE FROM case_workers WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Case worker removed successfully";
    } else {
        echo "Error deleting case worker: " . mysqli_error($conn);
    }
    exit();
}

// Get all case workers
$sql = "SELECT * FROM case_workers";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Case Workers</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #f1f1f1;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        margin: 20px 0;
    }

    table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background: #5584AC;
        color: #fff;
    }

    tbody tr:nth-child(even) {
        background: #f4f4f4;
    }

    .remove-btn {
        background: #d9534f;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .remove-btn:hover {
        background: #c9302c;
    }
  </style>
</head>
<body>

<h2>Case Workers</h2>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>User ID</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
           
            <td>
                <button class="remove-btn" data-id="<?php echo $row['id']; ?>">
                    Remove
                </button>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    const removeBtns = document.querySelectorAll('.remove-btn');

    removeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            removeCaseWorker(btn.dataset.id);
        })
    });

    async function removeCaseWorker(id) {
        if (confirm('Are you sure you want to remove this case worker?')) {

            const response = await fetch(`view_case_worker.php?id=${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                alert('Case worker removed successfully!');
                location.reload();
            }

        }
    }
</script>

</body>
</html>
