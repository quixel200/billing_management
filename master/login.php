<?php
include 'config.php';
$username = $_POST['username'];
$password = $_POST['password'];
if($stmt = $connection->prepare('select * from users where employee_code=? and password = PASSWORD(?)')){
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows == 1){
        echo "login successful";
    }else{
        echo "username/password incorrect";
    }
}
?>

