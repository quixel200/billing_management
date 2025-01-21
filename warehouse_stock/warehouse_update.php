<?php
    include '../master/config.php';

    // Read the input data from the request
    $input = json_decode(file_get_contents('php://input'), true);

    $productId = $input['product_id'];
    $productName = $input['name'];
    $productQuantity = $input['quantity'];
    $productPrice = $input['price'];

    $query = "UPDATE products SET 
                name = '$productName', 
                quantity = $productQuantity, 
                price = $productPrice 
              WHERE product_id = $productId";

    $result = mysqli_query($connection, $query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
    }

    mysqli_close($connection);
?>
