<?php
// Include file
require_once dirname(__FILE__) . '/controller/userController.php';
require_once dirname(__FILE__) . '/controller/categoriesController.php';
require_once('auth.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate confirm password whether empty / same as password
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $dob = trim($_POST["dob"]);
    $dob_arr = explode('-', $dob);
    if ((!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', trim($_POST["email"])))) {
        $_SESSION['flashdata']['type'] = 'danger';
        $_SESSION['flashdata']['msg'] = 'Invalid email format.';
    } elseif (($password != $confirm_password)) {
        $_SESSION['flashdata']['type'] = 'danger';
        $_SESSION['flashdata']['msg'] = 'Password did not match.';
    } elseif (count($dob_arr) != 3 || !checkdate($dob_arr[1], $dob_arr[2], $dob_arr[0])) {
        $_SESSION['flashdata']['type'] = 'danger';
        $_SESSION['flashdata']['msg'] = 'Invalid date format. Please use yyyy-mm-dd.';
    } elseif (!preg_match('/^\+?[0-9]+$/', trim($_POST["mobile"]))) {
        $_SESSION['flashdata']['type'] = 'danger';
        $_SESSION['flashdata']['msg'] = 'Mobile can only contain numbers, optionally with a plus sign at the beginning.';
    }

    if (isset($_FILES['image']) && $_FILES["image"]["error"] == 0) {
        // Check if the file is an image
        $file_type = $_FILES['image']['type'];
        if ($file_type != "image/jpeg" && $file_type != "image/png" && $file_type != "image/jpg" && $file_type != "image/gif") {
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Sorry, only JPG, JPEG, PNG, GIF files are allowed.';
        }
        // Check if file size is less than 5MB
        if ($_FILES['image']['size'] > 5000000) {
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Sorry, your file is too large.';
        }

    } else {
        echo $_FILES["image"]["error"];
        $_SESSION['flashdata']['type'] = 'danger';
        $_SESSION['flashdata']['msg'] = 'Please select an image to upload.';
    }


    if (!isset($_SESSION['flashdata']) || ($_SESSION['flashdata']['type'] != 'danger' && empty($_SESSION['flashdata']['msg']))) {
        $indSellerRegister = new registerController();

        $target_dir_profimage = dirname(__FILE__) . '/images/SellerLogo/'; // Set the target directory
        $target_file_profimage = $target_dir_profimage . basename($_FILES["image"]["name"]); // Get the filename of the uploaded file
        $imageFileType_profimage = strtolower(pathinfo($target_file_profimage, PATHINFO_EXTENSION)); // Get the file extension

        // Generate a unique filename to prevent conflicts
        $filename_profimage = uniqid() . "." . $imageFileType_profimage;
        $image_path_profimage = '/images/SellerLogo/' . $filename_profimage;

        extract($_POST);
        $combinedAddress = $address1 . ',' . $address2 . ',' . $address3;
        $combinedPAddress = $paddress1 . ',' . $paddress2 . ',' . $paddress3;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir_profimage . $filename_profimage)) {
            $register = json_decode($indSellerRegister->indSellerRegister(
                $email,
                $username,
                $password,
                $sellername,
                $image_path_profimage,
                $prefcat,
                $bankname,
                $bankno,
                $description,
                $fullname,
                $dob,
                $mobile,
                $passport,
                $combinedAddress,
                $combinedPAddress
            )
            );
            if ($register->status == 'success') {
                $_SESSION['flashdata']['type'] = 'success';
                $_SESSION['flashdata']['msg'] = ' Account has been registered successfully.';
                echo "<script>location.href = './emailVerify.php';</script>";
                exit;
            } else {
                unlink($target_dir_profimage . $filename_profimage);
                echo "<script>console.error(" . json_encode($register) . ");</script>";
            }
        }

    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Register</h1>
                        <form class="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="post" enctype="multipart/form-data">
                            <?php
                            if (isset($_SESSION['flashdata'])):
                                ?>
                                <div
                                    class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?> my-2 rounded-0">
                                    <div class="d-flex align-items-center">
                                        <div class="col-11">
                                            <?php echo $_SESSION['flashdata']['msg'] ?>
                                        </div>
                                        <div class="col-1 text-end">
                                            <div class="float-end"><a href="javascript:void(0)"
                                                    class="text-dark text-decoration-none"
                                                    onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php unset($_SESSION['flashdata']) ?>
                            <?php endif; ?>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" id="email" name="email" class="form-control"
                                        placeholder="example@example.com"
                                        value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" autofocus required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-4 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="your username use to login(jack123)"
                                        value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="password"
                                        value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="retypePassword" class="col-sm-4 col-form-label">Re-type Password</label>
                                <div class="col-sm-8">
                                    <input type="password" id="retypePassword" name="confirm_password"
                                        class="form-control" placeholder="password confirmation"
                                        value="<?= isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sellerName" class="col-sm-4 col-form-label">Seller Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="sellerName" name="sellername" class="form-control"
                                        placeholder="Seller name"
                                        value="<?= isset($_POST['sellername']) ? $_POST['sellername'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label">Profile Pucture</label>
                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input type="file" id="image" name="image" class="form-control-file" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="prefCategory" class="col-sm-4 col-form-label">Preferred Category</label>
                                <div class="col-sm-8">
                                    <select id="prefCategory" name="prefcat" class="form-control">
                                        <?php
                                        $category = new viewAllCategories();
                                        $data = json_decode($category->viewAllCategories());

                                        foreach ($data as $category) {
                                            echo '<option value="' . $category->category_id . '"';
                                            if (isset($_POST['prefcat']) && $_POST['prefcat'] === $category->category_id) {
                                                echo ' selected';
                                            }
                                            echo '>' . $category->category_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bankName" class="col-sm-4 col-form-label">Bank Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="bankName" name="bankname" class="form-control"
                                        placeholder="DBS"
                                        value="<?= isset($_POST['bankname']) ? $_POST['bankname'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bankNo" class="col-sm-4 col-form-label">Bank Account No.</label>
                                <div class="col-sm-8">
                                    <input type="text" id="bankNo" name="bankno" class="form-control"
                                        placeholder="182123994"
                                        value="<?= isset($_POST['bankno']) ? $_POST['bankno'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address1" class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" id="description" name="description" class="form-control"
                                        placeholder="Description of seller"
                                        value="<?= isset($_POST['description']) ? $_POST['description'] : '' ?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fullName" class="col-sm-4 col-form-label">Full Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fullName" name="fullname" class="form-control"
                                        placeholder="Full name"
                                        value="<?= isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dateOfBirth" class="col-sm-4 col-form-label">Date of Birth</label>
                                <div class="col-sm-8">
                                    <input type="text" id="dateOfBirth" name="dob" class="form-control"
                                        placeholder="yyyy-mm-dd"
                                        value="<?= isset($_POST['dob']) ? $_POST['dob'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-4 col-form-label">Mobile</label>
                                <div class="col-sm-8">
                                    <input type="text" id="mobile" name="mobile" class="form-control"
                                        placeholder="98765432"
                                        value="<?= isset($_POST['mobile']) ? $_POST['mobile'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passport" class="col-sm-4 col-form-label">Passport</label>
                                <div class="col-sm-8">
                                    <input type="text" id="passport" name="passport" class="form-control"
                                        placeholder="passport no."
                                        value="<?= isset($_POST['passport']) ? $_POST['passport'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address1" class="col-sm-4 col-form-label">Home Address 1</label>
                                <div class="col-sm-8">
                                    <input type="text" id="address1" name="address1" class="form-control"
                                        placeholder="Street Name"
                                        value="<?= isset($_POST['address1']) ? $_POST['address1'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address2" class="col-sm-4 col-form-label">Home Address 2</label>
                                <div class="col-sm-8">
                                    <input type="text" id="address2" name="address2" class="form-control"
                                        placeholder="BLK 123 #01-99"
                                        value="<?= isset($_POST['address2']) ? $_POST['address2'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address3" class="col-sm-4 col-form-label">Home Address 3</label>
                                <div class="col-sm-8">
                                    <input type="text" id="address3" name="address3" class="form-control"
                                        placeholder="Postal Code"
                                        value="<?= isset($_POST['address3']) ? $_POST['address3'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address1" class="col-sm-4 col-form-label">Item Pick-up Address 1</label>
                                <div class="col-sm-8">
                                    <input type="text" id="paddress1" name="paddress1" class="form-control"
                                        placeholder="Street Name"
                                        value="<?= isset($_POST['paddress1']) ? $_POST['paddress1'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address2" class="col-sm-4 col-form-label">Item Pick-up Address 2</label>
                                <div class="col-sm-8">
                                    <input type="text" id="paddress2" name="paddress2" class="form-control"
                                        placeholder="BLK 123 #01-99"
                                        value="<?= isset($_POST['paddress2']) ? $_POST['paddress2'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address3" class="col-sm-4 col-form-label">Item Pick-up Address 3</label>
                                <div class="col-sm-8">
                                    <input type="text" id="paddress3" name="paddress3" class="form-control"
                                        placeholder="Postal Code"
                                        value="<?= isset($_POST['paddress3']) ? $_POST['paddress3'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary ml-2"
                                        onclick="window.location='registerSeller.php'">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>