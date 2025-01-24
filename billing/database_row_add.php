<?php
header('Content-Type: application/json');
require '../master/config.php';

$invoice_id = $_POST['invoice_id'] ?? null;
$product_id = $_POST['product_id'] ?? null; // Get product_id
$quantity = $_POST['quantity'] ?? 0;
$unit_price = $_POST['unit_price'] ?? 0;
$total_price = $_POST['total_price'] ?? 0;

if (!$invoice_id || (!$product_id && empty($product_name))) {
    echo json_encode(['success' => false, 'error' => 'Missing required data.']);
    exit;
}

try {
    $query = "INSERT INTO invoice_details (invoice_id, product_id, quantity, unit_price, total_price) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iisddd", $invoice_id, $product_id, $product_name, $quantity, $unit_price, $total_price);
    $stmt->execute();

    $item_id = $stmt->insert_id; // Get the newly inserted row ID

    echo json_encode(['success' => true, 'item_id' => $item_id]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
