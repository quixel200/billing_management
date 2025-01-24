<?php
include '../master/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? null;
    $customerTypeId = 1;

    if ($phone) {
        $checkQuery = "SELECT * FROM customer WHERE mobile_number = ?";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $insertQuery = "INSERT INTO customer (mobile_number, customer_type_id) VALUES (?, ?)";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param("si", $phone, $customerTypeId);            

            if ($stmt->execute()) {
                echo "Customer created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Customer already exists";
        }

        $stmt->close();
        $connection->close();
    } else {
        echo "Invalid input";
    }
}
?>
