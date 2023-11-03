<?php
require_once('../entity/users.php');
require_once('../controller/sellerController.php');
require_once('../auth.php');
require_once('../sellerAuth.php');
	
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
  
		if(isset($_POST["submit"]))
		{
			$item_name = $_POST['item_name'];
			$price = $_POST['price'];
			$description = $_POST['description'];
			$quantity = $_POST['quantity'];
			$size = $_POST['size'];
			
			$sellerEntity = new sellerEntity;
			$categories = $sellerEntity->getCategoriesForDropdown();

			$selected_category_id = $_POST['category_id'];
			foreach ($categories as $category) {
				if ($category['category_id'] == $selected_category_id) {
					$category_id = $selected_category_id;
					break;
				}
			}
			
			
			$target_dir = "../images/item_images/";		
			$target_file = $target_dir . basename($_FILES["item_image_path"]["name"]);
			$uploadsuccess = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			
			$check = getimagesize($_FILES["item_image_path"]["tmp_name"]);
			if ($check === false) {
				echo "File is not an image.";
				$uploadsuccess = 0;
			}
			
			if ($_FILES["item_image_path"]["size"] > 500000000000) {
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
				echo "The file " . htmlspecialchars(basename($_FILES["item_image_path"]["name"])) . "has been uploaded..";
				$item_image_path = $target_file;
			
			$sellerEntity = new itemAdd;
			$result = $sellerEntity -> addItem([
				'item_name' => $item_name,
				'price' => $price,
				'category_id' => $category_id,
				'description' => $description,
				'item_image_path' => $item_image_path,
				'quantity' => $quantity,
				'size' => $size
			]);
			
			if($result)
			{
				header("Location: sellerHomepage.php");
			}else{
				echo "Failed to add.";
			}}
             else { 
				echo "Sorry, there was an error uploading your file.";
				}
			}
		}
    ?>
	<div>
        <div class="seller-container">
            <div class="seller-container01">
                        <div class= "centering-div">
                        <span class= "seller-setting-header">Add Item</span>

                        <form action="addItem.php" method="POST" enctype="multipart/form-data">
                        <table class ="seller-edit-setting-table">
                            <tr>
                                <td class ="seller-edit-setting-table-td"><span>Image</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="file" id="item_image_path" placeholder="Image"
                                    name="item_image_path" value=""></input></td>
                            </tr>
                            <tr>
                                <td class ="seller-edit-setting-table-td"> <span>Item Name</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="item name" name="item_name"
                                    class="seller-settings-textinput input" /></input></td>
                            </tr>
                            <tr>
                                <td class ="seller-edit-setting-table-td"><span>Price</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="text" placeholder="Price" name="price"
                                    class="seller-settings-textinput input" /></input></td>
                            </tr>
                            <tr>
							<td class ="seller-edit-setting-table-td"><label for="category_id">Category: </label></td>
							<td class ="seller-edit-setting-table-td">
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
                                <td class ="seller-edit-setting-table-td">  <span>Quantity</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="Quantity" name="quantity"
                                    class="seller-settings-textinput input" /></input></td>
                            </tr>

                            <tr>
                                <td class ="seller-edit-setting-table-td"><span>Size</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="text" placeholder="Size" name="size"
                                    class="seller-settings-textinput input" /></input></td>
							</tr>
							<tr>
                                <td class ="seller-edit-setting-table-td"> <span>Description</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="Description" name="description"
                                    class="seller-settings-textinput input" /></input></td>
                            <tr>
                                <div class= "seller-setting-button-container">
                                <td class="seller-edit-setting-button-td">
                                <input type="submit" name="submit" class="seller-setting-button" value="Add"></input>
                                </td>
                                <td class="seller-edit-setting-button-td">
                                <button type="button" class="seller-setting-button1"
                                onclick="window.location='sellerHomepage.php'">
                                    <span>Cancel</span></button>
                                </td>
                                </div>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>