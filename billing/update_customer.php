<?php
include '../master/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? null;
    $field = $_POST['field'] ?? null;
    $value = $_POST['value'] ?? null;

    if ($phone && $field && $value) {
        $checkQuery = "SELECT * FROM customer WHERE mobile_number = ?";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $updateQuery = "UPDATE customer SET $field = ? WHERE mobile_number = ?";
            $stmt = $connection->prepare($updateQuery);
            $stmt->bind_param("ss", $value, $phone);
        } else {
            $insertQuery = "INSERT INTO customer (mobile_number, $field) VALUES (?, ?)";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param("ss", $phone, $value);
        }

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $connection->close();
    } else {
        echo "Invalid input";
    }
}
?>
