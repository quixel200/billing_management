<?php
// fetch_bill_details.php
header('Content-Type: application/json');
require '../master/config.php'; // Include database connection

if (isset($_GET['invoice_id'])) {
    $invoiceId = $_GET['invoice_id'];

    $query = "SELECT id.product_id, id.quantity, id.unit_price, id.total_price, p.name AS product_name 
              FROM invoice_details id 
              JOIN products p ON id.product_id = p.product_id
              WHERE id.invoice_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $invoiceId);
    $stmt->execute();
    $result = $stmt->get_result();

    $details = [];
    while ($row = $result->fetch_assoc()) {
        $details[] = $row;
    }
    echo json_encode($details);
} else {
    echo json_encode([]);
}
?>