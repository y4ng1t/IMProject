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
            SUM(CASE WHEN Education = 'Graduate' THEN 1 ELSE 0 END) AS Grad,
            SUM(CASE WHEN Education = 'Not Graduate' THEN 1 ELSE 0 END) AS NotGrad
        FROM 
            loanapplications";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    // Output JSON
    echo json_encode(array("Grad" => $row["Grad"], "NotGrad" => $row["NotGrad"]));
} else {
    // Return default values if no data
    echo json_encode(array("Grad" => 0, "NotGrad" => 0));
}

// Close connection
$conn->close();
?>