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
    $row = $result->fetch_assoc();
    $gif_url = $row["url"];
} else {
    die("Error: No GIFs found in the database.");
}

// Serve the HTML with Open Graph meta tags
header("Content-Type: text/html; charset=UTF-8");
header("HTTP/1.1 200 OK");
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
    <link rel="alternate" type="application/json+oembed" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/oembed.json.php?url=' . urlencode($gif_url); ?>" title="Random GIF">
    <title>Random GIF</title>
</head>
<body>
    <img src="<?php echo $gif_url; ?>" alt="Random GIF">
</body>
</html>
<?php
$conn->close();
?>
