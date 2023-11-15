<?php
require_once __DIR__ . '/../entity/users.php';
require_once __DIR__ . '/../controller/sellerController.php';
require_once __DIR__ . '/./auth.php';
require_once __DIR__ . '/./sellerAuth.php';
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

<script>
function confirmAction() {
    if (confirm("Are you sure you want to deactivate your account?")) {
        // User clicked OK, proceed with the action
        return true;
    } else {
        // User clicked Cancel, do nothing
        return false;
    }
}
</script>
</head>

<body>
    <?php
    include dirname(__FILE__) . ('/sellerNavBar.php');

    if (isset($_POST['requestDeactivation'])){
        $sellerController = new sellerController;
        $deactivate = $sellerController->deactivateUser();
    }
    
    if (isset($_POST['updateLogin'])){
        $is_image_uploaded = !empty($_FILES["item_image_path"]["name"]);
			
        if ($is_image_uploaded) {
            $target_dir = "../images/SellerLogo/";		
            $target_file = $target_dir . basename($_FILES["item_image_path"]["name"]);
            $uploadsuccess = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $filename = uniqid() . "." . $imageFileType;
            
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
                if (move_uploaded_file($_FILES["item_image_path"]["tmp_name"], $target_dir . $filename)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["item_image_path"]["name"])) . " has been uploaded..";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        $username= $_POST['username'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2']; 
        $sellerName = $_POST['seller_name']; //seller
        $description = $_POST['description']; //seller
        $preferred_category = $_POST['preferred_category'];
        $address1 = $_POST['address1']; //seller
        $address2 = $_POST['address2']; //seller
        $address3 = $_POST['address3']; //seller
        $address = $address1 . ',' . $address2 . ',' . $address3;
        $email = $_POST['email'];
        $bank_name = $_POST['bank_name'];
        $bank_account_no = $_POST['bank_account_no'];
       

        
        $sellerController = new sellerController;
            $result = $sellerController ->editSettings([
                'profile_image' => $is_image_uploaded ? $filename : '',
                'username' => $username,
                'password1' => $password1,
                'password2'=> $password2,
                'seller_name'=> $sellerName,
                'description'=> $description,
                'pick_up_address'=> $address,
                'email' => $email,
                'preferred_category' => $preferred_category,
                'bank_name'=> $bank_name,
                'bank_account_no'=> $bank_account_no
    
            ]);
            echo "<script>location.replace('./sellerAccountSetting.php');</script>";
                exit;
    }
    ?>
    <div>
        <div class="seller-container">
            <div class="seller-container01">
                        <div class= "centering-div">
    <?php
    $sellerController = new sellerController();
    $result = $sellerController->showSettings();
    $row = $result->fetch_assoc();
    ?>
                      <div class="settings-container">
            <div class="settings-container01">
                    <span class="settings-text">
                        <span>Update Account Details</span>
                        <br />
                    </span>
                </div>
                <div class="settings-container03"></div>
                <div class="settings-container04">
                    <form class="update-form" enctype="multipart/form-data" action="sellerEditSettings.php" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="email">Seller Name</label>
                                <input required  type="text" placeholder="seller name" name="seller_name" value="<?php echo $row['seller_name'] ?>"   
                                class="form-control" /></input>
                            </div>
                            <div class="col-sm-6">
                            <label for="username">Username</label>
                                <input required type="text" placeholder="username" name="username" value="<?php echo $row['username'] ?>"
                                    class="form-control" /></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="username">Email </label>
                                <input required type="text" placeholder="email" name="email"  value="<?php echo $row['email'] ?>"
                                    class="form-control" /></input>
                            </div>
                            <div class="col-sm-6">
                            <label>Preferred Category</label>
                            <select id="category_id" name="preferred_category" class= "form-control">
							<?php
							$sellerController = new sellerController;
							$categories = $sellerController->getCategoriesForDropdown();

							foreach ($categories as $category) {
								$category_id_loop = $category['category_id'];
								$category_name = $category['category_name'];
								echo "<option value='$category_id_loop' " . ($category_id == $category_id_loop ? 'selected' : '') . ">$category_name</option>";
							}
							?>
							</select>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="password">Password</label>
                                <input type="text" placeholder="password" name="password1"
                                    class="form-control" /></input>
                            </div>                           
                            <?php
                            $address= $row['pick_up_address'];
                            list($address1, $address2, $address3) = explode(',', $address);
                            ?>
                            <div class="col-sm-6">
                                <label for="address1">Address 1</label>
                                <input required  type="text" placeholder="street name" name="address1" value="<?php echo $address1 ?>"
                                    class="form-control" /></input>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="retypePassword">Re-type Password</label>
                                <input type="text" placeholder="password" name="password2"
                                    class="form-control" /></input>
                            </div>
                            <div class="col-sm-6">
                                <label for="address2">Address 2</label>
                                <input required  type="text" placeholder="blk number" name="address2" value="<?php echo $address2 ?>"
                                    class="form-control" /></input>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="gender">Bank name</label>
                                <input required  type="text" placeholder="Bank Name" name="bank_name" value="<?php echo $row['bank_name'] ?>"
                                    class="form-control" /></input>
                            </div>
                            <div class="col-sm-6">
                                <label for="address3">Address 3</label>
                                <input required  type="text" placeholder="postal code" name="address3" value="<?php echo $address3 ?>"
                                    class="form-control" /></input>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="dob">Bank Number</label>
                                <input required type="text" placeholder="Bank Number" name="bank_account_no" value="<?php echo $row['bank_account_no'] ?>"
                                    class="form-control" /></input>
                            </div>
                            <div class="col-sm-3">
                                <label for="userImage">Profile Image</label>
                                <div class="custom-file">
                                    <input type="file" id="item_image_path" placeholder="Image" name="item_image_path" class="form-control-file" value=""></input>
                                </div>
                            </div>
                            <small class="form-text text-muted col-sm-3">Leave it empty if you're not changing your
                                image.</small>

                        </div>
                       
                        <div class="form-group row">
                        <div class="col-sm-6">
                                <label for="firstName">Description</label>
                                <input required  type="text" placeholder="description" name="description" value="<?php echo $row['description'] ?>"
                                    class="form-control" /></input>
                            </div>
                        </div>
                    </div>
                    </div>
                        <table class ="seller-setting-table">
                            <tr>
    
                                <div class= "seller-setting-button-container">
                                <td class="seller-edit-setting-button-td">
                                <input type="submit" name="updateLogin" class="seller-setting-button"
                                value="Submit"></input>
                                </td>
                                <td class="seller-edit-setting-button-td">
                                <button type="button" class="seller-setting-button1"
                                onclick="window.location='sellerAccountSetting.php'">
                                    <span>Cancel</span></button>
                                </td>
                                </div>
                            </tr>
                        </table>
                    </form>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                        enctype="multipart/form-data" onsubmit="return confirmAction()">
                        <div class="seller-settings-button-container">
                            <input type="submit" name="requestDeactivation" value="Request Deactivation"  class="seller-setting-button2 button">
                        </div>
                    </form>
                    </div>

</div>
</div>
</div>

</body>

</html>