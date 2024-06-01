<?php
// Establish connection to your SQL database
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

// Fetch data from SQL database
$query = "SELECT 
            AVG(CASE WHEN Gender = 'Male' THEN ApplicantIncome ELSE 0 END) AS Male_Average_Income,
            AVG(CASE WHEN Gender = 'Female' THEN ApplicantIncome ELSE 0 END) AS Female_Average_Income
        FROM 
            loanapplications";

$result = $conn->query($query);

// Fetch data and convert to associative array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close connection
$conn->close();

// Encode data as JSON and output
echo json_encode($data);
?>
