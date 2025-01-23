<?php include '../master/menu.php';
include '../master/config.php';

$shop_details = '';
$shop_query = 'select shop_id,address from shop';
$queryEXE1 = mysqli_query($connection,$shop_query);
while($row = mysqli_fetch_array($queryEXE1)){
    $shop_details.='<option value="'.$row['shop_id'].'">'.$row['address'].'</option>';
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $employee_code = $_POST['employee_code'];
    $shop_id = $_POST['shop_id'];
    $role = $_POST['role'];
    $phone_number = $_POST['phone_number'];
    $stmt = $connection->prepare('insert into users(name,employee_code,password,shop_id,role,phone_number) values (?,?,PASSWORD("defaultpassword"),?,?,?)');
    $stmt->bind_param("sssss",$name,$employee_code,$shop_id,$role,$phone_number);
    $stmt->execute();
}

$users_table = '';
$user_query = 'select u.name,u.employee_code,s.address,u.role,u.phone_number from users u join shop s on s.shop_id=u.shop_id';
$queryEXE2 = mysqli_query($connection,$user_query);
while($row = mysqli_fetch_array($queryEXE2)){
    $users_table.='<tr><td>'.$row['name'].'</td>';
    $users_table.='<td>'.$row['employee_code'].'</td>';
    $users_table.='<td>'.$row['address'].'</td>';
    $users_table.='<td>'.$row['role'].'</td>';
    $users_table.='<td>'.$row['phone_number'].'</td>';
    $users_table.= "<td>
            <form method='post' action=''>
                <button class='btn btn-outline-primary' name='edit' type='submit'>
                    <i class='bi bi-pencil-square'></i>
                </button>
                <button class='btn btn-outline-danger' name='delete' type='submit'>
                    <i class='bi bi-trash'></i>
                </button>
            </form>
        </td>";
    $users_table.= "</tr>";
}

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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $users_table; ?>
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
                        <form method="post" action="user.php">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Employee Name:</label></b>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Employee Name" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Employee Code:</label></b>
                                    <input type="text" class="form-control" name="employee_code" placeholder="Enter Employee Code" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Shop:</label></b>
                                    <select class="form-select" name="shop_id">
                                        <option selected value="">Select Shop</option>
                                        <?php echo $shop_details; ?>
                                    </select>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Role:</label></b>
                                    <input type="text" class="form-control" name="role" placeholder="Enter Role" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Phone Number:</label></b>
                                    <input type="text" class="form-control" name="phone_number" placeholder="Enter Phone Number" required>
                                </div>
                                <div class="d-grid mt-3">
                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
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
