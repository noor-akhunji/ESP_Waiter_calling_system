<?php

// Database connection settings
$servername = "localhost"; //89.117.157.204
$username = "u298189197_noor";
$password = "Noornx9$";
$database = "u298189197_esp_waiter";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve waiter call data
$sql = "SELECT * FROM waiter_calls ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $waiterCalls = array();

    while ($row = $result->fetch_assoc()) {
        $waiterCall = array(
            "id" => $row["id"],
            "esp_id" => $row["esp_id"],
            "table_number" => $row["table_number"],
            "timestamp" => $row["timestamp"]
        );

        $waiterCalls[] = $waiterCall;
    }

    // Convert the array to JSON and output it
    header("Content-Type: application/json");
    echo json_encode($waiterCalls);
} else {
    echo "No waiter calls found";
}

// Close the database connection
$conn->close();
?>
