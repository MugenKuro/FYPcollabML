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

    $user = new deactivateCustomerAccount();
    $deactivateUser = json_decode($user->deactivateCustAcc($_SESSION['user_id']));
    if (isset($deactivateUser->status)) {
        if ($deactivateUser->status == 'success') {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'account deactivated successfully.';

            // Perform the redirect
            header('Location: logout.php');
        } elseif ($deactivateUser->status == 'nothing') {
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Something went wrong.';
        } else {
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Something went wrong.';
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


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    include dirname(__FILE__) . ('/custNavBar.php');
    ?>


    <div>
        <?php
        $userSettings = new viewAccountSettings();
        $userData = json_decode($userSettings->getUserDetails($_SESSION['user_id']));

        if (!empty($userData)) {
            $username = $userData[0]->username;
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

        $current_folder = basename(__DIR__);
        $dir = "/" . $current_folder;
        ?>
        <div class="user-account-setting-container">
            <div class="user-account-setting-container01">
                <div class="user-account-setting-container02">
                    <span class="user-account-setting-text">
                        <span>Account Setting</span>
                        <br />
                    </span>
                </div>
                <div class="user-account-setting-container03"></div>
                <div class="user-account-setting-container04">
                    <div class="user-account-setting-form">
                        <div class="user-account-setting-container05">
                            <span class="user-account-setting-text06">
                                <span>Profile Image</span>
                                <br />
                            </span>
                            <div class="user-account-setting-container06">
                                <img src="<?php echo $dir . $imagePath; ?>" alt="image"
                                    class="user-account-setting-image" />
                            </div>
                        </div>
                        <div class="user-account-setting-container07">
                            <span class="user-account-setting-text06">
                                <span>Nickname</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text09">
                                <span>
                                    <?php echo $nickname; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container08">
                            <span class="user-account-setting-text12">
                                <span>First Name</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text15">
                                <span>
                                    <?php echo $firstName; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container09">
                            <span class="user-account-setting-text18">
                                <span>Last Name</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text21">
                                <span>
                                    <?php echo $lastName; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container10">
                            <span class="user-account-setting-text24">
                                <span>Gender</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text27">
                                <span>
                                    <?php echo $gender; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container11">
                            <span class="user-account-setting-text30">
                                <span>Date of Birth</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text33">
                                <span>
                                    <?php echo $dateOfBirth; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container12">
                            <span class="user-account-setting-text36">
                                <span>Mobile</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text39">
                                <span>
                                    <?php echo $mobile; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container14">
                            <span class="user-account-setting-text42">
                                <span>Address</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text55">
                                <span>
                                    <?php echo $address; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container14">
                            <span class="user-account-setting-text52">
                                <span>Username</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text55">
                                <span>
                                    <?php echo $username; ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container15">
                            <span class="user-account-setting-text58">
                                <span>Email</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text61">
                                <span>
                                    <?php echo $email; ?>
                                </span>
                                <br />
                            </span>
                        </div>
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
                        <div class="user-account-setting-container16">
                            <button type="button" class="user-account-setting-button button"
                                onclick="window.location='settings.php'">
                                <span class="user-account-setting-text64">
                                    <span>Edit login Details</span>
                                    <br />
                                </span>
                            </button>
                            <button type="button" class="user-account-setting-button1 button"
                                onclick="window.location='index.php'">
                                <span class="user-account-setting-text67">
                                    <span class="user-account-setting-text68">Cancel</span>
                                    <br />
                                </span>
                            </button>
                            <form class="deactivate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="post" enctype="multipart/form-data" onsubmit="return confirmAction()">
                                <button type="submit" class="user-account-setting-button2 button">
                                    <span class="settings-text18">
                                        <span>Deactivate account</span>
                                    </span>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>