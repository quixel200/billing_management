<?php
    include '../master/config.php';

    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['name'], $input['quantity'], $input['price'], $input['warehouse_id'], $input['category_id'])) {
        $name = mysqli_real_escape_string($connection, $input['name']);
        $quantity = (int) $input['quantity'];
        $price = (float) $input['price'];
        $warehouse_id = (int) $input['warehouse_id'];
        $category_id = (int) $input['category_id'];

        $query = "INSERT INTO products (name, quantity, price, warehouse_id, category_id) 
                  VALUES ('$name', $quantity, $price, $warehouse_id, $category_id)";

        if (mysqli_query($connection, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'All fields are required']);
    }

    mysqli_close($connection);
?>
