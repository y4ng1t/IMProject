<?php
header('Content-Type: application/json');

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "loan");

// Check connection
if (!$conn) {
    $data['error'] = mysqli_connect_error();
    echo json_encode($data);
    exit();
}

$sql = "SELECT COUNT(*) AS totalapplication, SUM(LoanAmount) AS totalloanamount, SUM(Loan_Amount_Term) AS totalTerm FROM loanapplications";

// Execute SQL query
// Execute SQL query
$result = mysqli_query($conn, $sql);

if ($result) {
    // Fetch data
    $row = mysqli_fetch_assoc($result);
    
    // Calculate average loan amount
    $averageLoanAmount = $row['totalloanamount'] / $row['totalapplication'];
    $averageTerm = $row['totalTerm'] / $row['totalapplication'];

    // Format data for JSON response
    $formattedAverageLoanAmount = number_format($averageLoanAmount, 2);
    $formattedAverageTermAmount = number_format($averageTerm, 2);
 
    // Format data for JSON response
    $data = [
        'totalapplication' => $row['totalapplication'],
        'totalloanamount' => $row['totalloanamount'],
        'averageterm' => $formattedAverageTermAmount,
        'averageloanamount' => $formattedAverageLoanAmount
    ];


    // Free result set
    mysqli_free_result($result);
} else {
    // Handle query execution error
    $data['error'] = mysqli_error($conn);
    
    // Output error message to browser console
    echo "<script>";
    echo "console.error('Error executing SQL query: " . mysqli_error($conn) . "');";
    echo "</script>";
    
    exit(); // Exit script to prevent further execution
}

// Close connection
mysqli_close($conn);

// Output JSON
echo json_encode($data);
?>
