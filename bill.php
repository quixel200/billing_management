<html lang="en">
<head>
    <title>Bill Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div>
            <h4 class="text-center mb-3">Billing The Product</h4>
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
                        <div class="d-grid gap-2 col-4 mx-auto">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-dark w-100" type="button" id="addProduct">Add Product</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-dark w-100" type="submit">Proceed</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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