<?php
    include '../master/config.php';

    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['product_id'])) {
        $productId = $input['product_id'];

        $query = "DELETE FROM products WHERE product_id = $productId";
        
        if (mysqli_query($connection, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Product ID is required']);
    }

    mysqli_close($connection);
?>
