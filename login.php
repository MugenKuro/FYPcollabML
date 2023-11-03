<?php
// Include file
require_once dirname(__FILE__) . '\entity\users.php';
require_once dirname(__FILE__) . '\controller\userController.php';
require_once('auth.php');
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new loginController();
    $login = json_decode($user->login());
    if ($login->status == 'success') {
        echo "<script>location.replace('./login_verification.php');</script>";
    } elseif ($login->status == 'verify') {
        echo "<script>location.replace('./emailVerify.php');</script>";
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <style>
        body {
            font: 20px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
            margin: auto;
        }
    </style>
</head>


<body>
    <div>
        <link href="css/style.css" rel="stylesheet">
        <div class="login-container">
            <div class="login-wireframe1">
                <div class="login-container1">
                    <div class="login-container2">
                        <h1 class="login-text">
                            Login
                        </h1>
                        <p class="login-text3">Please fill in your credentials to login.</p>
                        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="post">
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
                            <div class="form group login-container3">
                                <span class="login-text1">Username:</span>
                                <div class="input-container">
                                    <input type="text" name="username"
                                        class="form-control login-textinput input"
                                        value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" autofocus required>
                                </div>
                            </div>
                            <div class="form group login-container4">
                                <span class="login-text2">Password:</span>
                                <div class="input-container">
                                    <input type="password" name="password" class="form-control login-textinput1 input"
                                        value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>" required>
                                </div>
                            </div>
                            <div class="form-group login-container5">
                                <input type="submit" class="btn btn-primary login-button button" value="Login">
                                <button type="button" class="btn btn-primary login-button1 button"
                                    onclick="window.location='index.php'">
                                    <span class="login-text6">
                                        <span>Back to home</span>
                                    </span>
                                </button>
                            </div>
                            <p class="login-text3">Don't have an account? <a href="register.php">Sign up
                                    now</a>.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>


</html>