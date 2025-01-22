<?php include '../master/menu.php';
?>

<html lang="en">
<head>
    <title>Shop</title>
</head>
<body class="container">
    <div class="">
        <div class="container">
            <div class="text-center mt-3">
                <h3>Shop</h3>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border" >
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Manager</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_shop">
                    Add Shop
                </button>
                <div class="modal fade" id="add_shop" tabindex="-1" aria-labelledby="add_shopLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_shopLabel">Add Shop</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="shop.php">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Manager Name:</label></b>
                                    <select class="form-select" name="">
                                        <option selected value="">Select Manager</option>
                                    </select>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Address:</label></b>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Contact:</label></b>
                                    <input type="text" class="form-control" name="contact" placeholder="Enter Contact" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Email:</label></b>
                                    <input type="text" class="form-control" name="email" placeholder="Enter Contact" required>
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
