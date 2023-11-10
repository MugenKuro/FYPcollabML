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
    <!-- <link rel="stylesheet" href="../css/style.css"> -->

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

        .nav-link {
            display: inline;
            margin-right: 10px;
            /* Add some spacing between the links if needed */
        }
        .custom-navbar-nav li a,
        .custom-navbar-cta li {
            white-space: nowrap; /* Prevent line wrapping */
        }


        .custom-navbar {
            background: #0988be !important;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .custom-navbar .navbar-brand {
            font-size: 32px;
            font-weight: 600;
        }

        .custom-navbar .navbar-brand>span {
            opacity: .4;
        }

        .custom-navbar .navbar-toggler {
            border-color: transparent;
        }

        .custom-navbar .navbar-toggler:active,
        .custom-navbar .navbar-toggler:focus {
            -webkit-box-shadow: none;
            box-shadow: none;
            outline: none;
        }

        @media (min-width: 992px) {
            .custom-navbar .custom-navbar-nav li {
                margin-left: 15px;
                margin-right: 15px;
            }
        }

        .custom-navbar .custom-navbar-nav li a {
            font-weight: 500;
            color: #ffffff !important;
            opacity: .5;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
            position: relative;
        }

        @media (min-width: 768px) {
            .custom-navbar .custom-navbar-nav li a:before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 8px;
                right: 8px;
                background: #f9bf29;
                height: 5px;
                opacity: 1;
                visibility: visible;
                width: 0;
                -webkit-transition: .15s all ease-out;
                -o-transition: .15s all ease-out;
                transition: .15s all ease-out;
            }
        }

        .custom-navbar .custom-navbar-nav li a:hover {
            opacity: 1;
        }

        .custom-navbar .custom-navbar-nav li a:hover:before {
            width: calc(100% - 16px);
        }

        .custom-navbar .custom-navbar-nav li.active a {
            opacity: 1;
        }

        .custom-navbar .custom-navbar-nav li.active a:before {
            width: calc(100% - 16px);
        }

        .custom-navbar .custom-navbar-cta {
            margin-left: 0 !important;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
        }

        @media (min-width: 768px) {
            .custom-navbar .custom-navbar-cta {
                margin-left: 40px !important;
            }
        }

        .custom-navbar .custom-navbar-cta li {
            margin-left: 0px;
            margin-right: 0px;
        }

        .custom-navbar .custom-navbar-cta li:first-child {
            margin-right: 20px;
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



