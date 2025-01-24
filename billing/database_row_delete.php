<?php
header('Content-Type: application/json');
require '../master/config.php';

$item_id = $_POST['item_id'] ?? null;

if (!$item_id) {
    echo json_encode(['success' => false, 'error' => 'Missing item ID.']);
    exit;
}

try {
    $query = "DELETE FROM invoice_details WHERE item_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
