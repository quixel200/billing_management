<?php
header('Content-Type: application/json');
require '../master/config.php'; 

$customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
$shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : null;

try {
    $query = "INSERT INTO invoice (customer_id, shop_id, sgst, cgst, grand_total, inv_date) 
              VALUES (?, ?, 0, 0, 0, NOW())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $customer_id, $shop_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $newInvoiceId = $stmt->insert_id;
        echo json_encode(['success' => true, 'invoice_id' => $newInvoiceId]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to create new invoice.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
