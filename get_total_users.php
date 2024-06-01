<?php
header('Content-Type: application/json');

// Suppress output from dbconnect.php
$conn = mysqli_connect("localhost","root","","loan");

$sql = "
    SELECT COUNT(*) AS total_users FROM users
";

// Execute SQL query
if ($result = $conn->query($sql)) {
    // Fetch data and format for JSON
    $data = $result->fetch_assoc(); // Fetch associative array directly
    
    // Free result set
    $result->free();
} else {
    // Handle query execution error
    $data['error'] = $conn->error;
    
    // Output error message to browser console
    echo "<script>";
    echo "console.error('Error executing SQL query: " . $conn->error . "');";
    echo "</script>";
    
    exit(); // Exit script to prevent further execution
}

// Close connection
$conn->close();

// Output JSON
echo json_encode($data);
?>
