<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $gender = $_POST["gender"];
    $married = $_POST["married"];
    $dependents = $_POST["Dependents"];
    $education = $_POST["Education"];
    $selfEmployed = $_POST["selfemployed"];
    $applicantIncome = $_POST["ApplicantIncome"];
    $coapplicantIncome = $_POST["coApplicantIncome"];
    $loanAmount = $_POST["LoanAmount"];
    $loanAmountTerm = $_POST["LoanTime"];
    $creditHistory = $_POST["CreditHistory"];
    $propertyArea = $_POST["Property"];
    $loanStatus = $_POST["Loan_Status"];
    if ($loanStatus === "Rejected") {
        $loanStatus = "N";
    } elseif ($loanStatus === "Approved") {
        $loanStatus = "Y";
    }

    // Connect to MySQL database
    $conn = mysqli_connect("localhost", "root", "", "loan");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL statement
    $sql = "INSERT INTO loanapplications (Gender, Married, Dependents, Education, Self_Employed, ApplicantIncome, CoapplicantIncome, LoanAmount, Loan_Amount_Term, Credit_History, Property_Area, Loan_Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt === false) {
        die("Error: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "sssssddddsss", $gender, $married, $dependents, $education, $selfEmployed, $applicantIncome, $coapplicantIncome, $loanAmount, $loanAmountTerm, $creditHistory, $propertyArea, $loanStatus);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Get the ID of the inserted record
        $lastInsertedId = mysqli_insert_id($conn);
        // Prepare response array
        $response = array("status" => "success", "id" => $lastInsertedId);
        // Encode response as JSON and send it to JavaScript
        echo json_encode($response);
    } else {
        // Prepare error response
        $response = array("status" => "error", "message" => mysqli_error($conn));
        // Encode response as JSON and send it to JavaScript
        echo json_encode($response);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    // Handle invalid request method
    echo "Invalid request method";
}
?>
