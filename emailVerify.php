<?php
require_once('auth.php');
require_once dirname(__FILE__) . '\entity\users.php';

$user = new users();
$user_data = json_decode($user->get_user_data($_SESSION['otp_verify_user_id']));
if ($user_data->status) {
    foreach ($user_data->data as $k => $v) {
        $$k = $v;
    }
}
if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
    $resend = json_decode($user->resend_otp($_SESSION['otp_verify_user_id']));
    if ($resend->status == 'success') {
        echo "<script>location.replace('./emailVerify.php')</script>";
    } else {
        $_SESSION['flashdata']['type'] = 'danger';
        $_SESSION['flashdata']['msg'] = ' Resending OTP has failed.';
        echo "<script>console.error(" . $resend . ")</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verify = json_decode($user->email_verify());
    if ($verify->status == 'success') {
        $_SESSION['flashdata']['type'] = 'success';
        $_SESSION['flashdata']['msg'] = 'Email successfully verified.';
        echo "<script>location.replace('./login.php');</script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
</head>

<body>
    <div>
        <link href="css/style.css" rel="stylesheet">
        <div class="fa-container">
            <div class="fa-container1">
                <div class="fa-container2">
                    <span class="fa-text">
                        <span>Email Verification</span>
                        <br />
                    </span>
                </div>
                <div class="fa-container3"></div>
                <div class="fa-container4">
                    <form class="fa-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="user_id" value="<?= isset($user_id) ? $user_id : '' ?>">
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
                        <div class="fa-container5">
                            <span class="fa-text03">
                                <p class="">We have sent an OPT in your Email [<?= isset($email) ? $email : '' ?>].
                                </p>
                            </span>
                            <div class="form-group">
                                <label for="otp" class="label-control">Please Enter the OTP</label>
                                <input type="otp" name="otp" id="otp" class="form-control rounded-0" value=""
                                    maxlength="6" pattern="{0-9}+" autofocus required>
                            </div>
                            <div class="clear-fix mb-4"></div>
                            <div class="form-group text-end">
                                <a class="btn btn-secondary bg-gradient rounded-0  <?= time() < strtotime($otp_expiration) ? 'disabled' : '' ?>"
                                    data-stat="<?= time() < strtotime($otp_expiration) ? 'countdown' : '' ?>"
                                    href="./emailVerify.php?resend=true" id="resend">
                                    <?= time() < strtotime($otp_expiration) ? 'Resend in ' . (strtotime($otp_expiration) - time()) . 's' : 'Resend OTP' ?>
                                </a>
                                <button class="btn btn-primary bg-gradient rounded-0">Confirm</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</body>
<script>
    $(function () {
        var is_countdown_resend = $('#resend').attr('data-stat') == 'countdown';
        if (is_countdown_resend) {
            var sec = '<?= time() < strtotime($otp_expiration) ? (strtotime($otp_expiration) - time()) : 0 ?>';
            var countdown = setInterval(() => {
                if (sec > 0) {
                    sec--;
                    $('#resend').text("Resend in " + (sec) + 's')
                } else {
                    $('#resend').attr('data-stat', '')
                        .removeClass('disabled').text('Resend OTP')
                    clearInterval(countdown)
                }
            }, 1000);
        }
    })
</script>

</html>