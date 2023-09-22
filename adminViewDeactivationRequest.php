<head>
    <style>
        .tab{
            background-color: #f1f1f1;
            height: 60px;
            width: 100%;

        }
        .tabs{
            border: none;
            background-color: inherit;
            font-size: 20px;
            padding: 18px;
            float: left;
        }
        .tab button:hover {
            background-color: #ddd;
        }
        .logoutButton{
            float: right;
        }
        table{
            width: 100%;
        }
        .tabTable button{
            width: 100%;
        }
        td, th {
            text-align: left;
            border: 1px solid black;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="tab">
<form action="adminViewDeactivationRequest.php">
<button style="background-color: #d5d5d5" class="tabs">View Deactivation Request</button>
</form>
<form action="adminViewAllCategory.php">
<button class="tabs">View All Category</button>
</form>
<form action="adminViewCategoryRequest.php">
<button class="tabs">View Category Request</button>
</form>
<form action="adminAcceptSeller.php">
<button class="tabs">Accept New Seller</button>
</form>
<form class="logoutButton" action="login.php">
<button class="tabs">Log Out</button>
</form>
</div>

<div>
<table class="tabTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Number</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td>1002</td>
        <td>Customer1</td>
        <td>Customer1@gmail.com</td>
        <td>88888888</td>
        <td><button>Accept</button></td>
        <td><button>Reject</button></td>
    </tr>
    <tr>
        <td>1003</td>
        <td>Customer2</td>
        <td>Customer2@gmail.com</td>
        <td>88888889</td>
        <td><button>Accept</button></td>
        <td><button>Reject</button></td>
    </tr>
  </table>
</body>