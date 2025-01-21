<?php
    include '../master/config.php';

    // Get the product ID from the GET request
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        
        $query = "SELECT * FROM products WHERE product_id = $productId";
        $result = mysqli_query($connection, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            echo json_encode($product);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }

        mysqli_free_result($result);
        mysqli_close($connection);
    }
?>
