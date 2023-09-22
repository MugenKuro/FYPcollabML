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

    </style>
</head>
<body>
<div class="tab">
<form action="adminViewDeactivationRequest.php">
<button class="tabs">View Deactivation Request</button>
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
</body>