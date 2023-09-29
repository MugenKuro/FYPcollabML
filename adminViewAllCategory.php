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
            .addCategory{
            width: 25%;
            padding: 10px;
        }
    </style>
</head>

<body>
<div class="tab">
<form action="adminViewDeactivationRequest.php">
<button class="tabs">View Deactivation Request</button>
</form>
<form action="adminViewAllCategory.php">
<button style="background-color: #d5d5d5"  class="tabs">View All Category</button>
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
<br>
<div>
    <form action="" >
    <p>Add Category</p>
    <input  class="addCategory" type="text" placeholder="Category Name"></input>
    <button class="addCategory">Add Category</button>
    </form>

    <table class="tabTable">

        <tr>
        <th>ID
        <th>Category name</th>
        <th></th>
        <th></th>
        </tr>

        <tr>
            <td>1</td>
            <td>Shirt</td>
            <td><button>Edit</button></td>
            <td><button>Delete</button></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Pants</td>
            <td><button>Edit</button></td>
            <td><button>Delete</button></td>
        </tr>
    </table>
</div>
</body>