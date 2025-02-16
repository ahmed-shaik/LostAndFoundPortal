<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_found_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch found items
$sql = "SELECT item_name, description, found_date, location, contact_name, email, phone FROM found_items ORDER BY found_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>
    <link rel="stylesheet" href="/clgp1/css/style.css">
</head>
<body>
    <header>
        <h1>Found Items</h1>
        <p>Here are the items that have been reported as found.</p>
    </header>

    <section>
        <div>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<h3>" . htmlspecialchars($row["item_name"]) . "</h3>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";
                    echo "<p><strong>Date Found:</strong> " . htmlspecialchars($row["found_date"]) . "</p>";
                    echo "<p><strong>Location:</strong> " . htmlspecialchars($row["location"]) . "</p>";
                    echo "<p><strong>Contact:</strong> " . htmlspecialchars($row["contact_name"]) . " | " . htmlspecialchars($row["email"]) . " | " . htmlspecialchars($row["phone"]) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No found items available.</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Lost and Found Portal. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
