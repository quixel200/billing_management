<?php
include 'master/config.php';

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$where = [];
$params = [];

if (!empty($_GET['client_name'])) {
    $where[] = "client_name LIKE ?";
    $params[] = '%' . $_GET['client_name'] . '%';
}

if (!empty($_GET['status']) && $_GET['status'] !== 'all') {
    $where[] = "status = ?";
    $params[] = $_GET['status'];
}

if (!empty($_GET['invoice_number'])) {
    $where[] = "invoice_no = ?";
    $params[] = $_GET['invoice_number'];
}

$query = "SELECT * FROM invoices";
if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$stmt = $connection->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <h1 class="text-center mb-4">Invoices Report</h1>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
            <script>
    function handleSubmit(event) {
        event.preventDefault(); 

        const form = event.target;
        
        history.replaceState(null, '', window.location.origin + window.location.pathname);

        const formData = new FormData(form);
        
        const params = new URLSearchParams();
        formData.forEach((value, key) => {
            if (value) {
                params.append(key, value); 
            }
        });

        window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
    }
</script>

<form method="GET" action="" class="row g-3" onsubmit="handleSubmit(event)">
    <div class="col-md-3">
        <label class="form-label">Client Name</label>
        <input type="text" name="client_name" class="form-control" value="<?php echo $_GET['client_name'] ?? ''; ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="all">All</option>
            <option value="paid" <?php echo ($_GET['status'] ?? '') === 'paid' ? 'selected' : ''; ?>>Paid</option>
            <option value="unpaid" <?php echo ($_GET['status'] ?? '') === 'unpaid' ? 'selected' : ''; ?>>Unpaid</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Invoice Number</label>
        <input type="text" name="invoice_number" class="form-control" value="<?php echo $_GET['invoice_number'] ?? ''; ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control" value="<?php echo $_GET['city'] ?? ''; ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Issue Date Range</label>
        <div class="row g-2">
            <div class="col">
                <input type="date" name="issue_start" class="form-control" value="<?php echo $_GET['issue_start'] ?? ''; ?>">
            </div>
            <div class="col">
                <input type="date" name="issue_end" class="form-control" value="<?php echo $_GET['issue_end'] ?? ''; ?>">
            </div>
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary me-2">
            <i class="fas fa-search"></i> Search
        </button>
        <button type="reset" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset
        </button>
    </div>
</form>

            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-success me-2" onclick="location.href='new_invoice.php'">
                <i class="fas fa-plus"></i> New Invoice
            </button>
            <button class="btn btn-primary" onclick="exportData()">
                <i class="fas fa-download"></i> Export
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Client Name</th>
                                <th>Invoice No.</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Tax</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $statusClass = $row['status'] === 'paid' ? 'success' : 'warning';
            echo "<tr data-id='{$row['id']}'>
                <td>{$row['id']}</td>
                <td class='client-name'>{$row['client_name']}</td>
                <td class='invoice-no'>{$row['invoice_no']}</td>
                <td class='issue-date'>{$row['issue_date']}</td>
                <td>{$row['due_date']}</td>
                <td>" . number_format($row['amount'], 2) . "</td>
                <td>" . number_format($row['tax'], 2) . "</td>
                <td class='total'>" . number_format($row['total'], 2) . "</td>
                <td><span class='badge bg-{$statusClass}'>{$row['status']}</span></td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-primary' onclick='editInvoice({$row['id']})'>
                            <i class='fas fa-edit'></i>
                        </button>
                        <button class='btn btn-danger' onclick='deleteInvoice({$row['id']})'>
                            <i class='fas fa-trash'></i>
                        </button>
                        <button class='btn btn-success' onclick='emailInvoice({$row['id']})'>
                            <i class='fas fa-envelope'></i>
                        </button>
                    </div>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
    }
    ?>
</tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <form class="d-flex align-items-center">
                    <label class="me-2">Results Per Page:</label>
                    <select name="results_per_page" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="10" <?php echo ($_GET['results_per_page'] ?? 15) == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="15" <?php echo ($_GET['results_per_page'] ?? 15) == 15 ? 'selected' : ''; ?>>15</option>
                        <option value="20" <?php echo ($_GET['results_per_page'] ?? 15) == 20 ? 'selected' : ''; ?>>20</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editInvoice(id) {
            window.location.href = `edit_invoice.php?id=${id}`;
        }

        function deleteInvoice(id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                alert('Delete functionality to be implemented');
            }
        }

        function emailInvoice(id) {
        alert('Email address is required!');
        return;
    }

    const row = document.querySelector(`tr[data-id="${id}"]`);
    const clientName = row.querySelector('.client-name').textContent.trim();
    const invoiceNo = row.querySelector('.invoice-no').textContent.trim();
    const issueDate = row.querySelector('.issue-date').textContent.trim();
    const total = row.querySelector('.total').textContent.trim();

    const formData = new FormData();
    formData.append('email', email);
    formData.append('client_name', clientName);
    formData.append('invoice_no', invoiceNo);
    formData.append('issue_date', issueDate);
    formData.append('total', total);

    fetch('email_invoice.php', {
    method: 'POST',
    body: formData,
})
    .then(response => response.text()) 
    .then(data => {
        console.log('Raw response:', data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.success) {
                alert('Invoice emailed successfully!');
            } else {
                alert('Failed to email invoice: ' + jsonData.message);
            }
        } catch (error) {
            console.error('JSON parse error:', error);
            alert('Invalid response from server.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending the email.');
    });

}


        function exportData() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4');

    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tr');
    
    let tableData = [];
    let tableHeaders = [];
    
    rows[0].querySelectorAll('th').forEach(header => {
        
        if (header.textContent !== 'Actions') {
            tableHeaders.push(header.textContent);
        }
    });

    rows.forEach((row, index) => {
        if (index === 0) return; 
        
        let rowData = [];
        row.querySelectorAll('td').forEach((cell, cellIndex) => {
            if (cellIndex < tableHeaders.length) {
                rowData.push(cell.textContent);
            }
        });
        
        if (rowData.length > 0) {
            tableData.push(rowData);
        }
    });

    doc.setFontSize(16);
    doc.text('Invoices Report', 40, 40);
    
    doc.setFontSize(12);
    doc.text('Generated on: ' + new Date().toLocaleDateString(), 40, 60);

    doc.autoTable({
        head: [tableHeaders],
        body: tableData,
        startY: 70,
        styles: {
            fontSize: 10,
            cellPadding: 5
        },
        headStyles: {
            fillColor: [66, 139, 202],
            textColor: 255
        },
        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },
        margin: { top: 70 }
    });

    doc.save('invoices_report.pdf');
        }
    </script>
</body>
</html>
<?php
$connection->close();
?>
