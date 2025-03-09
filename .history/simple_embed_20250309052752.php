<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create the embed response
$response = [
    "embeds" => [
        [
            "title" => "Hello",
            "description" => "hello."
        ]
    ]
];

// Set the content type to JSON
header("Content-Type: application/json");

// Output the JSON response
echo json_encode($response);
?>
