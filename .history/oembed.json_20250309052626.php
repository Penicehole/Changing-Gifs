<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the URL parameter
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url)) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(["error" => "Missing URL parameter"]);
    exit();
}

// Database connection parameters
$servername = "sql101.infinityfree.com";
$username = "if0_38478136";
$password = "R4NwxViy8WOvvjb";
$dbname = "if0_38478136_gifs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Fetch the GIF URL from the database
$sql = "SELECT url FROM gifs WHERE url = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $url);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(["error" => "Error executing query"]);
    exit();
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $gif_url = $row["url"];
    
    $response = [
        "embeds" => [
            [
                "type" => "photo",
                "title" => "Hello",
                "width" => 600,
                "height" => 400,
                "author_name" => "Random GIF"
            ]
        ]
    ];
    
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["error" => "No GIFs found in the database"]);
}

$conn->close();
?>
