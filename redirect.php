<?php
require dirname(__FILE__) . '\entity\users.php';
$database = new Db();
$seller = new Users();
$ID = $seller->getUserId();

if (isset($_POST['requestDeactivation'])){
    $sql = "UPDATE users SET status='pending deactivation' where user_id=$ID ";
    $update = $database->query($sql); 
    echo "request sent successfully";
}

if (isset($_POST['updateLogin'])){
    $username=  $_REQUEST['username'];
    $password = $_REQUEST['password1'];
    $confirmPass = $_REQUEST['password2'];
    if($password == $confirmPass){
    $statement = $database->prepare("UPDATE users SET username = ? , password = ? where user_id = $ID ");
    $statement->bind_param("ss", $username, $password);
    $statement->execute();
    echo "login updated";
    }
    else{
        echo "please input the same password";
    }
}

if (isset($_POST['requestCategory'])){
    $category=  $_REQUEST['category'];
    $statement = $database->prepare("INSERT INTO CategoryRequests (seller_id,category_name,description,status) VALUES($ID, ?, '----' , 'pending' )");
    $statement->bind_param("s", $category);
    $statement->execute();
    echo "request sent successfully";
}

/* $sql = "CREATE TABLE CategoryRequests (
  request_id INT PRIMARY KEY AUTO_INCREMENT,
  seller_id INT,
  category_name VARCHAR(255),
  description VARCHAR(255),
  status VARCHAR(25) DEFAULT 'pending')";
*/

?>
