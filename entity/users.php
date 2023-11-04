<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__FILE__) . '\..\vendor\autoload.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");
require_once dirname(__FILE__) . '\..\controller\userController.php';

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

    public function customerRegister($email, $username, $password, $nickname, $gender, $dob, $firstname, $lastname, $image, $mobile, $address)
    {
        $db = new Db();

        $email = $db->escape($email);
        $username = $db->escape($username);
        $password = $db->escape($password);
        $nickname = $db->escape($nickname);
        $gender = $db->escape($gender);
        $dob = $db->escape($dob);
        $firstname = $db->escape($firstname);
        $lastname = $db->escape($lastname);
        $image = $db->escape($image);
        $mobile = $db->escape($mobile);
        $address = $db->escape($address);
        $accountType = self::ACCOUNT_TYPE_CUSTOMER;

        // Start a transaction
        $db->begin_transaction();

        $check = $db->query("SELECT * FROM `users` WHERE `username` = '$username'")->num_rows;

        if ($check > 0) {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'username already exists.';
        } else {
            // Insert into 'users' table
            $sql = "INSERT INTO `users` (`username`, `password`, `account_type`, `email`, `status`) 
                    VALUES ('$username', '$password', '$accountType', '$email', 'emailverify')";
            $save = $db->query($sql);

            if ($save) {
                // Get the user_id of the inserted user
                $user_id = $db->getLastInsertedId();
                $_SESSION['otp_verify_user_id'] = $user_id;

                // Insert into 'customers' table
                $customerSql = "INSERT INTO `customers` (`user_id`, `nickname`, `gender`, `date_of_birth`, `first_name`, `last_name`, `image_path`, `mobile`, `address`) 
                               VALUES ('$user_id', '$nickname', '$gender', '$dob', '$firstname', '$lastname', '$image', '$mobile', '$address')";
                $saveCustomer = $db->query($customerSql);

                if ($saveCustomer) {
                    // Both inserts were successful, commit the transaction
                    $db->commit();
                    $resp['status'] = 'success';
                    $otp = sprintf("%'.06d", mt_rand(0, 999999));
                    $expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
                    $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where user_id='$user_id' ";
                    $update_otp = $db->query($update_sql);
                    if ($update_otp) {
                        $_SESSION['otp_verify_user_id'] = $user_id;
                        $this->send_mail_confirm($email, $otp);
                    } else {
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' An error occurred while logging in. Please try again later.';
                    }
                } else {
                    // There was an error inserting into the 'customers' table, roll back the transaction
                    $db->rollback();
                    $resp['status'] = 'failed';
                    $resp['err'] = $db->getConnectError();
                    $_SESSION['flashdata']['type'] = 'danger';
                    $_SESSION['flashdata']['msg'] = 'An error occurred.';
                }
            } else {
                // There was an error inserting into the 'users' table, roll back the transaction
                $db->rollback();
                $resp['status'] = 'failed';
                $resp['err'] = $db->getConnectError();
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = 'An error occurred.';
            }
        }

        // End the transaction
        $db->end_transaction();

        return json_encode($resp);

    }

    public function indSellerRegister($email, $username, $password, $sellername, $image_path_profimage, $prefCategory, $bankname, $bankno, $description, 
    $fullname, $dob, $mobile, $passport, $combinedAddress, $combinedPAddress) {
        $db = new Db();

        $email = $db->escape($email);
        $username = $db->escape($username);
        $password = $db->escape($password);
        $sellername = $db->escape($sellername);
        $image_path_profimage = $db->escape($image_path_profimage);
        $prefCategory = $db->escape($prefCategory);
        $bankname = $db->escape($bankname);
        $bankno = $db->escape($bankno);
        $description = $db->escape($description);
        $fullname = $db->escape($fullname);
        $dob = $db->escape($dob);
        $mobile = $db->escape($mobile);
        $passport = $db->escape($passport);
        $combinedAddress = $db->escape($combinedAddress);
        $combinedPAddress = $db->escape($combinedPAddress);
        $accountType = self::ACCOUNT_TYPE_SELLER;
        $sellerType = "Individual Seller";

        // Start a transaction
        $db->begin_transaction();

        $check = $db->query("SELECT * FROM `users` WHERE `username` = '$username'")->num_rows;

        if ($check > 0) {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Username already exists.';
        } else {
            // Insert into 'users' table
            $sql = "INSERT INTO `users` (`username`, `password`, `account_type`, `email`, `status`) 
                    VALUES ('$username', '$password', '$accountType', '$email', 'emailverify')";
            $save = $db->query($sql);

            if ($save) {
                // Get the user_id of the inserted user
                $user_id = $db->getLastInsertedId();
                $_SESSION['otp_verify_user_id'] = $user_id;

                $sellerSql = "INSERT INTO `sellers` (`user_id`, `seller_type`, `seller_name`, `description`, `profile_image`, `bank_name`, `bank_account_no`,
                 `pick_up_address`, `preferred_category`) 
                VALUES ('$user_id', '$sellerType', '$sellername', '$description', '$image_path_profimage', '$bankname', '$bankno', '$combinedPAddress', 
                '$prefCategory')";
                $saveSeller = $db->query($sellerSql);

                $sellerId = $db->getLastInsertedId();
                $indSellerSql = "INSERT INTO `individualsellers` (`seller_id`, `full_name`, `date_of_birth`, `phone`, `address`, `passport`) 
                            VALUES ('$sellerId', '$fullname', '$dob', '$mobile', '$combinedAddress', '$passport')";
                $saveIndSeller = $db->query($indSellerSql);

                if ($saveSeller && $saveIndSeller) {
                    // Both inserts were successful, commit the transaction
                    $db->commit();
                    $resp['status'] = 'success';
                    $otp = sprintf("%'.06d", mt_rand(0, 999999));
                    $expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
                    $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where user_id='$user_id' ";
                    $update_otp = $db->query($update_sql);
                    if ($update_otp) {
                        $_SESSION['otp_verify_user_id'] = $user_id;
                        $this->send_mail_confirm($email, $otp);
                    } else {
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' An error occurred while logging in. Please try again later.';
                    }
                } else {
                    // There was an error inserting into the 'customers' table, roll back the transaction
                    $db->rollback();
                    $resp['status'] = 'failed';
                    $resp['err'] = $db->getConnectError();
                    $_SESSION['flashdata']['type'] = 'danger';
                    $_SESSION['flashdata']['msg'] = 'An error occurred.';
                }
            } else {
                // There was an error inserting into the 'users' table, roll back the transaction
                $db->rollback();
                $resp['status'] = 'failed';
                $resp['err'] = $db->getConnectError();
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = 'An error occurred.';
            }
        }

        // End the transaction
        $db->end_transaction();

        return json_encode($resp);

    }
    public function bizSellerRegister($email, $username, $password, $sellername, $image_path_profimage, $prefCategory, $bankname, $bankno, $description, 
    $businessname, $uen, $combinedAddress, $combinedPAddress, $image_path_acra) {
        $db = new Db();

        $email = $db->escape($email);
        $username = $db->escape($username);
        $password = $db->escape($password);
        $sellername = $db->escape($sellername);
        $image_path_profimage = $db->escape($image_path_profimage);
        $prefCategory = $db->escape($prefCategory);
        $bankname = $db->escape($bankname);
        $bankno = $db->escape($bankno);
        $description = $db->escape($description);
        $businessname = $db->escape($businessname);
        $uen = $db->escape($uen);
        $combinedAddress = $db->escape($combinedAddress);
        $combinedPAddress = $db->escape($combinedPAddress);
        $image_path_acra = $db->escape($image_path_acra);
        $accountType = self::ACCOUNT_TYPE_SELLER;
        $sellerType = "Business Seller";

        // Start a transaction
        $db->begin_transaction();

        $check = $db->query("SELECT * FROM `users` WHERE `username` = '$username'")->num_rows;

        if ($check > 0) {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Username already exists.';
        } else {
            // Insert into 'users' table
            $sql = "INSERT INTO `users` (`username`, `password`, `account_type`, `email`, `status`) 
                    VALUES ('$username', '$password', '$accountType', '$email', 'emailverify')";
            $save = $db->query($sql);

            if ($save) {
                // Get the user_id of the inserted user
                $user_id = $db->getLastInsertedId();
                $_SESSION['otp_verify_user_id'] = $user_id;

                $sellerSql = "INSERT INTO `sellers` (`user_id`, `seller_type`, `seller_name`, `description`, `profile_image`, `bank_name`, `bank_account_no`,
                 `pick_up_address`, `preferred_category`) 
                               VALUES ('$user_id', '$sellerType', '$sellername', '$description', '$image_path_profimage', '$bankname', '$bankno', 
                               '$combinedPAddress', '$prefCategory')";
                $saveSeller = $db->query($sellerSql);

                $sellerId = $db->getLastInsertedId();
                $bizSellerSql = "INSERT INTO `businesssellers` (`seller_id`, `business_name`, `uen`, `address`, `ACRA_filepath`) 
                                VALUES ('$sellerId', '$businessname', '$uen', '$combinedAddress', '$image_path_acra')";
                $saveBizSeller = $db->query($bizSellerSql);

                if ($saveSeller && $saveBizSeller) {
                    // Both inserts were successful, commit the transaction
                    $db->commit();
                    $resp['status'] = 'success';
                    $otp = sprintf("%'.06d", mt_rand(0, 999999));
                    $expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
                    $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where user_id='$user_id' ";
                    $update_otp = $db->query($update_sql);
                    if ($update_otp) {
                        $_SESSION['otp_verify_user_id'] = $user_id;
                        $this->send_mail_confirm($email, $otp);
                    } else {
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' An error occurred while logging in. Please try again later.';
                    }
                } else {
                    // There was an error inserting into the 'customers' table, roll back the transaction
                    $db->rollback();
                    $resp['status'] = 'failed';
                    $resp['err'] = $db->getConnectError();
                    $_SESSION['flashdata']['type'] = 'danger';
                    $_SESSION['flashdata']['msg'] = 'An error occurred.';
                }
            } else {
                // There was an error inserting into the 'users' table, roll back the transaction
                $db->rollback();
                $resp['status'] = 'failed';
                $resp['err'] = $db->getConnectError();
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = 'An error occurred.';
            }
        }

        // End the transaction
        $db->end_transaction();

        return json_encode($resp);

    }

    public function login()
    {
        extract($_POST);
        $sql = "SELECT * FROM `users` where `username` = ?";
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
                if ($data['status'] == 'emailverify') {
                    $resp['status'] = 'verify';
                    $_SESSION['otp_verify_user_id'] = $data['user_id'];
                    $this->send_mail_confirm($data['email'], $otp);
                } elseif ($data['status'] == 'Pending Approval') {
                    $resp['status'] = 'pending';
                    $_SESSION['flashdata']['type'] = 'danger';
                    $_SESSION['flashdata']['msg'] = 'Your account is currently getting verified. Please try again later.';

                } elseif ($update_otp && $data['status'] == 'Active') {
                    $has_code = true;
                    $resp['status'] = 'success';
                    $_SESSION['otp_verify_user_id'] = $data['user_id'];
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION["username"] = $data["username"];
                    $_SESSION["accountType"] = $data["account_type"];
                    $this->send_mail($data['email'], $otp);
                } else {
                    $resp['status'] = 'failed';
                    $_SESSION['flashdata']['type'] = 'danger';
                    $_SESSION['flashdata']['msg'] = 'An error occurred while logging in. Please try again later.';
                }

            } else if (!$pass_is_right) {
                $resp['status'] = 'failed';
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = 'Incorrect Password';
            } else {
                $resp['status'] = 'failed';
                $_SESSION['flashdata']['type'] = 'danger';
                $_SESSION['flashdata']['msg'] = 'An error occur while trying to login, please try again after one minute.';
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

    function send_mail_confirm($to = "", $pin = "")
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
                $mail->Body = '<h2>You are Attempting to verify your email address.</h2>
                <p>Here is your OTP (One-Time PIN) to verify your Email.</p>
                <h3><b>' . $pin . '</b></h3>';
                $mail->AltBody = 'You are Attempting to verify your email address. Here is your OTP (One-Time PIN) to verify your Email.' . $pin;
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

    public function resend_otp_confirm($id)
    {
        $db = new Db();
        $otp = sprintf("%'.06d", mt_rand(0, 999999));
        $expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
        $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where user_id = '{$id}' ";
        $update_otp = $db->query($update_sql);
        if ($update_otp) {
            $resp['status'] = 'success';
            $email = $db->query("SELECT email FROM `users` where user_id = '{$id}'")->fetch_array()[0];
            $this->send_mail_confirm($email, $otp);
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
            $db->query("UPDATE `users` set otp = NULL, otp_expiration = NULL where user_id = '{$user_id}'");
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

    public function email_verify()
    {
        $db = new Db();
        extract($_POST);
        $sql = "SELECT * FROM `users` where user_id = ? and otp = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('is', $user_id, $otp);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_array();
            if ($data['account_type'] == 'Seller') {
                $db->query("UPDATE `users` set otp = NULL, otp_expiration = NULL, status = 'Pending Approval' where user_id = '{$user_id}'");
            } else {
                $db->query("UPDATE `users` set otp = NULL, otp_expiration = NULL, status = 'Active' where user_id = '{$user_id}'");
            }
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = ' Incorrect OTP.';
        }
        return json_encode($resp);
    }


    //view account settings
    public function getUserDetails($user_id) {
        $sql = "SELECT username, email FROM `users` where user_id = ?";
        $db = new Db();
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        } else {
            $_SESSION['getUserDetails']['error'] = 'Unable to fetch any details.';
        }
    
        return json_encode($data);
    }

    public function updateUser($user_id, $username_change, $username, $password = NULL, $email) {
        $db = new Db();
        if ($username_change) {
            $check = $db->query("SELECT * FROM `users` WHERE `username` = '$username'")->num_rows;
        } else {
            $check = 0;
        }
        

        if ($check > 0) {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Username already exists.';
        } else {
            if (is_null($password)) {
                $sql = "UPDATE `users`
                SET `username` = '$username',
                `email` = '$email'
                WHERE `user_id` = '$user_id'";
            } else {
                $sql = "UPDATE `users`
                SET `username` = '$username',
                `password` = '$password',
                `email` = '$email'
                WHERE `user_id` = '$user_id'";
            }
            $save = $db->query($sql);
    
            if ($save > 0) {
                $resp['status'] = 'success';
            } else if ($save == 0) {
                $resp['status'] = 'nothing';
            } else {
                $resp['status'] = 'error';
            }

        }

        return json_encode($resp);
    }

    public function deactivateUser($user_id) {
        $db = new Db();

        $sql = "UPDATE `users`
        SET `status` = 'Inactive'
        WHERE `user_id` = '$user_id'";

        $save = $db->query($sql);

        if ($save > 0) {
            $resp['status'] = 'success';
        } else if ($save == 0) {
            $resp['status'] = 'nothing';
        } else {
            $resp['status'] = 'error';
        }
        return json_encode($resp);
    }
    
}



?>