<?php
	include '.\entity\Db.php';
    include 'viewSellerController.php';
    include 'viewItemController.php';
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
	
  <?php
  
	if(isset($_GET['item_id'])) {
		
        $item_id = $_GET['item_id'];
		$sellerEntity = new sellerEntity;
		$itemData = $sellerEntity -> getItemData($item_id);

		if($itemData)
		{
			$row = mysqli_fetch_assoc($itemData);
		}
        $sellerData = $sellerEntity -> getSellerData($item_id);
        if($sellerData){
            $row2 = mysqli_fetch_assoc($sellerData);
        }
        $itemAverageRating = $sellerEntity->getItemAverage($item_id);
        if ($itemAverageRating){
            $row3= mysqli_fetch_assoc($itemAverageRating);
        }
        $itemRating = $sellerEntity ->getItemReviews($item_id);
        if($itemRating){
            $row4= mysqli_fetch_assoc($itemRating);
        }

	}

    if(isset($_POST["deleteItem"]))
    {
        $item_id = $_POST['item_id'];

        $sellerEntity = new sellerEntity;
        $result = $sellerEntity -> deleteItem($item_id);
            
        if($result)
        {
            header("Location: sellerHomepage.php");
			exit();
        }else{
            echo "Failed";
        }
    }
	
	if (isset($_GET['search'])) {
		$sellerEntity = new sellerEntity();
        $inputdata = isset($_GET['search']) ? $_GET['search'] : '';
		$search = $sellerEntity->searchItem($inputdata);
		
		if(!empty($inputdata)) {
			$result = $search;
		}
	}
	?>
	
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
	
    
    <div class="seller-container">
        <div class="seller-container01">
            <?php 
            if($itemData)
            {    
            ?>
            <div class="item-details-container">
            <img alt="image" class ="view-item-image" src=".<?php echo $row['item_image_path']?>"/>

            <div class="item-name-price-container">
            <span class = "item-details-text-underline">Item Name :</span>
            <span class = "item-details-text"><?=$row['item_name'] ?></span>
            <span class = "item-details-text-underline">Price :</span>
            <span class = "item-details-text">$<?=$row['price'] ?></span>
            </div>
            </div>

            <div class="item-category-description-container">
            <span class = "item-details-text-underline">Category :</span>
            <span class = "item-details-text"><?php echo $row['category_name']; ?></span>
            <span class = "item-details-text-underline">Description :</span>
            <span class = "item-details-text-description"><?php echo $row['description']; ?></span>
            </div>
            
            <div onclick="window.location='viewReviews.php'" class = "item-review-header-container">
            <span class = "item-details-text-underline">Reviews :</span>
            <span class = "item-details-average-rating"><?php if($row3["average_value"]){echo "Average : " . $row3["average_value"] . "stars";}?></span>
            </div>

            
            <?php if($itemAverageRating){?>
                <span class = "item-details-text"><?php echo $row3["Review_count"] ?> Reviews</span>
            <div class="container-overflow">
            <div class="item-review-container">
            <?php
             }
                if($itemRating){
                foreach($itemRating as $row4){?>
                    <div class="item-review-detail-container">
                    <img class="item-review-image" alt="image" src=".<?php echo $row4["image_path"] ?>" />
                    <div class="item-review-text-container">
                    <span class="item-review-text"><?php echo $row4["nickname"] ?></span><br>
                    <span class="item-review-text"> (<?php echo $row4["rating_value"] ?> stars)</span><br><br>
                    <span class="item-review-text"></span>
                    <span class="item-review-text"><?php echo $row4["review_text"] ?></span>
                    </div>
                    </div>
                    <?php }}?>
            </div>
            </div>
                <div class="centering-div">
                <table class ="seller-edit-setting-table">
                    <tr>
                    <td class="seller-edit-setting-button-td">
                    <a href="editItem.php?item_id=<?php echo $item_id; ?>"><button  class="seller-setting-button" type="submit" name="editItemForm">Update Item</button>
					<input type="hidden" name="item_id" value="<?php echo $item_id; ?>"></span>
                    </td>
                    <td class="seller-edit-setting-button-td">
                    <form action='#' method="POST" id="deleteItemForm">
										<button  class="seller-setting-button1" type="submit" name="deleteItem">Delete Item</button>
										<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
									</form></button>
                    </td>
                    </tr>
                    </table>
                    </div>
                    </div>
                    <span>
                                    
                                    <?php
                            if ($sellerData){
                        ?>
        
                                <img alt="image" src=".<?php echo $row["item_image_path"] ?>" />
            
                                        <span><?=$row2['seller_name']?></span>
                                        <span><?=$row2['rating_value']?>star</span>
                        <?php
                                }
                        ?>
        </div>
    </div>
                   

    <?php
        }
  ?>
 

</body>
</html>