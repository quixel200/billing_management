<?php
include '../master/config.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

if (strlen($query) >= 1) {
    $sql = "SELECT product_id, name, price FROM products WHERE name LIKE ? LIMIT 100";
    $stmt = $connection->prepare($sql);
    $likeQuery = "%" . $query . "%"; 
    $stmt->bind_param('s', $likeQuery); 
    $stmt->execute();
    $stmt->bind_result($product_id, $name, $price);
    $products = [];
    while ($stmt->fetch()) {
        $products[] = [
            'product_id' => $product_id,
            'name' => $name,
            'price' => $price
        ];
    }
    echo json_encode($products);
} else {
    echo json_encode([]);
}
?>