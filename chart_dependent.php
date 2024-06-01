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
            SUM(CASE WHEN Dependents = '0' THEN 1 ELSE 0 END) AS dep0,
            SUM(CASE WHEN Dependents = '1' THEN 1 ELSE 0 END) AS dep1,
            SUM(CASE WHEN Dependents = '2' THEN 1 ELSE 0 END) AS dep2,
            SUM(CASE WHEN Dependents = '3+' THEN 1 ELSE 0 END) AS dep3
        FROM 
            loanapplications";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    // Output JSON
    echo json_encode(array("dep0" => $row["dep0"], "dep1" => $row["dep1"], "dep2" => $row["dep2"], "dep3" => $row["dep3"]));
}else {
    echo json_encode(array("dep0" => $row[0], "dep1" => $row[0], "dep2" => $row[0], "dep3" => $row[0]));
}

// Close connection
$conn->close();
?>
