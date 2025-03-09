<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "sql101.infinityfree.com";
$username = "if0_38478136";
$password = "R4NwxViy8WOvvjb";
$dbname = "if0_38478136_XXX";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
}

// Fetch all records from the gifs table
$sql = "SELECT * FROM gifs";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<h1>GIF URLs</h1><ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>" . $row["url"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No GIFs found in the database.";
}

$conn->close();
?>
