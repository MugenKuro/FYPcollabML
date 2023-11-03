<!doctype html>
<html lang="en">
<?php
require_once('../entity/users.php');
require_once('../controller/sellerController.php');
require_once('../auth.php');
require_once('../sellerAuth.php');

if(isset($_POST["requestCategory"])){
    $category = $_POST['category'];
    $sellerEntity = new sellerRequest();
    $result = $sellerEntity->requestCategory($category);
    if($result)
    {
        header("Location: sellerRequestCategory.php");
    } 
}
?>

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

    
    <div class="seller-container">
        <div class="seller-container01">
            <div class= "centering-div">
                    <br>
                    <span class= "seller-setting-header">Request for new category</span>
                    </br>
                    <table class ="seller-edit-setting-table">
                    <tr>
                    <td class ="seller-edit-setting-table-td"><label for="category_id">Category List: </label></td>
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
                    <form action="sellerRequestCategory.php" method="POST">
                    <tr>
                        <td class ="seller-edit-setting-table-td">
                        <span>Category Request: </span>
                        </td>
                        <td class ="seller-edit-setting-table-td"><input class="seller-input-request-category" type="text" name="category" placeholder = "insert category name"></input></td>
                    </tr>
                    <tr>
                                <div class= "seller-setting-button-container">
                                <td class="seller-edit-setting-button-td">
                                <input type="submit" name="requestCategory" class="seller-setting-button" value="Submit"></input>
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
                            
                    <br>
                    <span class= "seller-setting-header">Request status</span>
                    <br>
                    <table class ="seller-edit-setting-table">
                        <tr>
                            <td class ="seller-request-category-table-td"> <span>Category Name</span></td>
                            <td class ="seller-request-category-table-td"> <span>Status</span></td>
                            <br>
                        </tr>
                            <?php
                            $categoryRequests = new viewRequest;
                            $result = $categoryRequests->showRequests();
                            if ($result){
                            // output data of each row
                            foreach ($result as $row){
                            ?>  
                            <tr>
                            <td class ="seller-edit-setting-table-td"> <span><?php echo $row["category_name"] ?></span></td>
                            <td class ="seller-edit-setting-table-td"> <span><?php echo $row["status"] ?></span></td>
                            </tr>
                            <?php                    
                            }}        
                            ?>


                        </div>
                        </div>
                        </div>
</body>

</html>