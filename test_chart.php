<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loan";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); }

$query = "
    SELECT 
        SUM(CASE WHEN Gender = 'Male' THEN 1 ELSE 0 END) AS Male,
        SUM(CASE WHEN Gender = 'Female' THEN 1 ELSE 0 END) AS Female,
        SUM(CASE WHEN Married = 'Yes' THEN 1 ELSE 0 END) AS Married_Yes,
        SUM(CASE WHEN Married = 'No' THEN 1 ELSE 0 END) AS Married_No,
        SUM(CASE WHEN Dependents = '0' THEN 1 ELSE 0 END) AS Dependents_0,
        SUM(CASE WHEN Dependents = '1' THEN 1 ELSE 0 END) AS Dependents_1,
        SUM(CASE WHEN Dependents = '2' THEN 1 ELSE 0 END) AS Dependents_2,
        SUM(CASE WHEN Dependents = '3+' THEN 1 ELSE 0 END) AS Dependents_3plus,
        SUM(CASE WHEN Education = 'Graduate' THEN 1 ELSE 0 END) AS Graduate,
        SUM(CASE WHEN Education = 'Not Graduate' THEN 1 ELSE 0 END) AS Not_Graduate,
        SUM(CASE WHEN Self_Employed = 'Yes' THEN 1 ELSE 0 END) AS Self_Employed_Yes,
        SUM(CASE WHEN Self_Employed = 'No' THEN 1 ELSE 0 END) AS Self_Employed_No,
        SUM(CASE WHEN Credit_History = '0' THEN 1 ELSE 0 END) AS Credit_History_0,
        SUM(CASE WHEN Credit_History = '1' THEN 1 ELSE 0 END) AS Credit_History_1,
        SUM(CASE WHEN Property_Area = 'Urban' THEN 1 ELSE 0 END) AS Property_Area_Urban,
        SUM(CASE WHEN Property_Area = 'Rural' THEN 1 ELSE 0 END) AS Property_Area_Rural,
        SUM(CASE WHEN Property_Area = 'Semiurban' THEN 1 ELSE 0 END) AS Property_Area_Semiurban,
        SUM(CASE WHEN Loan_Status = 'Y' THEN 1 ELSE 0 END) AS Loan_Status_Approved,
        SUM(CASE WHEN Loan_Status = 'N' THEN 1 ELSE 0 END) AS Loan_Status_Rejected
    FROM 
        loanapplications;
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($connection));
}

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($result);

// Create an associative array to hold the structured data
$structuredData = [
    "Gender" => ["Male" => $row["Male"], "Female" => $row["Female"]],
    "Married" => ["Yes" => $row["Married_Yes"], "No" => $row["Married_No"]],
    "Dependents" => [
        "0" => $row["Dependents_0"],
        "1" => $row["Dependents_1"],
        "2" => $row["Dependents_2"],
        "3+" => $row["Dependents_3plus"]
    ],
    "Education" => ["Graduate" => $row["Graduate"], "Not Graduate" => $row["Not_Graduate"]],
    "Self_Employed" => ["Yes" => $row["Self_Employed_Yes"], "No" => $row["Self_Employed_No"]],
    "Credit_History" => ["0" => $row["Credit_History_0"], "1" => $row["Credit_History_1"]],
    "Property_Area" => [
        "Urban" => $row["Property_Area_Urban"],
        "Rural" => $row["Property_Area_Rural"],
        "Semiurban" => $row["Property_Area_Semiurban"]
    ],
    "Loan_Status" => ["Approved" => $row["Loan_Status_Approved"], "Rejected" => $row["Loan_Status_Rejected"]]
];

// Convert the result to JSON format and output it
echo json_encode($structuredData);

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>