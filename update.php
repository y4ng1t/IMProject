<?php
session_start(); // Start the session

$response = array(); // Create an array to store the response data

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve CustomerID from session
    if (isset($_SESSION['customerid'])) {
        $customerID = $_SESSION['customerid'];
    } else {
        // If CustomerID is not available in session, handle the error accordingly
        $response['error'] = "CustomerID not found in session";
        echo json_encode($response); // Return JSON response
        exit(); // Stop execution
    }

    // Extract data from the POST request
    $gender = $_POST['Gender'];
    $married = $_POST['Married'];
    $education = $_POST['Education'];
    $dependents = $_POST['Dependents'];
    $applicantIncome = $_POST['ApplicantIncome'];
    $coapplicantIncome = $_POST['CoapplicantIncome'];
    $creditHistory = $_POST['CreditHistory'];
    $propertyArea = $_POST['PropertyArea'];
    $selfEmployed = $_POST['$selfEmployed'];
    // Connect to MySQL database
    $conn = mysqli_connect("localhost", "root", "", "loan");

    // Check connection
    if (!$conn) {
        $response['error'] = "Connection failed: " . mysqli_connect_error();
        echo json_encode($response); // Return JSON response
        exit(); // Stop execution
    }

    // Prepare SQL statement for the loan table
    $sql_loan = "UPDATE customers SET Gender=?, Married=?, Education=?, Dependents=?, ApplicantIncome=?, CoapplicantIncome=?, CreditHistory=?, PropertyArea=?, selfEmployed=? WHERE CustomerID=?";

    // Prepare and bind parameters for the loan table
    $stmt_loan = mysqli_prepare($conn, $sql_loan);

    if (!$stmt_loan) {
        $response['error'] = "Error preparing statement: " . mysqli_error($conn);
        echo json_encode($response); // Return JSON response
        exit(); // Stop execution
    }

    mysqli_stmt_bind_param($stmt_loan, "ssssddssds", $gender, $married, $education, $dependents, $applicantIncome, $coapplicantIncome, $creditHistory, $propertyArea,$selfEmployed, $customerID);

    // Execute the statement for the loan table
    if (mysqli_stmt_execute($stmt_loan)) {
        $response['success'] = "Data saved to database successfully";
        echo json_encode($response); // Return JSON response
    } else {
        $response['error'] = "Error: " . mysqli_error($conn);
        echo json_encode($response); // Return JSON response
    }

    // Close statement for the loan table
    mysqli_stmt_close($stmt_loan);

    // Close connection
    mysqli_close($conn);
} else {
    $response['error'] = "Invalid request method";
    echo json_encode($response); // Return JSON response
}
?>
