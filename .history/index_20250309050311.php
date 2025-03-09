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

$max_attempts = 5;
$attempts = 0;
$gif_url = null;

while ($attempts < $max_attempts) {
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
        if ($headers !== false) {
            $http_status = $headers[0];
            if (strpos($http_status, '200') !== false) {
                break;
            }
        }
    }

    $attempts++;
}

if ($gif_url === null || $attempts == $max_attempts) {
    die("Error: No accessible GIF URLs found.");
}

// Serve the HTML with Open Graph meta tags
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Hello">
    <meta property="og:description" content="A random GIF">
    <meta property="og:image" content="<?php echo $gif_url; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <title>Random GIF</title>
</head>
<body>
    <img src="<?php echo $gif_url; ?>" alt="Random GIF">
</body>
</html>
<?php
$conn->close();
?>
