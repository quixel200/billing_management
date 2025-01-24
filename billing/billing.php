<?php include '../master/menu.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="billing.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Tile Company Name</h2>
                <p class="text-center">123 abc street | Coimbatore, Tamil Nadu | Pincode: 641669</p>
                <p class="text-center">Phone: 1234567890 | GSTIN: 1234ABCDE | PAN: ABCD1234E</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Bill To:</h4>
                <div class="customer-details">
                    <div class="detail-line">
                        <span class="detail-label">Phone:</span>
                        <input type="number" id="customerPhone" class="form-control detail-input"
                            oninput="fetchCustomerDetails(this.value);">
                    </div>
                    <div class="detail-line">
                        <span class="detail-label">Name:</span>
                        <input type="text" id="customerName" class="form-control detail-input">
                    </div>
                    <div class="detail-line">
                        <span class="detail-label">Address:</span>
                        <textarea id="customerAddress" class="form-control detail-input" rows="3"
                            oninput="adjustTextarea(this);"></textarea>
                    </div>

                    <div class="detail-line">
                        <span class="detail-label">Pincode:</span>
                        <input type="text" id="customerPincode" class="form-control detail-input">
                    </div>
                    <div class="detail-line">
                        <span class="detail-label">Date:</span>
                        <input type="date" id="currentDate" class="form-control detail-input">
                    </div>


                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Billing Details:</h4>
                <div class="mb-3">
                    <select id="billSelector" class="form-control">
                        <option value="" selected>Select Bill</option>
                        <option value="new">New Bill</option>
                    </select>
                </div>
                <table class="table table-bordered" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: auto;">Item</th>
                            <th class="text-center" style="width: 10%;">Qty</th>
                            <th class="text-center" style="width: 10%;">Price</th>
                            <th class="text-center" style="width: 15%;">Amount</th>
                            <th class="text-center" style="width: 10%;">Action</th>
                        </tr>
                    </thead>

                    <tbody id="billingTable">
                        <tr>
                            <td class="suggestion-box">
                                <textarea class="form-control item-search" placeholder="Search product" rows="1"
                                    oninput="adjustTextarea(this);"></textarea>
                                <div class="suggestions"></div>
                            </td>
                            <td><input type="number" class="form-control quantity"></td>
                            <td><input type="number" class="form-control price"></td>
                            <td class="amount">0.00</td>
                            <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-success" id="addRow">Add New Product</button>
                <div class="text-end mt-3">
                    <div class="amount-box">
                        <h5>Amount: <span id="totalAmount">0.00</span></h5>
                        <h5>GST (18%): <span id="gstAmount">0.00</span></h5>
                        <h5>Total: <span id="totalWithGST">0.00</span></h5>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button class="btn btn-primary" id="downloadBill">Download</button>
                    <button class="btn btn-info" id="printBill">Print</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="billing.js"></script>
</body>

</html>
