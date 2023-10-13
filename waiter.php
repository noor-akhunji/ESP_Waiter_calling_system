<?php
// Database connection settings
$servername = "localhost";
$username = "****";
$password = "****";
$database = "esp_waiter";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the incoming POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request
    $json_data = file_get_contents("php://input");
    
    // Decode the JSON data
    $data = json_decode($json_data, true);

    // Validate and sanitize the data (e.g., prevent SQL injection)
    $esp_id = mysqli_real_escape_string($conn, $data['esp_id']);
    $table_number = intval($data['table_number']);

    // Insert the data into the database
    $sql = "INSERT INTO waiter_calls (esp_id, table_number) VALUES ('$esp_id', '$table_number')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Waiter call recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
