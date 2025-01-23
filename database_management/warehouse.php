<?php include '../master/menu.php';
include '../master/config.php';
$warehouse_details = '';
$shop_details = '';

$shop_query = 'select shop_id,address from shop';
$queryEXE1 = mysqli_query($connection,$shop_query);
while($row = mysqli_fetch_array($queryEXE1)){
    $shop_details.='<option value="'.$row['shop_id'].'">'.$row['address'].'</option>';
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $shop_id = $_POST['shop_id'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $stmt = $connection->prepare('insert into warehouse(shop_id,name,address,contact) values (?,?,?,?)');
    $stmt->bind_param("ssss",$shop_id,$name,$address,$contact);
    $stmt->execute();
}


$warehouse_query = 'select s.address as shop_address,w.name,w.address as warehouse_address,w.contact from warehouse w join shop s on s.shop_id=w.shop_id';
$queryEXE = mysqli_query($connection,$warehouse_query);
while($row = mysqli_fetch_array($queryEXE)){
    $warehouse_details.='<tr><td>'.$row['name'].'</td>';
    $warehouse_details.='<td>'.$row['shop_address'].'</td>';
    $warehouse_details.='<td>'.$row['warehouse_address'].'</td>';
    $warehouse_details.='<td>'.$row['contact'].'</td></tr>';
}


?>
<html lang="en">
<head>
    <title>Warehouse</title>
</head>
<body class="container">
    <div class="">
        <div class="container">
            <div class="text-center mt-3">
                <h3>Warehouse</h3>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Warehouse Name</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $warehouse_details; ?>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_warehouse">
                    Add Warehouse
                </button>
                <div class="modal fade" id="add_warehouse" tabindex="-1" aria-labelledby="add_warehouseLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_warehouseLabel">Add Warehouse</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Warehouse Name:</label></b>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Suppiler Name" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Shop Name:</label></b>
                                    <select class="form-select" name="shop_id">
                                        <option selected value="">Select Shop</option>
                                        <?php echo $shop_details; ?>
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
    
</body>
