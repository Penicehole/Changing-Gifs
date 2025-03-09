<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "sql101.infinityfree.com";
$username = "if0_38478136";
$password = "R4NwxViy8WOvvjb";
$dbname = "if0_38478136_gifs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
}

// Fetch a random GIF URL from the database
$sql = "SELECT url FROM gifs ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $gif_url = $row["url"];
    
    // Check if the URL is valid and accessible
    $headers = get_headers($gif_url, 1);
    if ($headers === false || strpos($headers[0], '200') === false) {
        die("Error: GIF URL is not accessible.");
    }

    // Fetch the GIF content
    $gif_content = file_get_contents($gif_url);
    if ($gif_content === false) {
        die("Error fetching GIF content.");
    }

    // Serve the GIF content
    header("Content-Type: image/gif");
    echo $gif_content;
    exit();
} else {
    echo "No GIFs found in the database.";
}

$conn->close();
?>
