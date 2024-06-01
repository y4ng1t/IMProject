<?php
header('Content-Type: application/json');

// Suppress output from dbconnect.php
$conn = mysqli_connect("localhost", "root", "", "loan");

// Query to calculate total loan amount, total interest loan, and total loan count
$sql = "
    SELECT 
        SUM(Amount) AS TotalLoan,
        SUM((TIMESTAMPDIFF(month, StartDate, EndDate) + 1) * Amount * InterestRate / 100) AS TotalInterestLoan,
        COUNT(*) AS TotalLoanCount
    FROM loans
";

// Execute SQL query
if ($result = $conn->query($sql)) {
    // Fetch data
    $row = $result->fetch_assoc();
    
    // Extract total loan, total interest loan, and total loan count
    $combinedTotalLoan = $row['TotalLoan'];
    $combinedTotalInterestLoan = $row['TotalInterestLoan'];
    $totalLoanCount = $row['TotalLoanCount'];

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

// Output combined total loan, total interest loan, and total loan count
echo json_encode([
    'totalLoan' => $combinedTotalLoan,
    'totalProfit' => $combinedTotalInterestLoan,
    'totalTransactions' => $totalLoanCount
]);
?>
