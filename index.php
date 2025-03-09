<?php
// Database connection parameters
$servername = "sql101.infinityfree.com";
$username = "if0_38478136";
$password = "***************";
$dbname = "if0_38478136";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch a random GIF URL from the database
$sql = "SELECT url FROM gifs ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $gif_url = $row["url"];
    // Redirect to the GIF URL
    header("Location: " . $gif_url);
    exit();
} else {
    echo "No GIFs found in the database.";
}

$conn->close();
?>
