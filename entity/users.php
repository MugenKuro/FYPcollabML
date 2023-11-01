<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__FILE__) . '\..\vendor\autoload.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class Users
{
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $account_type;
    private $status;
    private $registered_date;

    // Constants representing account types
    const ACCOUNT_TYPE_SELLER = 'Seller';
    const ACCOUNT_TYPE_CUSTOMER = 'Customer';
    const ACCOUNT_TYPE_SYSTEM_ADMIN = 'System Admin';

    //Constructor
    public function __construct($user_id = NULL, $username = NULL, $password = NULL, $account_type = NULL, $email = NULL, $status = NULL, $registered_date = NULL)
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password = $password;
        $this->account_type = $account_type;
        $this->email = $email;
        $this->status = $status;
        $this->registered_date = $registered_date;
    }

    // Getters
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getRegisteredDate()
    {
        return $this->registered_date;
    }



    //used for login
    public function getLoginDetails($username, $password)
    {
        $db = new Db();
        $username = $db->escape($username);

        $sql = "SELECT username, password, user_profile_id FROM user
        WHERE username = '$username'";

        if ($result = $db->query($sql)) {
            while ($row = $result->fetch_row()) {
                $this->username = $row[0];
                $this->password = $row[1];
                $this->user_profile_id = $row[2];
            }
            $result->free_result();
        }
        if ($this->getUsername() == null) {
            $login_err = "User is not registered.";
        } else {
            if (password_verify($password, $this->getPassword())) {
                session_start();

                $login_err = "";
            } else {
                $login_err = "Invalid username or password.";
            }

        }

        return $login_err;
    }

    public function login()
    {
        extract($_POST);
        $sql = "SELECT * FROM `users` where `username` = ? ";
        $db = new Db();
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_array();
            $pass_is_right = password_verify($password, $data['password']);
            $has_code = false;
            if ($pass_is_right && (is_null($data['otp']) || (!is_null($data['otp']) && !is_null($data['otp_expiration']) && strtotime($data['otp_expiration']) < time()))) {
                $otp = sprintf("%'.06d", mt_rand(0, 999999));
                $expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
                $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where user_id='{$data['user_id']}' ";
                $update_otp = $db->query($update_sql);
                if ($update_otp) {
                    $has_code = true;
                    $resp['status'] = 'success';
                    $_SESSION['otp_verify_user_id'] = $data['user_id'];
                    $this->send_mail($data['email'], $otp);
                } else {
                    $resp['status'] = 'failed';
                    $_SESSION['flashdata']['type'] = 'danger';
                    $_SESSION['flashdata']['msg'] = ' An error occurred while loggin in. Please try again later.';
                }

            } else if (!$pass_is_right) {
                $resp['status'] = 'failed';
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = ' Incorrect Password';
            }
        } else {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = ' Username is not registered.';
        }
        return json_encode($resp);
    }

    function send_mail($to = "", $pin = "")
    {
        $mail = new PHPMailer(true);
        if (!empty($to)) {
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com;';
                $mail->SMTPAuth = true;
                $mail->Username = 'iclothfyp@gmail.com';
                $mail->Password = 'iiprgvqfjvhegsle';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('asd@gmail.com', 'iCloth');
                $mail->addAddress($to);

                $mail->isHTML(true);
                $mail->Subject = 'OTP';
                $mail->Body = '<h2>You are Attempting to Login in iCloth PHP Web Application</h2>
                <p>Here is your OTP (One-Time PIN) to verify your Identity.</p>
                <h3><b>' . $pin . '</b></h3>';
                $mail->AltBody = 'You are Attempting to Login in iCloth PHP Web Application. Here is your OTP (One-Time PIN) to verify your Identity.' . $pin;
                $mail->send();

                // send email
                // mail($to, "OTP", $msg, $headers);
                // die("ERROR<br>".$headers."<br>".$msg);

            } catch (Exception $e) {
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = ' An error occurred while sending the OTP. Error: ' . $e->getMessage();
            }
        }
    }
    public function get_user_data($id)
    {
        $db = new Db();
        extract($_POST);
        $sql = "SELECT * FROM `users` where `user_id` = ? ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dat = [];
        if ($result->num_rows > 0) {
            $resp['status'] = 'success';
            foreach ($result->fetch_array() as $k => $v) {
                if (!is_numeric($k)) {
                    $data[$k] = $v;
                }
            }
            $resp['data'] = $data;
        } else {
            $resp['status'] = 'false';
        }
        return json_encode($resp);
    }
    public function resend_otp($id)
    {
        $db = new Db();
        $otp = sprintf("%'.06d", mt_rand(0, 999999));
        $expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
        $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where user_id = '{$id}' ";
        $update_otp = $db->query($update_sql);
        if ($update_otp) {
            $resp['status'] = 'success';
            $email = $db->query("SELECT email FROM `users` where user_id = '{$id}'")->fetch_array()[0];
            $this->send_mail($email, $otp);
        } else {
            $resp['status'] = 'failed';
            $resp['error'] = $db->getConnectError();
        }
        return json_encode($resp);
    }
    public function otp_verify()
    {
        $db = new Db();
        extract($_POST);
        $sql = "SELECT * FROM `users` where user_id = ? and otp = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('is', $user_id, $otp);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp['status'] = 'success';
            $db->query("UPDATE `users` set otp = NULL, otp_expiration = NULL where user_id = '{$id}'");
            $_SESSION['user_login'] = 1;
            foreach ($result->fetch_array() as $k => $v) {
                if (!is_numeric($k))
                    $_SESSION[$k] = $v;
            }
        } else {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = ' Incorrect OTP.';
        }
        return json_encode($resp);
    }



}



?>