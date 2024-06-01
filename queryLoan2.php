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

// Query data from the database
$sql = "SELECT * FROM loans WHERE CustomerID = $customerid";
$result = mysqli_query($connection, $sql);

// Define an array to store loan application data
$loanApplications = [];

// Fetch data from each row and add it to the array
while($row = mysqli_fetch_assoc($result)) {
  $loanApplications[] = $row;
}

// Close database connection
mysqli_close($connection);

// Output loan application data as JSON
header('Content-Type: application/json');
echo json_encode($loanApplications);
?>