<?php include '../master/menu.php';
include '../master/config.php';

if(isset($_POST['submit'])){
    $name = $_POST['supplier'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $stmt = $connection->prepare("insert into supplier(name,contact,address) values (?,?,?)");
    $stmt->bind_param("sss",$name,$contact,$address);
    $stmt->execute();
}

$supplier_details = '';

$supplier_query = 'select * from supplier';
$queryEXE = mysqli_query($connection,$supplier_query);
while($row = mysqli_fetch_array($queryEXE)){
    $supplier_details.="<tr><td>".$row['name']."</td>";
    $supplier_details.="<td>".$row['address']."</td>";
    $supplier_details.="<td>".$row['contact']."</td></tr>";
}


?>

<html lang="en">
<head>
    <title>Suppiler</title>
</head>
<body class="container">
    <div class="">
        <div class="container">
            <div class="text-center mt-3">
                <h3>Suppiler</h3>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $supplier_details; ?>
                    </tbody>
                </table>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_suppiler">
                    Add Supplier
                </button>
                <div class="modal fade" id="add_suppiler" tabindex="-1" aria-labelledby="add_suppilerLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_suppilerLabel">Add Suppiler</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="supplier.php">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Suppiler Name:</label></b>
                                    <input type="text" class="form-control" name="supplier" placeholder="Enter Suppiler Name" required>
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