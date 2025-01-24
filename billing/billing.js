function adjustTextarea(textarea) {
  textarea.style.height = "";
  textarea.style.height =
    Math.max(textarea.scrollHeight, textarea.clientHeight) + "px";
}

function adjustAllTextareas() {
  document.querySelectorAll("textarea").forEach(adjustTextarea);
}

window.addEventListener("resize", adjustAllTextareas);

window.onload = function () {
  adjustAllTextareas();
};

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

$(document).on("input", ".quantity, .price", function () {
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
              `<div data-price="${product.price}" data-product-id="${product.product_id}" class="suggestion-item">${product.name}</div>`
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
  const productId = $(this).data("product-id");
  const suggestionBox = $(this).closest(".suggestion-box");
  const input = suggestionBox.find(".item-search");

  input.val(item);
  input.closest("tr").find(".price").val(price);
  suggestionBox.find(".suggestions").empty();
  suggestionBox.find(".product_id").val(productId);
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

function fetchCustomerDetails(phone) {
  if (phone.length < 10) {
    $("#customerName").val("");
    $("#customerAddress").val("");
    $("#customerPincode").val("");
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
        $("#customerPincode").val(customer.pincode || "");
      } else {
        $("#customerName").val("");
        $("#customerAddress").val("");
        $("#customerPincode").val("");
        createCustomer(phone);
      }
    },
    error: function (err) {
      console.error("AJAX error:", err);
    },
  });
}

function createCustomer(phone) {
  $.ajax({
    url: "create_customer.php",
    method: "POST",
    data: { phone: phone },
    success: function (response) {
      console.log("Customer created successfully:", response);
    },
    error: function (err) {
      console.error("Error creating customer:", err);
    },
  });
}

function saveOrUpdateCustomer(field, value) {
  const phone = $("#customerPhone").val();
  if (!phone) return; 

  const data = {
    phone: phone,
    field: field,
    value: value,
  };

  $.ajax({
    url: "update_customer.php",
    method: "POST",
    data: data,
    success: function (response) {
      console.log("Customer data updated successfully:", response);
    },
    error: function (err) {
      console.error("Error updating customer data:", err);
    },
  });
}

$(document).ready(function () {
  $("#customerName").on("input", function () {
    saveOrUpdateCustomer("name", $(this).val());
  });

  $("#customerAddress").on("input", function () {
    saveOrUpdateCustomer("address", $(this).val());
  });

  $("#customerPincode").on("input", function () {
    saveOrUpdateCustomer("pincode", $(this).val());
  });
});

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

function loadBillDetails(invoiceId) {
  if (invoiceId === "new") {
    if ($("#customerPhone").val().trim() === "") {
        alert("Please enter a customer phone number.");
        return;
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
              $("#billSelector")
                .append(
                  `<option value="${newInvoiceId}" selected>Bill #${newInvoiceId} - New</option>`
                )
                .val(newInvoiceId);
    
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
    url: "fetch_bill_details.php",
    method: "GET",
    data: { invoice_id: invoiceId },
    success: function (details) {
      const tableBody = $("#billingTable");
      tableBody.empty();

      details.forEach(function (detail) {
        const row = `
                        <tr>
                            <td>${detail.product_name}</td>
                            <td><input type="number" class="form-control quantity" value="${detail.quantity}"></td>
                            <td><input type="number" class="form-control price" value="${detail.unit_price}"></td>
                            <td class="amount">${detail.quantity * detail.unit_price}</td>
                            <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
                            <input type="hidden" class="product_id" value="${detail.product_id}">
                        </tr>`;
        tableBody.append(row);
        calculateTotal();
      });
    },
    error: function (err) {
      console.error("Error fetching bill details:", err);
    },
  });
}

$("#billSelector").on("change", function () {
  const selectedInvoiceId = $(this).val();
  loadBillDetails(selectedInvoiceId);
});

populateBillsDropdown();

function addRowToDatabase(data, rowElement) {
  $.ajax({
    url: "database_row_add.php",
    method: "POST",
    data: data,
    success: function (response) {
      if (response.success) {
        rowElement.data("item_id", response.item_id);
        console.log("Row added successfully:", response);
      } else {
        console.error("Failed to add row:", response.error);
      }
    },
    error: function (err) {
      console.error("Error adding row:", err);
    },
  });
}

$(document).on("focus", ".quantity", function () {
  const row = $(this).closest("tr");

  if (!row.data("added")) {
    const productId = row.find(".product_id").val();
    const quantity = parseFloat(row.find(".quantity").val()) || 0;
    const unitPrice = parseFloat(row.find(".price").val()) || 0;
    const invoiceId = $("#billSelector").val();

    if (invoiceId && invoiceId !== "new") {
      const rowData = {
        invoice_id: invoiceId,
        product_id: productId,
        quantity: quantity,
        unit_price: unitPrice
      };

      addRowToDatabase(rowData, row);
      row.data("added", true); 
    }
  }
});


function removeRowFromDatabase(productId, invoiceId) {
  if (!productId) return;
  $.ajax({
    url: "database_row_delete.php",
    method: "POST",
    data: { product_id: productId, invoice_id: invoiceId },
    success: function (response) {
      if (response.success) {
        console.log("Row removed successfully:", response);
      } else {
        console.error("Failed to remove row:", response.error);
      }
    },
    error: function (err) {
      console.error("Error removing row:", err);
    },
  });
}

$("#addRow").click(function () {
  const invoiceId = $("#billSelector").val();
  if (!invoiceId || invoiceId === "new") {
    alert("Please select or create a bill first.");
    return;
  }

  const newRow = `
    <tr>
      <td class="suggestion-box">
        <textarea class="form-control item-search" placeholder="Search product" rows="1"></textarea>
        <input type="hidden" class="product_id" value="">
        <div class="suggestions"></div>
      </td>
      <td><input type="number" class="form-control quantity"></td>
      <td><input type="number" class="form-control price"></td>
      <td class="amount">0.00</td>
      <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td
    </tr>`;
  $("#billingTable").append(newRow);
});

$(document).on("click", ".remove-row", function () {
  const row = $(this).closest("tr");
  const productId = row.find(".product_id").val();
  const invoiceId = $("#billSelector").val();
  removeRowFromDatabase(productId, invoiceId);
  row.remove();
  calculateTotal();
});

function updateRowInDatabase(invoiceId, productId, updatedData) {
  if (!productId) return;
  $.ajax({
    url: "database_row_update.php",
    method: "POST",
    data: {
      invoice_id: invoiceId,
      product_id: productId,
      quantity: updatedData.quantity,
      unit_price: updatedData.unit_price,
    },
    success: function (response) {
      if (response.success) {
        console.log("Row updated successfully:", response);
      } else {
        console.error("Failed to update row:", response.error);
      }
    },
    error: function (err) {
      console.error("Error updating row:", err);
    },
  });
}

$(document).on("change", ".quantity, .price", function () {
  const row = $(this).closest("tr");
  const invoiceId = $("#billSelector").val();
  const productId = row.find(".product_id").val();
  const quantity = parseFloat(row.find(".quantity").val()) || 0;
  const unit_price = parseFloat(row.find(".price").val()) || 0;

  updateRowInDatabase(invoiceId, productId, { quantity, unit_price});

  calculateTotal();
});