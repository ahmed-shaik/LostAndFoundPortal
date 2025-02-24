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

// Get the search query from the URL
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="/clgp1/css/style.css">
</head>
<body>
    <header>
        <h1>Search Results</h1>
        <p>Showing results for: <strong><?php echo htmlspecialchars($searchQuery); ?></strong></p>
    </header>

    <section>
        <form action="search_results.php" method="GET">
            <input type="text" name="query" placeholder="Search again..." value="<?php echo htmlspecialchars($searchQuery); ?>" />
            <button type="submit">Search</button>
        </form>
    </section>

    <section>
        <h2>Matching Lost Items</h2>
        <div class="items-container">
            <?php
            if (!empty($searchQuery)) {
                $sql = "SELECT item_name, description, lost_date, location, contact_name, email, phone 
                        FROM lost_items 
                        WHERE item_name LIKE ? OR description LIKE ? OR location LIKE ?
                        ORDER BY lost_date DESC";
                
                $stmt = $conn->prepare($sql);
                $searchTerm = "%" . $searchQuery . "%";
                $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<h3>" . htmlspecialchars($row["item_name"]) . "</h3>";
                        echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";
                        echo "<p><strong>Date Lost:</strong> " . htmlspecialchars($row["lost_date"]) . "</p>";
                        echo "<p><strong>Location:</strong> " . htmlspecialchars($row["location"]) . "</p>";
                        echo "<p><strong>Contact:</strong> " . htmlspecialchars($row["contact_name"]) . " | " . htmlspecialchars($row["email"]) . " | " . htmlspecialchars($row["phone"]) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No matching lost items found.</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Please enter a search query.</p>";
            }
            ?>
        </div>
    </section>

    <section>
        <h2>Matching Found Items</h2>
        <div class="items-container">
            <?php
            if (!empty($searchQuery)) {
                $sql = "SELECT item_name, description, found_date, location, contact_name, email, phone 
                        FROM found_items 
                        WHERE item_name LIKE ? OR description LIKE ? OR location LIKE ?
                        ORDER BY found_date DESC";
                
                $stmt = $conn->prepare($sql);
                $searchTerm = "%" . $searchQuery . "%";
                $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();

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
                    echo "<p>No matching found items found.</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Please enter a search query.</p>";
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
