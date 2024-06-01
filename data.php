<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$sql = "SELECT * FROM loanapplications";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Fetch associative array
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Send data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
?>
