<?php
session_start();

// Check if user is logged in, if not redirect to sign-in page
if (!isset($_SESSION['username'])) {
    header("Location: pages/sign-in.html");
    exit();
}

// Access username and customerid from session
$username = $_SESSION['username'];
$customerid = $_SESSION['customerid'];

// Connect to your database
$connection = mysqli_connect("localhost", "root", "", "loan");

// Check connection
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

// Query loan data from the database
$sql = "SELECT * FROM loans";
$result = mysqli_query($connection, $sql);

// Define arrays to store month and corresponding loan amounts
$months = [];
$loanAmounts = [];
$loanAmountsWithInterest = [];

// Fetch data from each row and add it to the arrays
while($row = mysqli_fetch_assoc($result)) {
  $start_date = strtotime($row['StartDate']);
  $end_date = strtotime($row['EndDate']);
  $loan_amount = $row['Amount'];

  // Calculate the number of months between the start date and end date
  $months_diff = floor(($end_date - $start_date) / (30 * 24 * 60 * 60));

  // Calculate compound interest for each month
  for ($i = 0; $i < $months_diff; $i++) {
    $month = date('Y-m', strtotime("+$i months", $start_date));
    $amount_after_interest = $loan_amount * (pow(1 + (0.05), $i)); // Assuming 5% annual interest

    // Add the month and corresponding loan amounts to the arrays
    $months[] = $month;
    $loanAmounts[] = $loan_amount;
    $loanAmountsWithInterest[] = $amount_after_interest;
  }
}

// Close database connection
mysqli_close($connection);

// Output loan data as JSON
header('Content-Type: application/json');
echo json_encode(array('months' => $months, 'loanAmounts' => $loanAmounts, 'loanAmountsWithInterest' => $loanAmountsWithInterest));
?>
