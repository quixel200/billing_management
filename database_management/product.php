<?php include '../master/menu.php';
include '../master/config.php';

$category_query = "select * from category";
$product_query = "select t.name as type_name,t.color,t.size,c.name as product_name from type t join category c on c.category_id=t.category_id";
if(isset($_POST['category_submit'])){
    $name = $_POST['name'];
    $stmt = $connection->prepare("insert into category(name) values (?)");
    $stmt->bind_param("s",$name);
    $stmt->execute();
}

if(isset($_POST['product_submit'])){
    $name = $_POST['name'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $category_id = $_POST['category_id'];
    $stmt = $connection->prepare("insert into type(name,color,size,category_id) values (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$color,$size,$category_id);
    $stmt->execute();
}

$category_table = '';
$category_dropdown = '';
$product_table = '';

$queryEXE = mysqli_query($connection,$category_query);
while($row = mysqli_fetch_array($queryEXE)){
    $category_table.='<tr><td>'.$row['name'].'</td>';
    $category_table.= "<td>
            <form method='post' action=''>
                <button class='btn btn-outline-primary' name='edit' type='submit'>
                    <i class='bi bi-pencil-square'></i>
                </button>
                <button class='btn btn-outline-danger' name='delete' type='submit'>
                    <i class='bi bi-trash'></i>
                </button>
            </form>
        </td>";
    $category_table.= "</tr>";
    $category_dropdown.='<option value="'.$row['category_id'].'">'.$row['name'].'</option>';
}
$queryEXE1 = mysqli_query($connection,$product_query);
while($row = mysqli_fetch_array($queryEXE1)){
    $product_table.='<tr><td>'.$row['type_name'].'</td>';
    $product_table.='<td>'.$row['color'].'</td>';
    $product_table.='<td>'.$row['size'].'</td>';
    $product_table.='<td>'.$row['product_name'].'</td>';
    $product_table.= "<td>
            <form method='post' action=''>
                <button class='btn btn-outline-primary' name='edit' type='submit'>
                    <i class='bi bi-pencil-square'></i>
                </button>
                <button class='btn btn-outline-danger' name='delete' type='submit'>
                    <i class='bi bi-trash'></i>
                </button>
            </form>
        </td>";
    $product_table.= "</tr>";
}

?>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php echo $category_table; ?>
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
                        <form method="post" action="product.php">
                            <div class="modal-body">
                                <div>
                                    <b><label class="form-label">Category Name:</label></b>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Category Name" required>
                                </div>
                                <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-success" name="category_submit">Submit</button>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $product_table; ?>
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
                        <form method="post" action="product.php">
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
                                    <select class="form-select" name="category_id">
                                        <option selected value="">Select Category</option>
                                        <?php echo $category_dropdown; ?>
                                    </select>
                                </div>
                                <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-success" name="product_submit">Submit</button>
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
