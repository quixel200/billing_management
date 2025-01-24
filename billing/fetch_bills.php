<?php
// fetch_bills.php
header('Content-Type: application/json');
require '../master/config.php'; // Include database connection

$customerPhone = $_POST['customer_id'];
$shopId = $_POST['shop_id'];

$query = "SELECT invoice_id, DATE_FORMAT(inv_date, '%Y-%m-%d') as date FROM invoice WHERE customer_id='$customerPhone' AND shop_id='$shopId' ORDER BY date DESC";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    $bills = [];
    while ($row = $result->fetch_assoc()) {
        $bills[] = $row;
    }
    echo json_encode($bills);
} else {
    echo json_encode([]);
}
?>
