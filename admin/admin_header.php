<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>System Admin</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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

    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }

    table.table-striped.table-hover tbody tr:hover {
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
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="">System Admin</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="view_seller.php">View Sellers</a></li>
                <li><a href="view_customer.php">View Customers</a></li>
                <li><a href="view_category.php">View Categories</a></li>
                <li><a href="view_registration_request.php">Registration Requests</a></li>
                <li><a href="view_deactivation_request.php">Deactivation Requests</a></li>
                <li><a href="handle_category_request.php">Category Requests</a></li>
            </ul>
        </div>
    </nav>
</body>




