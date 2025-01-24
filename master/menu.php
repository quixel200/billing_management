<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    
</head>
<body class="bg-light">
    <div class="">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="#">
                    Company Name
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-1">
                            <a class="nav-link active rounded px-3" href="../database_management/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link rounded px-3" href="../warehouse_stock/warehouse.php">Stock Management</a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link rounded px-3" href="../billing/billing.php">Sales and Billing</a>
                        </li>
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle rounded px-3" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Add Data
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item py-2 px-3" href="../database_management/product.php">New Product</a></li>
                                <li><a class="dropdown-item py-2 px-3" href="../database_management/supplier.php">Supplier</a></li>
                                <li><a class="dropdown-item py-2 px-3" href="../database_management/shop.php">Shop</a></li>
                                <li><a class="dropdown-item py-2 px-3" href="../database_management/warehouse.php">Warehouse</a></li>
                                <li><a class="dropdown-item py-2 px-3" href="../database_management/user.php">Users</a></li>
                                <li><a class="dropdown-item py-2 px-3" href="../database_management/customer.php">Customer</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
