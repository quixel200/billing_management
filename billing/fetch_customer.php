<?php
include '../master/config.php';
header('Content-Type: application/json');

if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];

    // Query to fetch customer details
    $stmt = $connection->prepare('SELECT name, address FROM customer WHERE mobile_number = ?');
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        echo json_encode($customer);
    } else {
        echo json_encode(null); 
    }

    $stmt->close();
    $connection->close();
}
?>
