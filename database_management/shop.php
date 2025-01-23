<?php include '../master/menu.php';
include '../master/config.php';

$manager_details = '';

$manager_query = 'select * from users where role!="manager"';
$queryEXE = mysqli_query($connection,$manager_query);
while($row = mysqli_fetch_array($queryEXE)){
    $manager_details.='<option value="'.$row['uid'].'">'.$row['name'].'</option>';
}

if(isset($_POST['submit'])){
    $manager_id = $_POST['manager_id'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $stmt = $connection->prepare('insert into shop(manager_id,address,contact,email) values(?,?,?,?)');
    $stmt->bind_param("ssss",$manager_id,$address,$contact,$email);
    $stmt->execute();
}

$shop_details = '';
$shop_query = 'select u.name,s.address,s.contact,s.email from shop s join users u on u.uid=s.manager_id';
$queryEXE1 = mysqli_query($connection,$shop_query);
while($row = mysqli_fetch_array($queryEXE1)){
    $shop_details.='<tr><td>'.$row['name'].'</td>';
    $shop_details.='<td>'.$row['address'].'</td>';
    $shop_details.='<td>'.$row['contact'].'</td>';
    $shop_details.='<td>'.$row['email'].'</td>';
    $shop_details.= "<td>
            <form method='post' action=''>
                <button class='btn btn-outline-primary' name='edit' type='submit'>
                    <i class='bi bi-pencil-square'></i>
                </button>
                <button class='btn btn-outline-danger' name='delete' type='submit'>
                    <i class='bi bi-trash'></i>
                </button>
            </form>
        </td>";
    $shop_details.= "</tr>";
}

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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $shop_details; ?>
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
                                    <select class="form-select" name="manager_id">
                                        <option selected value="">Select Manager</option>
                                        <?php echo $manager_details; ?>
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
                                <button type="submit" class="btn btn-success" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
    </div>
</body>
