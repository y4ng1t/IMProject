<?php
header('Content-Type: application/json');

// Suppress output from dbconnect.php
$conn = mysqli_connect("localhost","root","","loan");

$sql = "
    SELECT 
        EXTRACT(YEAR FROM CreatedAt) AS registration_year,
        EXTRACT(MONTH FROM CreatedAt) AS registration_month,
        COUNT(*) AS total_users
    FROM 
        users
    WHERE 
        EXTRACT(MONTH FROM CreatedAt) <= 12
    GROUP BY 
        EXTRACT(YEAR FROM CreatedAt),
        EXTRACT(MONTH FROM CreatedAt)
    ORDER BY 
        registration_year,
        registration_month
";

// Initialize data array
$data = array();

// Execute SQL query
if ($result = $conn->query($sql)) {
    // Fetch data and format for JSON
    foreach ($result as $row) {
        // Convert numeric month to month text
        $row['registration_month'] = date("F", mktime(0, 0, 0, $row['registration_month'], 1));
        $data[] = $row;
    }
    
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
