<?php
header('Content-Type: application/json');
require '../master/config.php';

$item_id = $_POST['item_id'] ?? null;
$quantity = $_POST['quantity'] ?? 0;
$unit_price = $_POST['unit_price'] ?? 0;
$total_price = $_POST['total_price'] ?? 0;

if (!$item_id) {
    echo json_encode(['success' => false, 'error' => 'Missing item ID.']);
    exit;
}

try {
    $query = "UPDATE invoice_details 
              SET quantity = ?, unit_price = ?, total_price = ?
              WHERE item_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("dddi", $quantity, $unit_price, $total_price, $item_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
