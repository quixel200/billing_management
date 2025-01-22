<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Screen Styles */
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin: 5px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            padding: 15px;
        }

        .table tbody tr:last-child {
            font-weight: bold;
        }

        .suggestion-box {
            position: relative;
        }

        .suggestions {
            position: absolute;
            background: white;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
            width: 100%;
        }

        .suggestions div {
            padding: 8px;
            cursor: pointer;
        }

        .suggestions div:hover {
            background: #f8f9fa;
        }

        .amount-box {
            font-size: 16px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }

        .quantity,
        .price {
            text-align: right;
            transition: width 0.3s ease;
        }

        input.form-control,
        textarea.form-control {

            box-shadow: none;
        }

        textarea {
            resize: none;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border: 1px solid #007bff;
        }

        .customer-details {
            margin: 15px 0;
            width: 100%;
        }

        .detail-line {
            display: flex;
            width: 100%;
            margin-bottom: 15px;
            position: relative;
        }

        .detail-label {
            margin-bottom: 5px;
            font-weight: 500;
            min-width: 80px;
        }

        .detail-input {
            margin-left: 0px;
            box-sizing: border-box;
        }

        textarea.detail-input {
            overflow: hidden;
            resize: none;
            min-height: 38px;
            width: calc(100% - 90px);
            padding: 8px;
            line-height: 1.5;
            transition: height 0.1s ease;
        }

        /* Ensure proper textarea behavior in table */
        .table textarea.form-control {
            min-height: 38px;
            width: 100%;
            resize: none;
            overflow: hidden;
            transition: height 0.1s ease;
        }


        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }

            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .container {
                width: 100% !important;
                max-width: none !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                page-break-inside: avoid !important;
            }

            /* Hide action column and related elements */
            .table th:last-child,
            .table td:last-child,
            .suggestions,
            #addRow,
            .remove-row,
            #downloadBill,
            #printBill {
                display: none !important;
            }

            /* Adjust table layout after hiding action column */
            .table th:nth-child(1) {
                width: 50% !important;
            }

            .table th:nth-child(2) {
                width: 15% !important;
            }

            .table th:nth-child(3) {
                width: 15% !important;
            }

            .table th:nth-child(4) {
                width: 20% !important;
            }

            .form-control {
                border: none !important;
                padding: 0 !important;
                background: transparent !important;
            }

            input.form-control,
            textarea.form-control {
                -webkit-appearance: none !important;
                appearance: none !important;
            }

            .table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .table th,
            .table td {
                border: 1px solid #dee2e6 !important;
                padding: 0.5rem !important;
                background-color: transparent !important;
            }

            .amount-box {
                border: 1px solid #dee2e6 !important;
                margin-top: 1rem !important;
                page-break-inside: avoid !important;
            }

            /* Ensure important content starts on a new page if needed */
            .card-body {
                page-break-inside: avoid !important;
            }

            /* Improve header visibility */
            h2,
            h4 {
                margin: 10px 0 !important;
                color: black !important;
            }

            /* Remove unnecessary spacing */
            .form-section {
                padding: 10px 0 !important;
            }

            /* Force show background colors */
            .amount-box {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Ensure proper text contrast */
            * {
                color: black !important;
            }

            .detail-line {
                margin-bottom: 5px !important;
            }

            .detail-label {
                color: black !important;
                font-weight: 500 !important;
            }

            #currentDate {
                border: none !important;
                background: transparent !important;
            }
        }
    </style>
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
                        <span class="detail-label">Name:</span>
                        <input type="text" id="customerName" class="form-control detail-input">
                    </div>
                    <div class="detail-line">
                        <span class="detail-label">Address:</span>
                        <textarea id="customerAddress" class="form-control detail-input" rows="1"
                            oninput="adjustTextarea(this);"></textarea>
                    </div>


                    <div class="detail-line">
                        <span class="detail-label">Pincode:</span>
                        <input type="text" id="customerPincode" class="form-control detail-input">
                    </div>
                    <div class="detail-line">
                        <span class="detail-label">Phone:</span>
                        <input type="text" id="customerPhone" class="form-control detail-input">
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

    <script>

function adjustTextarea(textarea) {
        textarea.style.height = 'auto'; // Reset height
        textarea.style.height = textarea.scrollHeight + 'px'; // Set height to fit content
    }

    // Adjust all dynamic textareas on window resize
    function adjustAllTextareas() {
        document.querySelectorAll('textarea').forEach(adjustTextarea);
    }

    // Attach input and resize listenersa
    window.addEventListener('resize', adjustAllTextareas);

    // Initialize on page load
    window.onload = function () {
        adjustAllTextareas();
    };

    // Event delegation for dynamic rows in the table
    document.getElementById('billingTable').addEventListener('input', function (e) {
        if (e.target && e.target.matches('textarea')) {
            adjustTextarea(e.target);
        }
    });

        $("#addRow").click(function () {
            const newRow = `<tr>
                <td class="suggestion-box">
                    <textarea class="form-control item-search" placeholder="Search product" rows="1"
                        oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
                    ></textarea>
                    <div class="suggestions"></div>
                </td>
                <td><input type="number" class="form-control quantity" oninput="resizeInput(this); adjustColumnWidth(this)"></td>
                <td><input type="number" class="form-control price" oninput="resizeInput(this); adjustColumnWidth(this)"></td>
                <td class="amount">0.00</td>
                <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
            </tr>`;
            $("#billingTable").append(newRow);
        });

        document.getElementById('currentDate').valueAsDate = new Date();
        function calculateTotal() {
            let total = 0;
            $("#billingTable tr").each(function () {
                const quantity = parseFloat($(this).find(".quantity").val()) || 0;
                const price = parseFloat($(this).find(".price").val()) || 0;
                const amount = quantity * price;
                $(this).find(".amount").text(amount.toFixed(2));
                total += amount;
            });
            const gst = total * 0.18;
            const totalWithGST = total + gst;

            $("#gstAmount").text(gst.toFixed(2));
            $("#totalAmount").text(total.toFixed(2));
            $("#totalWithGST").text(totalWithGST.toFixed(2));
        }

        // Attach input event listeners to dynamically adjust column width
        $(document).on("input", ".quantity, .price", function () {
            calculateTotal();
        });


        $("#addRow").click(function () {
            const newRow = `<tr>
        <td class="suggestion-box">
            <textarea class="form-control item-search" placeholder="Search product" rows="1" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
            <div class="suggestions"></div>
        </td>
        <td><input type="number" class="form-control quantity" oninput="resizeInput(this); adjustColumnWidth(this)"></td>
        <td><input type="number" class="form-control price" oninput="resizeInput(this); adjustColumnWidth(this)"></td>
        <td class="amount">0.00</td>
        <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
    </tr>`;
            $("#billingTable").append(newRow);
        });

        $(document).on("click", ".remove-row", function () {
            $(this).closest("tr").remove();
            calculateTotal();
        });

        $(document).on("input", ".item-search", function () {
            const input = $(this);
            const query = input.val();
            const suggestionsBox = input.siblings(".suggestions");

            if (query.length > 1) {
                $.ajax({
                    url: "search_product.php",
                    method: "GET",
                    data: { query },
                    success: function (response) {
                        try {
                            if (typeof response === "string") {
                                response = JSON.parse(response);
                            }
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                            return;
                        }

                        if (Array.isArray(response)) {
                            suggestionsBox.empty();
                            response.forEach(function (product) {
                                suggestionsBox.append(`<div data-price="${product.price}" class="suggestion-item">${product.name}</div>`);
                            });
                        } else {
                            console.error("Expected an array but got:", response);
                            suggestionsBox.empty();
                            suggestionsBox.append('<div>No products found</div>');
                        }
                    },
                    error: function (err) {
                        console.error("Error occurred", err);
                        suggestionsBox.empty();
                        suggestionsBox.append('<div>Something went wrong, try again later.</div>');
                    }
                });
            } else {
                suggestionsBox.empty();
            }
        });

        $(document).on("click", ".suggestion-item", function () {
            const item = $(this).text();
            const price = $(this).data("price");
            const input = $(this).closest(".suggestion-box").find(".item-search");

            input.val(item);
            input.closest("tr").find(".price").val(price);
            input.siblings(".suggestions").empty();
            calculateTotal();
        });

        $("#downloadBill").click(function () {
            const billContent = document.body.innerHTML;
            const blob = new Blob([billContent], { type: "text/html" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "bill.html";
            a.click();
            URL.revokeObjectURL(url);
        });

        $("#printBill").click(function () {
            window.print();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>