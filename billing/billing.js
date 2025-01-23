function adjustTextarea(textarea) {
  textarea.style.height = ""; // Reset height
  textarea.style.height =
    Math.max(textarea.scrollHeight, textarea.clientHeight) + "px"; // Adjust to content
}

// Adjust all dynamic textareas on window resize
function adjustAllTextareas() {
  document.querySelectorAll("textarea").forEach(adjustTextarea);
}

// Attach input and resize listenersa
window.addEventListener("resize", adjustAllTextareas);

// Initialize on page load
window.onload = function () {
  adjustAllTextareas();
};

// Event delegation for dynamic rows in the table
document.getElementById("billingTable").addEventListener("input", function (e) {
  if (e.target && e.target.matches("textarea")) {
    adjustTextarea(e.target);
  }
});

document.getElementById("currentDate").valueAsDate = new Date();
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
            suggestionsBox.append(
              `<div data-price="${product.price}" class="suggestion-item">${product.name}</div>`
            );
          });
        } else {
          console.error("Expected an array but got:", response);
          suggestionsBox.empty();
          suggestionsBox.append("<div>No products found</div>");
        }
      },
      error: function (err) {
        console.error("Error occurred", err);
        suggestionsBox.empty();
        suggestionsBox.append(
          "<div>Something went wrong, try again later.</div>"
        );
      },
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

//fetch customer details
function fetchCustomerDetails(phone) {
  if (phone.length < 10) {
    $("#customerName").val("");
    $("#customerAddress").val("");
    return;
  }
  populateBillsDropdown();
  $.ajax({
    url: "fetch_customer.php",
    method: "GET",
    data: { phone: phone },
    success: function (customer) {
      if (customer) {
        $("#customerName").val(customer.name || "");
        $("#customerAddress").val(customer.address || "");
      } else {
        $("#customerName").val("");
        $("#customerAddress").val("");
      }
    },
    error: function (err) {
      console.error("AJAX error:", err);
    },
  });
}

//Bill details - dropdown

function populateBillsDropdown() {
  $.ajax({
    url: "fetch_bills.php",
    method: "POST",
    data: {
      customer_id: $("#customerPhone").val(),
      shop_id: 1,
    },
    success: function (response) {
      const billSelector = $("#billSelector");
      response.forEach(function (bill) {
        billSelector.append(
          `<option value="${bill.invoice_id}">Bill #${bill.invoice_id} - ${bill.date}</option>`
        );
      });
    },
    error: function (err) {
      console.error("Error fetching bills:", err);
    },
  });
}

// Load bill details for the selected bill
function loadBillDetails(invoiceId) {
  if (invoiceId === "new") {
    if ($("#customerPhone").val().trim() === "") {
        alert("Please enter a customer phone number."); // Show error box
        return; // Exit the function if no phone number is entered
    }
    else {
        $.ajax({
          url: "create_new_invoice.php",
          method: "POST",
          data: {
            customer_id: $("#customerPhone").val(),
            shop_id: "1",
          },
          success: function (response) {
            if (response.success) {
              const newInvoiceId = response.invoice_id;
              // Set the new invoice ID as selected
              $("#billSelector")
                .append(
                  `<option value="${newInvoiceId}" selected>Bill #${newInvoiceId} - New</option>`
                )
                .val(newInvoiceId);
    
              // Clear the table for the new bill
              $("#billingTable").empty();
            } else {
              console.error("Failed to create a new invoice:", response.error);
            }
          },
          error: function (err) {
            console.error("Error creating new invoice:", err);
          },
        });
    }
    return;
  }


  $.ajax({
    url: "fetch_bill_details.php", // Server-side script to fetch bill details
    method: "GET",
    data: { invoice_id: invoiceId },
    success: function (details) {
      const tableBody = $("#billingTable");
      tableBody.empty(); // Clear existing rows

      details.forEach(function (detail) {
        const row = `
                        <tr>
                            <td>${detail.product_name}</td>
                            <td><input type="number" class="form-control quantity" value="${detail.quantity}"></td>
                            <td><input type="number" class="form-control price" value="${detail.unit_price}"></td>
                            <td class="amount">${detail.total_price}</td>
                            <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
                        </tr>`;
        tableBody.append(row);
      });
    },
    error: function (err) {
      console.error("Error fetching bill details:", err);
    },
  });
}

// Handle dropdown change
$("#billSelector").on("change", function () {
  const selectedInvoiceId = $(this).val();
  loadBillDetails(selectedInvoiceId);
});

// Initialize on page load
populateBillsDropdown();
