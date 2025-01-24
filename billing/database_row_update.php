<?php
header('Content-Type: application/json');
require '../master/config.php';

$invoice_id = $_POST['invoice_id'] ?? 0;
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 0;
$unit_price = $_POST['unit_price'] ?? 0;

try {
    $query = "UPDATE invoice_details 
              SET quantity = ?, unit_price = ?
              WHERE product_id = ? AND invoice_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ddii", $quantity, $unit_price, $product_id, $invoice_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
