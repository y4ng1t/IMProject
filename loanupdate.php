<?php
// Include database connection file
include 'dbconnect.php';

// Retrieve data from POST request
$data = json_decode(file_get_contents("php://input"), true);

// Extract data from the form
$name = $data['name'];
$gender = $data['gender'];
$married = $data['married'];
$dependents = $data['Dependents'];
$propertyArea = $data['Property'];
$education = $data['Education'];
$selfEmployed = $data['selfemployed'];
$applicantIncome = $data['ApplicantIncome'];
$coApplicantIncome = $data['coApplicantIncome'];
$loanAmount = $data['LoanAmount'];
$loanTime = $data['LoanTime'];
$creditHistory = $data['CreditHistory'];
$prediction = $data['prediction']; // Assuming this comes from prediction result
$dueDate = $data['due_date']; // Assuming this comes from due date calculation

// Insert data into the first table
$sql1 = "INSERT INTO form_data (name, gender, married, dependents, property_area, education, self_employed, applicant_income, co_applicant_income, loan_amount, loan_time, credit_history, prediction) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("sssssssssssss", $name, $gender, $married, $dependents, $propertyArea, $education, $selfEmployed, $applicantIncome, $coApplicantIncome, $loanAmount, $loanTime, $creditHistory, $prediction);

if ($stmt1->execute() === FALSE) {
    echo "Error inserting data into form_data table: " . $conn->error;
    $stmt1->close();
    $conn->close();
    exit();
}

// Get the ID of the inserted record in the first table
$formId = $stmt1->insert_id;

$stmt1->close();

// Insert data into the second table
$sql2 = "INSERT INTO loan_table (form_id, start_date, due_date) VALUES (?, NOW(), ?)";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ss", $formId, $dueDate);

if ($stmt2->execute() === TRUE) {
    echo "Data inserted successfully into both tables";
} else {
    echo "Error inserting data into loan_table: " . $conn->error;
}

// Close statement and connection
$stmt2->close();
$conn->close();
?>

