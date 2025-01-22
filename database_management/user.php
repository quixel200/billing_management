<?php include '../master/menu.php';
?>

<html lang="en">
<head>
    <title>Users</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
</head>
<body class="container">
    <div class="">
        <div class="container">
            <div class="text-center mt-3">
                <h3>User</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    Info
                </div>
                <div class="card-body">
                    <p>Information for bulk upload</p>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border" id="myTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Employee Code</th>
                            <th scope="col">Shop</th>
                            <th scope="col">Role</th>
                            <th scope="col">Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_user">
                    Add User
                </button>
                <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="add_userLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_userLabel">Add Shop</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Employee Name:</label></b>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Employee Name" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Employee Code:</label></b>
                                    <input type="text" class="form-control" name="emp_code" placeholder="Enter Employee Code" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Shop:</label></b>
                                    <select class="form-select">
                                        <option selected value="">Select Shop</option>
                                    </select>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Role:</label></b>
                                    <input type="text" class="form-control" name="role" placeholder="Enter Role" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Phone Number:</label></b>
                                    <input type="text" class="form-control" name="mob_no" placeholder="Enter Phone Number" required>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script>
    let table = new DataTable('#myTable');
    </script>
    
</body>
