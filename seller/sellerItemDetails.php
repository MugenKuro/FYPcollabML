<?php
require_once __DIR__ . '/../entity/users.php';
require_once __DIR__ . '/../controller/sellerController.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../sellerAuth.php';
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/sellerStyle.css" rel="stylesheet">


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
		$sellerController = new sellerController;
        $itemData = $sellerController -> getItemData($item_id);
        $row = mysqli_fetch_assoc($itemData);
    $sellerData = $sellerController -> getSellerData($item_id);
        $row2 = mysqli_fetch_assoc($sellerData);
    $itemAverageRating = $sellerController->getItemAverage($item_id);
        $row3= mysqli_fetch_assoc($itemAverageRating);
    $itemRating = $sellerController ->getItemReviews($item_id);
    if($itemRating) {
        $row4= mysqli_fetch_assoc($itemRating);
    }
    $itemInventory= $sellerController->getInventory($item_id);
}

    if(isset($_POST["deleteItem"]))
    {
        $item_id = $_POST['item_id'];

        $sellerController = new sellerController;
        $result = $sellerController -> deleteItem($item_id);
        echo "<script>location.replace('./sellerHomepage.php');</script>";
		exit();
   
    }
	
	if (isset($_GET['search'])) {
		$sellerController = new sellerController();
        $inputdata = isset($_GET['search']) ? $_GET['search'] : '';
		$search = $sellerController->searchItem($inputdata);
		
		if(!empty($inputdata)) {
			$result = $search;
		}
	}
	?>
	
    <?php
    include dirname(__FILE__) . ('/sellerNavBar.php');
    ?>
	
    <div>
    <div class="view-item-container">
            <div class="view-item-container01">
                <div id="message"></div>
                <div class="view-item-container02">
            <?php 
            if($itemData)
            {    
            ?>
            <img alt="image" class ="view-item-image" src="..<?php echo $row['item_image_path']?>"></img>
            <div class="view-item-container03">
            <div class="view-item-container04">
            <span class="view-item-text">
            <span class = "item-details-text-underline">Item Name :</span>
            <br>    
            </span>
            <span class = "item-details-text"><?=$row['item_name'] ?></span>
            <span class="view-item-text03">
                <span>$</span>
                    <span><?=$row['price'] ?></span><br />
                </span>
            </div>
            <div class="view-item-container05">
                            <div class="view-item-container06">
                                <img alt="image" src="..<?php echo $row2["profile_image"] ?>" class="view-item-image1" />
                                <div class="view-item-container07">
                                    <span class="view-item-text07">
                                        <span>
                                           <?=$row2['seller_name']?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                        <label for="size">Size</label>
                                        <select id="size" name="size" class=" Dropdown-Inventory"
                                            style="margin-bottom: 5px;">
                                            <option value="free">check size and item stock here</option> 
                                            <?php
                                                foreach ($itemInventory as $item) {
                                                    $item_id_loop = $item['item_id'];
                                                    $itemSize = $item['size']; 
                                                    $quantity = $item['quantity'];
                                                    echo '<option value="'.$itemSize.'">'.$itemSize .' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          '.$quantity.'</option>';
                                                }
                                            ?>
                                        </select>
                            </div>
                        </div>
                    </div>

                    <div class="view-item-container09"></div>
                    <div class="view-item-container10">
                        <span class="view-item-text16">
                            <span class="view-item-text17">Category</span><br />
                        </span>
                        <span class="view-item-text19">
                            <span><?php echo $row['category_name']; ?></span>
                            <br />
                        </span>
                    </div>
                    <div class="view-item-container11">
                        <span class="view-item-text22">
                            <span class="view-item-text23">Description</span><br /> 
                        </span>
                        <span class="view-item-text25">&gt;<?php echo $row['description']; ?></span>
                    </div>
                    <div class="view-item-container12"></div>
                    <div class="view-item-container10">
                        <span class="view-item-text16">
                            <span class="view-item-text17">Reviews</span><br />
                        </span>
                        <span class="view-item-text33">
                        <span><?php if($row3["average_value"]){echo "Average : " . $row3["average_value"] . "stars";}?></span>
                            <br />
                        </span>
                        <span class="view-item-text33">
                        <span><?php echo $row3["Review_count"] ?> Reviews</span>
                            <br />
                        </span>
                    </div>
                    </div>
            
            <?php if($itemAverageRating){?>
       
            <div class="container-overflow">
            <div class="item-review-container">
            <?php
             }
                if($itemRating){
                foreach($itemRating as $row4){?>
                    <div class="view-item-container14">
                                    <img alt="image" src="..<?php echo $row4["image_path"] ?>" class="view-item-image2" />
                                    <div class="view-item-container15">
                                        <div class="view-item-container16">
                                            <span class="view-item-text36">
                                                <span>
                                                <?php echo $row4["nickname"] ?>
                                                </span>
                                                <br />
                                            </span>
                                            <span class="view-item-text39">
                                                <span class="view-item-text40">
                                                <?php echo $row4["rating_value"] ?> star
                                                </span>
                                                <br />
                                            </span>
                                        </div>
                                        <span class="view-item-text42">
                                            <span>
                                            <?php echo $row4["review_text"] ?>
                                            </span>
                                            <br />
                                        </span>
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

    <?php
        }
  ?>
 

</body>
</html>