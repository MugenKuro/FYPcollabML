<?php
	include './entity/users.php';
    include 'viewSellerController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>iCloth</title>
</head>

<body>

<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="iCloth navigation bar">

<div class="container">
<a class="navbar-brand" href="sellerHomepage.php">iCloth</a>

<div class="collapse navbar-collapse">
    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
        <li>
        <a class="nav-link" href="sellerHomepage.php">Item Listings</a>
            <a class="nav-link" href="addItem.php">Add Items</a>
            <a class="nav-link" href="sellerAccountSetting.php">Account Setting</a>
            <a class="nav-link" href="sellerRequestCategory.php">Category Requests</a>
            <a class="nav-link" href="view_revenue_report.php">Revenue Report</a>
            <a class="nav-link" href="view_inventory.php">Manage Inventory</a>
        </li>
    </ul>
    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
        <li><span class="nav-link">Welcome,
                <?php echo htmlspecialchars("seller"); ?>
            </span></li>
            <li><a class="nav-link" href="logout.php"><img src="images/user.svg"><span> log out</span></a></li>
    </ul>
</div>
</div>
</nav>
<!-- End Header/Navigation -->

    
	<?php
	if (isset($_GET['search'])) {
		$sellerEntity = new sellerEntity();
        $inputdata = isset($_GET['search']) ? $_GET['search'] : '';
		$search = $sellerEntity->searchItem($inputdata);
		
		if(!empty($inputdata)) {
			$result = $search;
		} 
	}
	?>
            <div class="search">
			<form action="searchItem.php" method="GET" class="input-group">
				<input type="text" class="form-control" placeholder="Search" name="search" value="<?php if(isset($_GET['search'])) {echo $_GET['search']; }?>">
				<div class="input-group-append">
					<button class="btn btn-secondary" type="submit" style="background-color: #10a4e3; border-color:#10a4e3 ">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>
		</div>
    
    <div class = "tableScroll">
	        <div class="seller-container">
            <div class="seller-container01">
        <?php 
    $seller = new sellerView;
    $result = $seller ->showItems();
    if($result)
    {
        foreach($result as $row)
        {
    ?>
        <a class= "seller-listing-container" href="sellerItemDetails.php?item_id=<?php echo $row['item_id']; ?> ">
        <div >
		    <span><img class = "seller-listing-container-image" src=".<?php echo $row['item_image_path']?>" width="300" height="300" ></span>
            <p class ="seller-listing-container-text"><?=$row['item_name'] ?> </p>
            <p class ="seller-listing-container-text">$<?=$row['price'] ?></p>
        </div>
        </a>
        <?php
        }
    }
  ?>
		</div>
		</div>
    </div>

</body>
</html>