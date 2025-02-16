<?php
// Database Connection
$servername = "localhost";
$username = "root";  // Default username for XAMPP
$password = "";      // No password by default
$dbname = "lost_found_db"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_type = $_POST["item_type"]; // "Lost" or "Found"
    $item_name = $_POST["itemName"];
    $description = $_POST["description"];
    $date = $_POST["date"];
    $location = $_POST["location"];
    $contact_name = $_POST["contactName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Determine the correct table to insert data
    $table = ($item_type == "Lost") ? "lost_items" : "found_items";

    // SQL Query to insert data
    $sql = "INSERT INTO $table (item_name, description, " . 
           (($item_type == "Lost") ? "lost_date" : "found_date") . ", location, contact_name, email, phone)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $item_name, $description, $date, $location, $contact_name, $email, $phone);

    if ($stmt->execute()) {
        echo "Success! Your item has been reported.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
