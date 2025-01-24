<?php
header('Content-Type: application/json');
require '../master/config.php';

$product_id = $_POST['product_id'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;

try {
    $query = "DELETE FROM invoice_details WHERE product_id = ? AND invoice_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $product_id, $invoice_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
