<?php include '../master/menu.php';
include '../master/config.php';

$customer_type_details = '';
$customer_type_query = 'select * from customer_type';
$queryRES = mysqli_query($connection,$customer_type_query);
while($row = mysqli_fetch_array($queryRES)){
    $customer_type_details.='<option value="'.$row['customer_type_id'].'">'.$row['description'].'</option>';
}

if(isset($_POST['submit'])){
    $customer = $_POST['customer'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $customer_type_id = $_POST['customer_type'];
    $stmt = $connection->prepare('insert into customer(mobile_number,name,address,customer_type_id) values (?,?,?,?)');
    $stmt->bind_param("ssss",$mobile,$customer,$address,$customer_type_id);
    $stmt->execute();
}

$customer_details = '';
$customer_query = 'select c.mobile_number,c.name,c.address,ct.description from customer c join customer_type ct on ct.customer_type_id=c.customer_type_id';
$queryEXE = mysqli_query($connection,$customer_query);
while($row = mysqli_fetch_array($queryEXE)){
    $customer_details.='<tr><td>'.$row['name'].'</td>';
    $customer_details.='<td>'.$row['address'].'</td>';
    $customer_details.='<td>'.$row['mobile_number'].'</td>';
    $customer_details.='<td>'.$row['description'].'</td></tr>';
}

?>
<html lang="en">
<head>
    <title>Customer</title>
</head>
<body class="container">
    <div class="">
        <div class="container">
            <div class="text-center mt-3">
                <h3>Customer</h3>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Mobile Number</th>
                            <th scope="col">Customer type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $customer_details; ?>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_customer">
                    Add Customer
                </button>
                <div class="modal fade" id="add_customer" tabindex="-1" aria-labelledby="add_customerLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_customerLabel">Add Customer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="customer.php">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Customer Name:</label></b>
                                    <input type="text" class="form-control" name="customer" placeholder="Enter Customer Name" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Address:</label></b>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Mobile Number:</label></b>
                                    <input type="text" class="form-control" name="mobile" placeholder="Enter Contact" required>
                                </div>
                                <div>
                                    <b><label class="form-label mt-3">Customer Type:</label></b>
                                    <select class="form-select" name="customer_type">
                                        <option selected value="">Select Customer type</option>
                                        <?php echo $customer_type_details; ?>
                                    </select>
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
