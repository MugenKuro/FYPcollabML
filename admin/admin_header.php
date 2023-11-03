<?php
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and their role matches the allowed roles for this page
if (isset($_SESSION['accountType'])) {
    $userRole = $_SESSION['accountType'];

    // Define the allowed roles for this page
    $allowedRoles = array("System Admin");

    // Check if the user's role is allowed
    if (!in_array($userRole, $allowedRoles)) {
        // User has access, continue with the page
        header("location: ../login.php"); // You can create an "access_denied.php" page
        exit;
    }
} else {
    // User is not logged in, redirect them to the login page
    header("location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>System Admin</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- JS -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            background: #f5f5f5;
            color: #333;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px;
            margin: 30px 0;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 10px 20px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 0;
            font-size: 24px;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        table.table th,
        table.table td {
            padding: 10px;
            vertical-align: middle;
            text-align: left;
        }

        table.table th:first-child,
        table.table td:first-child {
            width: 60px;
        }

        table.table th:last-child,
        table.table td:last-child {
            width: 100px;
        }

        table.table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table.table-hover tbody tr:hover {
            background: #e0e0e0;
        }

        table.table th i {
            font-size: 16px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 18px;
        }

        table.table td a {
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #0056b3;
        }

        table.table td a.edit {
            color: #ffc107;
        }

        table.table td a.delete {
            color: #f44336;
        }

        table.table td i {
            font-size: 18px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
            width: 32px;
            height: 32px;
        }
    </style>

</head>
<body>
    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="iCloth navigation bar">
        <div class="container">
            <a class="navbar-brand" href="">iCloth</a>
            <div class="collapse navbar-collapse">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li>
                        <a class="nav-link" href="view_seller.php">View Sellers</a>
                        <a class="nav-link" href="view_customer.php">View Customers</a>
                        <a class="nav-link" href="view_category.php">View Categories</a>
                        <a class="nav-link" href="view_registration_request.php">Registration Requests</a>
                        <a class="nav-link" href="view_deactivation_request.php">Deactivation Requests</a>
                        <a class="nav-link" href="handle_category_request.php">Category Requests</a>
                    </li>
                </ul>
                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><span class="nav-link">Welcome,
                            <?php echo htmlspecialchars($_SESSION["username"]); ?>
                        </span></li>
                    <li><a class="nav-link" href="../logout.php"><img src="../images/user.svg"><span> log out</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
<!-- End Header/Navigation -->
</body>
</html>



