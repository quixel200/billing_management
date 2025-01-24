<?php
header('Content-Type: application/json');
require '../master/config.php';

$invoice_id = (int)($_POST['invoice_id'] ?? null);
$product_id = (int)($_POST['product_id'] ?? null); 
$quantity = (int)($_POST['quantity'] ?? 0);
$unit_price = (float)($_POST['unit_price'] ?? 0);

if (!$invoice_id || (!$product_id && empty($product_name))) {
    echo json_encode(['success' => false, 'error' => 'Missing required data.']);
    exit;
}

try {
    $query = "INSERT INTO invoice_details (invoice_id, product_id, quantity, unit_price) 
              VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iiid", $invoice_id, $product_id, $quantity, $unit_price);
    $stmt->execute();

    $item_id = $stmt->insert_id; 

    echo json_encode(['success' => true, 'item_id' => $item_id]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
