<html lang="en">
<head>
    <title>Bill Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="container mt-3">
        <div>
            <h4 class="text-center mb-3">Bill</h4>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <form action="#" method="post">
                    <div class="row">
                        <div class="col">
                            <b><label class="form-label mt-3">Customer Name:</label></b>
                            <input type="text" name="customer" class="form-control" placeholder="Enter the Customer name" required>
                        </div>
                        <div class="col">
                            <b><label class="form-label mt-3">Date of billing:</label></b>
                            <input type="text" name="date" class="form-control" readonly>
                        </div>
                    </div>
                    <div id="product-entries">
                        <div class="row product-row">
                            <div class="col">
                                <b><label class="form-label mt-3">Product Name:</label></b>
                                <div class="input-group">
                                    <input type="text" name="product[]" class="form-control" placeholder="Enter the product name" required>
                                </div>
                            </div>
                            <div class="col">
                                <b><label class="form-label mt-3">Quantity:</label></b>
                                <input type="text" name="quantity[]" class="form-control" placeholder="Enter the quantity" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="d-grid gap-2 col-5 mx-auto">
                            <div class="row">
                                <div class="col-10">
                                    <button class="btn btn-dark w-100" type="button" id="addProduct">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Company Name</h4>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="fw-bold me-2 mb-0">Bill No:</label>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="fw-bold me-2 mb-0">Date:</label>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="fw-bold me-2 mb-0">Time:</label>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            <label class="fw-bold me-2 mb-0">Customer Name:</label>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th scope="col" class="border">S.No</th>
                                <th scope="col" class="border">Product Name</th>
                                <th scope="col" class="border">Quantity</th>
                                <th scope="col" class="border">Unit Price</th>
                                <th scope="col" class="border">Discount</th>
                                <th scope="col" class="border">CGST</th>
                                <th scope="col" class="border">SGST</th>
                                <th scope="col" class="border">Tot Price/product</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            // Set current date
            var currentDate = new Date().toLocaleDateString();
            $('input[name="date"]').val(currentDate);

            // Add product button click handler
            $('#addProduct').click(function() {
                var newRow = `
                    <div class="row product-row">
                        <div class="col">
                            <b><label class="form-label mt-3">Product Name:</label></b>
                            <div class="input-group">
                                <input type="text" name="product[]" class="form-control" placeholder="Enter the product name" required>
                            </div>
                        </div>
                        <div class="col">
                            <b><label class="form-label mt-3">Quantity:</label></b>
                            <input type="text" name="quantity[]" class="form-control" placeholder="Enter the quantity" required>
                        </div>
                        <div class="col-auto d-flex align-items-end">
                            <button class="btn btn-danger remove-row" type="button">Remove</button>
                        </div>
                    </div>
                `;
                $('#product-entries').append(newRow);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.product-row').remove();
            });
        });
    </script>
</body>
</html>