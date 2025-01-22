<?php include '../master/menu.php'?>
<html lang="en">
<head>
    <title>Product</title>
</head>
<body class="container">
    <div class="">
        <div class="container">
            <div class="text-center mt-3">
                <h3>Product Category</h3>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Category Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_category">
                    Add Category
                </button>
                <div class="modal fade" id="add_category" tabindex="-1" aria-labelledby="add_categoryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_categoryLabel">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Category Name:</label></b>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Category Name" required>
                                </div>
                                <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <div>
            <div class="text-center mt-3">
                <h3>Product</h3>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border" >
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Color</th>
                            <th scope="col">Size</th>
                            <th scope="col">Product Category</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_product">
                    Add Product
                </button>
                <div class="modal fade" id="add_product" tabindex="-1" aria-labelledby="add_productLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_productLabel">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Product Name:</label></b>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Product Name" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Color:</label></b>
                                    <input type="text" class="form-control" name="color" placeholder="Enter Color" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Size:</label></b>
                                    <input type="text" class="form-control" name="size" placeholder="Enter Size" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Category:</label></b>
                                    <select class="form-select" name="category">
                                        <option selected value="">Select Category</option>
                                    </select>
                                </div>
                                <div class="d-grid mt-3">
                                <button type="button" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
    </div>
    
</body>
</html>
