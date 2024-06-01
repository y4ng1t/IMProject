<?php
// Start session
session_start();
// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];

// Perform any necessary validation/sanitization

// Example: Insert data into database
$servername = "localhost";
$username_db = "root"; // Update with your database username
$password_db = ""; // Update with your database password
$dbname = "loan";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL to insert data into table
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password

// Using prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (Username, Password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();
$stmt->close();

if ($conn->affected_rows > 0) {
    // Retrieve the user_id of the newly inserted user
    $user_id = $conn->insert_id;
    
    // Then, insert data into customers table with the retrieved user_id
    $stmt = $conn->prepare("INSERT INTO customers (UserID, FirstName, LastName, Email, Address, Gender, Phone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $user_id, $firstName, $lastName, $email, $address, $gender, $phone);
    $stmt->execute();
    $stmt->close();

    if ($conn->affected_rows > 0) {
        // Return success response
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        // Return error response
        $response = array('success' => false, 'error' => "Failed to insert customer data");
        echo json_encode($response);
    }
} else {
    // Return error response
    $response = array('success' => false, 'error' => "Failed to insert user data");
    echo json_encode($response);
}

$conn->close();
?>
