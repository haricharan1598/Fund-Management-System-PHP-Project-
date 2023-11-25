<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="FMSBP\Bill_Processing\newstyle.css" rel="stylesheet">
    <title>Admin Dashboard</title>
 <style>
 /* Reset some default styles */
body, h1, h2, h3, p, ul {
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Arial', sans-serif;
    margin: 0;
}

.header {
    display: flex;
}

.side-nav {
    background-color: #333;
    color: #fff;
    width: 250px;
    padding: 20px;
    height: 100vh;
    box-sizing: border-box;
    overflow-y: auto;
}

h2 {
    color: #fff;
    margin-bottom: 30px;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

li {
    margin-bottom: 30px;
}

a {
    text-decoration: none;
    color: #fff;
    display: flex;
    align-items: center;
    padding: 8px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #555;
}

/* Add some padding and border to the submenus */
/* ul ul {
    margin-top: 10px;
    padding-left: 10px;
    border-left: 2px solid #fff;
} */

/* Add some spacing between the icons and text */
img {
    margin-right: 10px;
    width: 20px;
}

/* Style the signout link */
/* ul  {
    border-top: 2px solid #fff;
    padding-top: 10px;
    display: block;
} */

/* Highlight the current page */
a.active {
    background-color: #555;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
    }
    .side-nav {
        width: 100%;
    }
}


/* drop down */
.dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            display: block;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background-color: #555;
        }

        /* .dropdown:hover .dropdown-content {
            display: block;
        } */
        .dropdown.active .dropdown-content {
            display: block;
        }
 </style>
 <script>
        // JavaScript to toggle dropdown on click
        document.addEventListener("DOMContentLoaded", function () {
            var dropdowns = document.querySelectorAll(".dropdown");

            dropdowns.forEach(function (dropdown) {
                dropdown.addEventListener("click", function () {
                    dropdowns.forEach(function (otherDropdown) {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove("active");
                        }
                    });

                    dropdown.classList.toggle("active");
                });
            });

            // Close the dropdown if the user clicks outside of it
            window.addEventListener("click", function (event) {
                dropdowns.forEach(function (dropdown) {
                    if (!dropdown.contains(event.target)) {
                        dropdown.classList.remove("active");
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="side-nav">
            <h2>Admin Dashboard</h2>
            <ul>
                <li class="dropdown">
                    <!-- <a href="budget_head.php"> -->
                        <p> Budget Head</p>
                        <div class="dropdown-content">
                            <a href="budget_head.php">Add</a>
                            <a href="view_budget_heads.php">View</a>
                        </div>
                </li>
            </ul>
            <ul>
                <li class="dropdown">
                    <p> Department</p>
                    <div class="dropdown-content">
                        <a href="add_department.php">Add</a>
                        <a href="view_department.php">View</a>
                    </div>
                </li>
            </ul>
            <ul>
                <li class="dropdown">
                    <!-- <a href="sanction_amount.php"> -->
                        <p> Amount</p>
                        <div class="dropdown-content">
                            <a href="sanction_amount.php">Add</a>
                            <a href="view_amount.php">View</a>
                        </div>
                    
                </li>
            </ul>
            <ul>
                <li class="dropdown">
                    <!-- <a href="process_bill.php"> -->
                        <p> Bills</p>
                        <div class="dropdown-content">
                            <a href="process_bill.php">Add</a>
                            <a href="view.php">View</a>
                        </div>
                </li>
            </ul>
            <ul>
                <li class="dropdown">
                    <!-- <a href="add_case_worker.php"> -->
                        <p> Case Worker</p>
                        <div class="dropdown-content">
                            <a href="add_case_worker.php">Add</a>
                            <a href="view_case_worker.php">View</a>
                        </div>
        
                </li>
            </ul>
            <ul>
                <li class="dropdown">
                    <!-- <a href="add_user.php"> -->
                        <p> Users</p>
                        <div class="dropdown-content">
                            <a href="add_user.php">Add</a>
                            <a href="view_users.php">View</a>
                        </div>
                
                </li>
                
            </ul>
            <ul>
                <li><a href="admin_logout.php"><p> Signout</p></a></li>
            </ul>
        </div>
    </div>
</body>
</html>
