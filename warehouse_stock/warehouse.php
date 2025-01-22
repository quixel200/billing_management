<?php
include 'warehouse_backend.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Stock Management - Tile Company</title>
    <!-- Include Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <header>
            <h1 class="text-center">Tile Company - Warehouse Stock Management</h1>
        </header>

        <!-- Product List -->
        <section class="product-list">
            <button class="btn btn-success mb-3 float-end" onclick="showAddForm()">Add New Product</button>



            <!-- Modal: Add New Product -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addProductForm">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" id="productName" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="productQuantity" class="form-label">Stock Quantity</label>
                                    <input type="number" id="productQuantity" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Price per unit</label>
                                    <input type="number" id="productPrice" class="form-control" step="0.1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="warehouseId" class="form-label">Warehouse</label>
                                    <select id="warehouseId" class="form-control" required>
                                        <option value="">Select Warehouse</option>
                                        <?php
                                        foreach ($categories as $category) {
                                            $id = htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8');
                                            $name = htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8');
                                            echo "<option value='{$id}'>{$id} - {$name}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="categoryId" class="form-label">Category</label>
                                    <select id="categoryId" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        foreach ($warehouses as $warehouse) {
                                            $id = htmlspecialchars($warehouse['id'], ENT_QUOTES, 'UTF-8');
                                            $name = htmlspecialchars($warehouse['warehouse_name'], ENT_QUOTES, 'UTF-8');
                                            echo "<option value='{$id}'>{$id} - {$name}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>



            <table class="table table-bordered table-striped" id="productTable">
                <thead>
                    <tr>
                        <th>Category ID - Name</th>
                        <th>Name</th>
                        <th>Product ID</th>
                        <th>Stock Quantity</th>
                        <th>Price per sq.ft</th>
                        <th>Warehouse ID - Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($product = mysqli_fetch_assoc($result)) {
                        echo "<tr data-id='" . $product['product_id'] . "'>";
                        echo "<td>" . $product['warehouse_id'] . " - " . $product['category_name'] . "</td>";
                        echo "<td>" . $product['product_name'] . "</td>";
                        echo "<td>" . $product['product_id'] . "</td>";
                        echo "<td>" . $product['quantity'] . "</td>";
                        echo "<td>" . $product['price'] . "</td>";
                        echo "<td>" . $product['warehouse_id'] . " - " . $product['warehouse_name'] . "</td>";
                        echo "<td><button class='btn btn-warning' onclick='openEditModal(" . $product['product_id'] . ")'>Update</button>
                              <button class='btn btn-danger' onclick='deleteProduct(" . $product['product_id'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Edit Product Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            <input type="hidden" id="editProductId">
                            <div class="mb-3">
                                <label for="editProductName" class="form-label">Product Name:</label>
                                <input type="text" class="form-control" id="editProductName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductQuantity" class="form-label">Stock Quantity:</label>
                                <input type="number" class="form-control" id="editProductQuantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductPrice" class="form-label">Price per unit:</label>
                                <input type="number" class="form-control" id="editProductPrice" step="0.1" required>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="updateProduct()">Save
                                Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        $(document).ready(function () {
            $('#productTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10
            });
        });

        // Open edit modal and populate fields
        function openEditModal(productId) {
            var modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();

            fetch('get_product.php?id=' + productId)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('editProductId').value = data.product_id;
                        document.getElementById('editProductName').value = data.name;
                        document.getElementById('editProductQuantity').value = data.quantity;
                        document.getElementById('editProductPrice').value = data.price;
                    }
                })
                .catch(error => console.error('Error fetching product data:', error));
        }

        function updateProduct() {
            const productId = document.getElementById('editProductId').value;
            const productName = document.getElementById('editProductName').value;
            const productQuantity = document.getElementById('editProductQuantity').value;
            const productPrice = document.getElementById('editProductPrice').value;

            fetch('warehouse_update.php', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: productId,
                    name: productName,
                    quantity: productQuantity,
                    price: productPrice
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update product');
                    }
                })
                .catch(error => console.error('Error updating product:', error));
        }

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch('delete_product.php', {
                    method: 'POST',
                    body: JSON.stringify({ product_id: productId }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product deleted successfully');
                            location.reload();
                        } else {
                            alert('Failed to delete product');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting product:', error);
                        alert('An error occurred while deleting the product');
                    });
            }
        }

        // Show the Add Product Modal
        function showAddForm() {
            const addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));
            addProductModal.show();
        }

        function addProduct() {
            const productName = document.getElementById('productName').value;
            const productQuantity = document.getElementById('productQuantity').value;
            const productPrice = document.getElementById('productPrice').value;
            const warehouseId = document.getElementById('warehouseId').value;
            const categoryId = document.getElementById('categoryId').value;

            if (productName && productQuantity && productPrice && warehouseId && categoryId) {
                const productData = {
                    name: productName,
                    quantity: productQuantity,
                    price: productPrice,
                    warehouse_id: warehouseId,
                    category_id: categoryId
                };

                fetch('add_product.php', {
                    method: 'POST',
                    body: JSON.stringify(productData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product added successfully!');
                            location.reload(); // Reload the page to show the new product
                        } else {
                            alert('Failed to add product');
                        }
                    })
                    .catch(error => {
                        console.error('Error adding product:', error);
                        alert('An error occurred while adding the product');
                    });
            } else {
                alert('All fields are required');
            }
        }
        // Show the Add Product Modal
        function showAddForm() {
            const addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));
            addProductModal.show();
        }

        // Function to add a product to the database
        function addProduct() {
            const productName = document.getElementById('productName').value;
            const productQuantity = document.getElementById('productQuantity').value;
            const productPrice = document.getElementById('productPrice').value;
            const warehouseId = document.getElementById('warehouseId').value;
            const categoryId = document.getElementById('categoryId').value;

            // Validate the input fields
            if (productName && productQuantity && productPrice && warehouseId && categoryId) {
                const productData = {
                    name: productName,
                    quantity: productQuantity,
                    price: productPrice,
                    warehouse_id: warehouseId,
                    category_id: categoryId
                };

                // Send the product data to the backend using fetch
                fetch('add_product.php', {
                    method: 'POST',
                    body: JSON.stringify(productData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product added successfully!');
                            location.reload(); // Reload the page to show the new product
                        } else {
                            alert('Failed to add product');
                        }
                    })
                    .catch(error => {
                        console.error('Error adding product:', error);
                        alert('An error occurred while adding the product');
                    });
            } else {
                alert('All fields are required');
            }
        }


    </script>
</body>

</html>