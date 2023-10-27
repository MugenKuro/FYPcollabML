<?php
	include '.\entity\Db.php';
    include 'viewSellerController.php';
    include 'viewItemController.php';
	include 'editItemController.php';
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
  
	$item_id = '';
	$item_name = '';
	$price = '';
	$category_id = '';
	$description = '';
	$item_image_path = '';
  
	if(isset($_GET['item_id'])) {
		
        $item_id = $_GET['item_id'];
		$sellerEntity = new sellerEntity;
		$result = $sellerEntity -> dataForEdit($item_id);

		if($result)
		{
			foreach($result as $row)
        	{
				$item_id = $row['item_id'];
				$item_name = $row['item_name'];
				$price = $row['price'];
				$category_id = $row['category_id'];
				$description = $row['description'];
				$quantity = $row['quantity'];
				$item_image_path = $row['item_image_path'];
			}
		}
	}
	
		if(isset($_POST["submit"]))
		{
			$item_id = $_POST['item_id'];
			$item_name = $_POST['item_name'];
			$price = $_POST['price'];
			$description = $_POST['description'];
			$quantity = $_POST['quantity'];
			
			$sellerEntity = new sellerEntity;
			$categories = $sellerEntity->getCategoriesForDropdown();

			$selected_category_id = $_POST['category_id'];
			$category_id = null;
			foreach ($categories as $category) {
				if ($category['category_id'] == $selected_category_id) {
					$category_id = $selected_category_id;
					break;
				}
			}
			
			$is_image_uploaded = !empty($_FILES["item_image_path"]["name"]);
			
			if ($is_image_uploaded) {
				$target_dir = "./images/";		
				$target_file = $target_dir . basename($_FILES["item_image_path"]["name"]);
				$uploadsuccess = 1;
				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
				
				$check = getimagesize($_FILES["item_image_path"]["tmp_name"]);
				if ($check === false) {
					echo "File is not an image.";
					$uploadsuccess = 0;
				}
				
				if ($_FILES["item_image_path"]["size"] > 500000) {
					echo "Sorry, your file is too large.";
					$uploadsuccess = 0;
				}
				
				if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					echo "Sorry, only JPG,, JPEG & PNG files are allowed.";
					$uploadsuccess = 0;
				}
				
				if ($uploadsuccess == 0) {
					echo "Sorry, your file was not uploaded.";
				} else {
					if (move_uploaded_file($_FILES["item_image_path"]["tmp_name"], $target_file)) {
						echo "The file " . htmlspecialchars(basename($_FILES["item_image_path"]["name"])) . " has been uploaded..";
						$item_image_path = $target_file;
					} else {
						echo "Sorry, there was an error uploading your file.";
						
					}
				}
			} else {
				 $item_image_path = isset($_POST['item_image_path']) ? $_POST['item_image_path'] : $item_image_path;
			}
			
			$sellerEntity = new itemEdit;
			$result = $sellerEntity ->updateItem([
				'item_id' => $item_id,
				'item_name' => $item_name,
				'price' => $price,
				'category_id' => $category_id,
				'description' => $description,
				'item_image_path' => $is_image_uploaded ? $item_image_path : '',
				'quantity' => $quantity
			]);
			
			if($result)
			{
				header("Location: sellerHomepage.php");
			}else{
				echo "Failed to edit.";
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
    ?>
    
	<form action="editItem.php" method="POST" enctype="multipart/form-data">
	<div class="view-listing-container">
			<div class="view-listing-container01">
			<br/>
			   <h3 class="heading-gap">Update Item</h3>
			<br/>
				<table align="center">
				<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
				<tr>
					<td><label for="item_image_path"></label>
					<img src="<?php echo $item_image_path; ?>" alt="Item Image">
					<input type="file" class="form-control" id="item_image_path" placeholder="Image" name="item_image_path" value="<?php echo $item_image_path?>"></td>
				</tr>
				<tr>
					<td><label for="item_name">Name of Item: </label>
					<input type="text" id="item_name" placeholder="Item Name" name="item_name" value="<?php echo $item_name ?>"></td>
				</tr>
				<tr>
					<td><label for="price">Price: </label>
					<input type="text" id="price" placeholder="Price" name="price" value="<?php echo $price ?>"></td>
				</tr>
				<tr>
					<td><label for="category_id">Category: </label>
						<select id="category_id" name="category_id">
							<?php
							$sellerEntity = new sellerEntity;
							$categories = $sellerEntity->getCategoriesForDropdown();

							foreach ($categories as $category) {
								$category_id_loop = $category['category_id'];
								$category_name = $category['category_name'];
								echo "<option value='$category_id_loop' " . ($category_id == $category_id_loop ? 'selected' : '') . ">$category_name</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="quantity">Quantity: </label>
					<input type="text" id="quantity" placeholder="Quantity" name="quantity" value="<?php echo $quantity?>"></td>
				</tr>
				<tr>
					<td><label for="description">Description: </label>
					<input type="text" id="description" placeholder="Description" name="description" value="<?php echo $description ?>"></td>
				</tr>
				<tr>
					<td class="button-container">
						<input type="submit" name="submit" value="Update"></div>
						<a href="sellerHomepage.php"><button type="button">Cancel</button></a>
					</td>
				</tr>
				</table>
			</div>
	</div>
	</form>

</body>
</html>