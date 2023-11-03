<?php
// Include file
require_once('auth.php');
require_once dirname(__FILE__) . '\controller\categoriesController.php';
require_once dirname(__FILE__) . '\controller\userController.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

// Check if the user is logged in and their role matches the allowed roles for this page
if (isset($_SESSION['accountType'])) {
    $userRole = $_SESSION['accountType'];

    // Define the allowed roles for this page
    $allowedRoles = array("Customer");

    // Check if the user's role is allowed
    if (!in_array($userRole, $allowedRoles)) {
        // User has access, continue with the page
        header("location: login.php"); // You can create an "access_denied.php" page
        exit;
    }
} else {
    // User is not logged in, redirect them to the login page
    header("location: login.php");
    exit;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['password_change'] = $_SESSION['image_change'] = $username_change = false;
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

    if ($password != "") {
        $_SESSION['password_change'] = true;
    }

    if (isset($_FILES['image']) && $_FILES["image"]["error"] == 0) {
        $_SESSION["image_change"] = true;
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
        $_SESSION['image_change'] = false;
    }

    if (!isset($_SESSION['flashdata']) || ($_SESSION['flashdata']['type'] != 'danger' && empty($_SESSION['flashdata']['msg']))) {

        if ($_SESSION['image_change']) {
            $target_dir = dirname(__FILE__) . '/images/Prof_pic/'; // Set the target directory
            $target_file = $target_dir . basename($_FILES["image"]["name"]); // Get the filename of the uploaded file
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension

            // Generate a unique filename to prevent conflicts
            $filename = uniqid() . "." . $imageFileType;
            $image_path = '/images/Prof_pic/' . $filename;
        }
        $updateAccountDetails = new updateAccountDetails();

        extract($_POST);
        if ($_SESSION['current_username'] != $username) {
            $username_change = true;
        }

        $combinedAddress = $address1 . ',' . $address2 . ',' . $address3;

        if ($_SESSION['password_change'] && $_SESSION['image_change'] && move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename)) {
            $updateUser = json_decode(
                $updateAccountDetails->updateAccDetails(
                    $_SESSION['user_id'],
                    $username_change,
                    $username,
                    $password,
                    $email,
                    $nickname,
                    $gender,
                    $dob,
                    $firstname,
                    $lastname,
                    $image_path,
                    $combinedAddress,
                    $mobile
                )
            );

        } elseif ($_SESSION['password_change'] && !$_SESSION['image_change']) {
            $image_path = NULL;
            $updateUser = json_decode(
                $updateAccountDetails->updateAccDetails(
                    $_SESSION['user_id'],
                    $username_change,
                    $username,
                    $password,
                    $email,
                    $nickname,
                    $gender,
                    $dob,
                    $firstname,
                    $lastname,
                    $image_path,
                    $combinedAddress,
                    $mobile
                )
            );

        } elseif (!$_SESSION['password_change'] && $_SESSION['image_change'] && move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename)) {
            $password = NULL;
            $updateUser = json_decode(
                $updateAccountDetails->updateAccDetails(
                    $_SESSION['user_id'],
                    $username_change,
                    $username,
                    $password,
                    $email,
                    $nickname,
                    $gender,
                    $dob,
                    $firstname,
                    $lastname,
                    $image_path,
                    $combinedAddress,
                    $mobile
                )
            );
        } elseif (!$_SESSION['password_change'] && !$_SESSION['image_change']) {
            $image_path = NULL;
            $password = NULL;
            $updateUser = json_decode(
                $updateAccountDetails->updateAccDetails(
                    $_SESSION['user_id'],
                    $username_change,
                    $username,
                    $password,
                    $email,
                    $nickname,
                    $gender,
                    $dob,
                    $firstname,
                    $lastname,
                    $image_path,
                    $combinedAddress,
                    $mobile
                )
            );
        }

        if (isset($updateUser->status)) {
            if ($updateUser->status == 'success') {
                $_SESSION['flashdata']['type'] = 'success';
                $_SESSION['flashdata']['msg'] = 'Details updated successfully.';
                if ($username_change) {
                    $_SESSION["username"] = $username;
                }
            } elseif ($updateUser->status == 'nothing') {
                $_SESSION['flashdata']['type'] = 'success';
                $_SESSION['flashdata']['msg'] = 'Nothing was updated.';
            } else {
                if (isset($target_dir) && isset($filename)) {
                    unlink($target_dir . $filename);
                }
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = 'Something went wrong.';
            }
        }
    }

}
?>

<!doctype html>
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
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <title>iCloth</title>
</head>

<body>
    <?php
    include dirname(__FILE__) . ('/custNavBar.php');
    ?>


    <div>
        <?php
        $userSettings = new viewAccountSettings();
        $userData = json_decode($userSettings->getUserDetails($_SESSION['user_id']));
        $_SESSION['current_username'] = '';

        if (!empty($userData)) {
            $username = $userData[0]->username;
            $_SESSION['current_username'] = $userData[0]->username;
            $email = $userData[0]->email;
        } else {
            // Handle the case where user data is empty or an error occurred
            $username = $_SESSION['getUserDetails']['error'];
            $email = $_SESSION['getUserDetails']['error'];
        }
        $customerData = json_decode($userSettings->getCustomerDetails($_SESSION['user_id']));
        if (!empty($customerData)) {
            $nickname = $customerData[0]->nickname;
            $firstName = $customerData[0]->first_name;
            $lastName = $customerData[0]->last_name;
            $gender = $customerData[0]->gender;
            $dateOfBirth = $customerData[0]->date_of_birth;
            $mobile = $customerData[0]->mobile;
            $address = $customerData[0]->address;
            $imagePath = $customerData[0]->image_path;
        } else {
            // Handle the case where customer data is empty or an error occurred
            $nickname = $_SESSION['getCustomerDetails']['error'];
            $firstName = $_SESSION['getCustomerDetails']['error'];
            $lastName = $_SESSION['getCustomerDetails']['error'];
            $gender = $_SESSION['getCustomerDetails']['error'];
            $dateOfBirth = $_SESSION['getCustomerDetails']['error'];
            $mobile = $_SESSION['getCustomerDetails']['error'];
            $address = $_SESSION['getCustomerDetails']['error'];
            $imagePath = "./images/default_user.jpg";
        }

        list($address1, $address2, $address3) = explode(',', $address);

        $current_folder = basename(__DIR__);
        $dir = "/" . $current_folder;
        ?>
        <div class="settings-container">
            <div class="settings-container01">
                <div class="settings-container02">
                    <span class="settings-text">
                        <span>Update Account Details</span>
                        <br />
                    </span>
                </div>
                <div class="settings-container03"></div>
                <div class="settings-container04">
                    <form class="update-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
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
                            <div class="col-sm-6">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    placeholder="example@example.com"
                                    value="<?= isset($_POST['email']) ? $_POST['email'] : $email ?>" autofocus required>
                            </div>
                            <div class="col-sm-6">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstname" class="form-control"
                                    placeholder="first name"
                                    value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : $firstName ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control"
                                    placeholder="your username use to login(jack123)"
                                    value="<?= isset($_POST['username']) ? $_POST['username'] : $username ?>" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastname" class="form-control"
                                    placeholder="last name"
                                    value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : $lastName ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="leave it empty if you not changing password"
                                    value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
                            </div>
                            <div class="col-sm-3">
                                <label for="userImage">User Image</label>
                                <div class="custom-file">
                                    <input type="file" id="userImage" name="image" class="form-control-file">
                                </div>
                            </div>
                            <small class="form-text text-muted col-sm-3">Leave it empty if you're not changing your
                                image.</small>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="retypePassword">Re-type Password</label>
                                <input type="password" id="retypePassword" name="confirm_password" class="form-control"
                                    placeholder="leave it empty if you not changing password"
                                    value="<?= isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="mobile">Mobile</label>
                                <input type="mobile" id="mobile" name="mobile" class="form-control"
                                    placeholder="98765432"
                                    value="<?= isset($_POST['mobile']) ? $_POST['mobile'] : $mobile ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="nickname">Nickname</label>
                                <input type="text" id="nickname" name="nickname" class="form-control"
                                    placeholder="Name others see on the site"
                                    value="<?= isset($_POST['nickname']) ? $_POST['nickname'] : $nickname ?>" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="address1">Address 1</label>
                                <input type="text" id="address1" name="address1" class="form-control"
                                    placeholder="Street Name"
                                    value="<?= isset($_POST['address1']) ? $_POST['address1'] : $address1 ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'male')
                                        echo 'selected'; ?>>Male</option>
                                    <option value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'female')
                                        echo 'selected'; ?>>Female</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="address2">Address 2</label>
                                <input type="text" id="address2" name="address2" class="form-control"
                                    placeholder="BLK 123, #01-99"
                                    value="<?= isset($_POST['address2']) ? $_POST['address2'] : $address2 ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="dob">Date of Birth</label>
                                <input type="text" id="dob" name="dob" class="form-control" placeholder="yyyy-mm-dd"
                                    value="<?= isset($_POST['dob']) ? $_POST['dob'] : $dateOfBirth ?>" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="address3">Address 3</label>
                                <input type="text" id="address3" name="address3" class="form-control"
                                    placeholder="Postal Code"
                                    value="<?= isset($_POST['address3']) ? $_POST['address3'] : $address3 ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mt-4 d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-primary custom-button-submit-settings">Submit</button>
                                <button type="button" class="btn btn-secondary ml-2"
                                    onclick="window.location='userAccountSetting.php'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





</body>

</html>