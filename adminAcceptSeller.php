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
        .sellerTab{
            display: none;
        }
    </style>
</head>

<body>
<div class="tab">
<form action="adminViewDeactivationRequest.php">
<button class="tabs">View Deactivation Request</button>
</form>
<form action="adminViewAllCategory.php">
<button  class="tabs">View All Category</button>
</form>
<form action="adminViewCategoryRequest.php">
<button   class="tabs">View Category Request</button>
</form>
<form action="adminAcceptSeller.php">
<button style="background-color: #d5d5d5" class="tabs">Accept New Seller</button>
</form>
<form class="logoutButton" action="login.php">
<button class="tabs">Log Out</button>
</form>
</div>

<div>
<br>
  <div class="tab">
  <button class="tabs" onclick="tabCycle(event, 'businessSeller')">Business Seller</button>
  <button class="tabs" onclick="tabCycle(event, 'individualSeller')">Individual Seller</button>
  </div>
  <br>
  <div id="businessSeller" class="sellerTab">
    <p>Business Seller</p>
  <table class="tabTable">
    <tr>
        <th>ID</th>
        <th>Business Name</th>
        <th>UEN</th>
        <th>address</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td>2002</td>
        <td>business1</td>
        <td>1000000</td>
        <td>55 market street</td>
        <td><button>Accept</button></td>
        <td><button>Reject</button></td>
    </tr>
    <tr>
        <td>2003</td>
        <td>business2</td>
        <td>1000001</td>
        <td>54 market street</td>
        <td><button>Accept</button></td>
        <td><button>Reject</button></td>
    </tr>
  </table>
  </div>
  <div id="individualSeller" class="sellerTab">
    <p>Individual Seller</p>
  <table class="tabTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>DOB</th>
        <th>Number</th>
        <th>Address</th>
        <th>Passport</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td>3002</td>
        <td>Seller1</td>
        <td>01/01/1970</td>
        <td>98888888</td>
        <td>100 beach road</td>
        <td>C0001123</td>
        <td><button>Accept</button></td>
        <td><button>Reject</button></td>
    </tr>
    <tr>
        <td>3003</td>
        <td>Seller2</td>
        <td>01/01/1970</td>
        <td>98888889</td>
        <td>103 beach road</td>
        <td>C0011123</td>
        <td><button>Accept</button></td>
        <td><button>Reject</button></td>
    </tr>
    </table>
    <script>
        function tabCycle(event, tabID) {
            var i, sellerTab, tabs;
            sellerTab = document.getElementsByClassName("sellerTab");
            for (i = 0; i < sellerTab.length; i++) {
                sellerTab[i].style.display = "none";
            }
            tabs = document.getElementsByClassName("tabs");
            for (i = 0; i < tabs.length; i++) {
                tabs[i].className = tabs[i].className.replace(" active", "");
            }
            document.getElementById(tabID).style.display = "block";
            evt.currentTarget.className += " active";
        }
</script>
  </div>