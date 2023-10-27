<?php
	include '.\entity\Db.php';
    include 'viewSellerController.php';
	
	$searchResults = [];
	
	if (isset($_GET['search'])) {
		$sellerEntity = new sellerEntity();
		$inputdata = $_GET['search'];
		$searchResults = $sellerEntity->searchItem($inputdata);
	}

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
	
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="iCloth navigation bar">

        <div class="container">
            <a class="navbar-brand" href="sellerHomepage.php">iCloth</a>

            <div class="collapse navbar-collapse">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li>
                        <a class="nav-link" href="sellerHomepage.php">Home</a>
                        <a class="nav-link" href="sellerRequestCategory.php">Request new category</a>
                        <a class="nav-link" href="sellerAccountSetting.php">Settings</a>
                    </li>
                </ul>

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

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="login.php"><img src="images/user.svg"></a></li>
                </ul>
            </div>
        </div>

    </nav>
	
	<?php
	if (isset($_GET['search'])) {
		$sellerEntity = new sellerEntity();
        $inputdata = isset($_GET['search']) ? $_GET['search'] : '';
		$search = $sellerEntity->searchItem($inputdata);
		
		if(!empty($search)) {

	
	?>
    
    <div class = "tableScroll">
		<div class="view-listing-container">
            <div class="view-listing-container01">
			<br/>
			    <div class="button-row">
				<form action='addItem.php' method="POST" id="addForm">
					<button type="submit" class="btn btn-primary" name="addItemForm">Add Item</button>
				</form>
				</div>
			<br/>
        <table>

        <?php 

    
        foreach($search as $row)
        {
    ?>
        <tr>
		    <td><a href="item_details.php?item_id=<?php echo $row['item_id']; ?>"><img src="/fyp2/<?php echo $row['item_image_path']?>" width="80" height="80" class="view-listing-image"></td>
		</tr>
		<tr>
            <td><a href="item_details.php?item_id=<?php echo $row['item_id']; ?>" class="view-listing-text01"><?=$row['item_name'] ?></td>
		</tr>
		<tr>
            <td>$<?=$row['price'] ?></td>
        </tr>
  <?php
        }
    
	} else {
		echo "No search results found.";
	}
	}
  ?>
        </table>
		</div>
		</div>
    </div>

</body>
</html>