<?php
// Database connection
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

// SQL query to get counts of male and female applicants
$sql = "SELECT 
            SUM(CASE WHEN Gender = 'Male' THEN 1 ELSE 0 END) AS MaleCount,
            SUM(CASE WHEN Gender = 'Female' THEN 1 ELSE 0 END) AS FemaleCount
        FROM 
            loanapplications";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    // Output JSON
    echo json_encode(array("male" => $row["MaleCount"], "female" => $row["FemaleCount"]));
} else {
    // Return default values if no data
    echo json_encode(array("male" => 0, "female" => 0));
}

// Close connection
$conn->close();
?>
