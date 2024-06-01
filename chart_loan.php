<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "loan");


// SQL query to get counts of approved and rejected applicants
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get counts of approved and rejected applicants
$sql = "SELECT 
            SUM(CASE WHEN Loan_Status = 'Y' THEN 1 ELSE 0 END) AS ApprovedCount,
            SUM(CASE WHEN Loan_Status = 'N' THEN 1 ELSE 0 END) AS RejectedCount
        FROM 
            loanapplications";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    // Output JSON
    echo json_encode(array("approved" => $row["ApprovedCount"], "rejected" => $row["RejectedCount"]));
} else {
    // Return default values if no data
    echo json_encode(array("approved" => 0, "rejected" => 0));
}

// Close connection
$conn->close();

?>