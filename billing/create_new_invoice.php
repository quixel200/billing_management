<?php
// create_new_invoice.php
header('Content-Type: application/json');
require '../master/config.php'; // Include database connection

// Get customer_id and shop_id from POST data
$customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
$shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : null;

// Validate inputs
if (!$shop_id) {
    echo json_encode(['success' => false, 'error' => 'Shop ID is required.']);
    exit;
}

try {
    // Insert a new invoice
    $query = "INSERT INTO invoice (customer_id, shop_id, sgst, cgst, grand_total, date) 
              VALUES (?, ?, 0, 0, 0, NOW())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $customer_id, $shop_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $newInvoiceId = $stmt->insert_id; // Get the ID of the new invoice
        echo json_encode(['success' => true, 'invoice_id' => $newInvoiceId]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to create new invoice.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
