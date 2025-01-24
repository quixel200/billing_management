<?php
include '../master/config.php';

// Fetch products from the database
$query = "SELECT 
    p.warehouse_id,
    p.category_id,
    c.name AS category_name, 
    w.name AS warehouse_name, 
    p.product_id, 
    p.product_name, 
    p.quantity, 
    p.price 
FROM 
    products p 
JOIN 
    warehouse w ON w.warehouse_id = p.warehouse_id 
JOIN 
    category c ON c.category_id = p.category_id;
";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}


// Fetch warehouses from the database
$warehouse_query = "SELECT warehouse_id AS id, name AS warehouse_name FROM warehouse";
$warehouse_result = mysqli_query($connection, $warehouse_query);

if (!$warehouse_result) {
    die("Database query for warehouses failed: " . mysqli_error($connection));
}

$warehouses = [];
while ($row = mysqli_fetch_assoc($warehouse_result)) {
    $warehouses[] = $row;
}
mysqli_free_result($warehouse_result);

// Fetch categories from the database
$category_query = "SELECT category_id AS id, name AS category_name FROM category";
$category_result = mysqli_query($connection, $category_query);

if (!$category_result) {
    die("Database query for categories failed: " . mysqli_error($connection));
}

$categories = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row;
}
mysqli_free_result($category_result);


