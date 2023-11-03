<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$link = $_SERVER['PHP_SELF'];
if (!strpos($link, 'login.php') && !strpos($link, 'login_verification.php') && !strpos($link, 'registerCustomer.php') 
&& !strpos($link,'register.php') && !strpos($link,'registerSeller.php') && !strpos($link,'registerBizSeller.php') 
&& !strpos($link,'registerIndSeller.php') && !isset($_SESSION['user_login']) && !strpos($link,'emailVerify.php')) {
    echo "<script>location.replace('./login.php');</script>";
}
if ((strpos($link, 'login_verification.php') || strpos($link, 'emailVerify.php')) && !isset($_SESSION['otp_verify_user_id'])) {
    echo "<script>location.replace('./login.php');</script>";
}
if (strpos($link, 'login.php') > -1 && isset($_SESSION['user_login'])) {
    echo "<script>location.replace('./');</script>";
}


?>