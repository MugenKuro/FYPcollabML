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

    if($itemData)
    { 
       
    ?>
	
	   <div>
        <div class="view-listing-container">
            <div class="view-listing-container01">
                <div class="view-listing-container02">
                    <img alt="image" src="/fyp2/<?php echo $row['item_image_path']?>" class="view-listing-image" />
                    <div class="view-listing-container03">
                        <div class="view-listing-container04">
                            <span class="view-listing-text">
                                <span class="view-listing-text01"><?=$row['item_name'] ?></span>
                                <br />
                            </span>
                            <span class="view-listing-text03">
                                <span>$</span>
                                <span><?=$row['price'] ?></span>
                                <br />
                            </span>
                        </div>
                        <?php
                                if ($sellerData){
                        ?>
                        <div class="view-listing-container05">
                            <div class="view-listing-container06">
                                <img alt="image" src="<?php echo $row["item_image_path"] ?>" class="view-listing-image1" />
                                <div class="view-listing-container07">
                                    <span class="view-listing-text07">
                                        <span><?=$row2['seller_name']?></span>
                                        <br />
                                    </span>
                                    <span class="view-listing-text10">
                                        <span class="view-listing-text11"><?=$row2['rating_value']?>star</span>
                                
                                        <br />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                        ?>
                    </div>
                    <div class="view-listing-container08"></div>
                    <div class="view-listing-container09">
                        <span class="view-listing-text13">
                            <span class="view-listing-text14">Category</span>
                            <br />
                        </span>
                        <span class="view-listing-text16">
                            <span><?php echo $row['category_name']; ?></span>
                            <br />
                        </span>
                    </div>
                    <div class="view-listing-container10">
                        <span class="view-listing-text19">
                            <span class="view-listing-text20">Description</span>
                            <br />
                        </span>
                        <span class="view-listing-text22"><?=$row['description'] ?></span>
                    </div>
                    <div class="view-listing-container11"></div>
                    <div class="view-listing-container12">

                    <?php
                                 if($itemAverageRating){
                        ?>
                        <span class="view-listing-text23" onclick="window.location='viewReviews.php'">
                            <span>Reviews</span>
                            <br />
                        </span>
                        <span class="view-listing-text26">
                            <span><?php if($row3["average_value"]){echo $row3["average_value"] . "stars" . "<bxr>";}?></span>
                        </span>
                        <span class="view-listing-text30">
                            <span><?php echo $row3["Review_count"] ?> Reviews</span>
                            <br />
                        </span>
                        <?php
                                }
                                 if($itemRating){
                                foreach($itemRating as $row4)
                                {
                        ?>
                        <div class="view-listing-container16">
                            <img alt="image" src="<?php echo $row4["image_path"] ?>" class="view-listing-image3" />
                            <div class="view-listing-container17">
                                <div class="view-listing-container18">
                                    <span class="view-listing-text42">
                                        <span><?php echo $row4["nickname"] ?></span>
                                        <br />
                                    </span>
                                    <span class="view-listing-text45">
                                        <span class="view-listing-text46"><?php echo $row4["rating_value"] ?> stars</span>
                                        <br />
                                    </span>
                                </div>
                                <span class="view-listing-text48">
                                    <span><?php echo $row4["review_text"] ?></span>
                                    <br />
                                </span>
                            </div>
                        </div>
                        <?php
                                }}
                        ?>
                        <button type="button" class="view-listing-button button"  onclick="window.location='viewReviews.php'">
                            <span class="view-listing-text60">
                                <span class="view-listing-text61">View more</span>
                                <br />
                            </span>
                        </button>
                    </div>
                    <div class="view-listing-container22">
                        <div class="view-listing-container23">
                                <span class="view-listing-text60">
									<a href="editItem.php?item_id=<?php echo $item_id; ?>"><button type="submit" class="view-listing-button button" name="editItemForm">Update Item</button>
									<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                                </span>
                            </button>
                                <span class="view-listing-text66">
                                    <form action='#' method="POST" id="deleteItemForm">
										<button type="submit" class="view-listing-button2 button" name="deleteItem">Delete Item</button>
										<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
									</form>
                                    <br/>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <?php
        }
  ?>
 

</body>
</html>