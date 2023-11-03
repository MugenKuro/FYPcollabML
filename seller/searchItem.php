<?php
require_once('../entity/users.php');
require_once('../controller/sellerController.php');
require_once('../auth.php');
require_once('../sellerAuth.php');
	
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>iCloth</title>
</head>

<body>
	
<?php
    include dirname(__FILE__) . ('/sellerNavBar.php');
    ?>
	
	<?php
	if (isset($_GET['search'])) {
		$sellerEntity = new sellerEntity();
        $inputdata = isset($_GET['search']) ? $_GET['search'] : '';
		$search = $sellerEntity->searchItem($inputdata);
		
		if(!empty($search)) {

	
	?>
    <div class = "tableScroll">
	        <div class="seller-container">
            <div class="seller-container01">
        <?php 
    $seller = new sellerView;
    $result = $seller ->showItems();
    if($result)
    {
        foreach($search as $row)
        {
    ?>
        <a class= "seller-listing-container" href="sellerItemDetails.php?item_id=<?php echo $row['item_id']; ?> ">
        <div >
		    <span><img class = "seller-listing-container-image" src="..<?php echo $row['item_image_path']?>" width="300" height="300" ></span>
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

        <?php 
	} else {
		echo "No search results found.";
	}
	}
  ?>
		</div>
		</div>
    </div>

</body>
</html>