<?php
include 'config.php';
$username = $_POST['username'];
$password = $_POST['password'];
if($stmt = $connection->prepare('select * from users where employee_code=? and password = PASSWORD(?)')){
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows == 1){
        header("Location: ../database_management/dashboard.php");
        die();
    }else{
        echo "<script>alert('username/password incorrect');header.location.href='index.php'</script>";
    }
}
?>

