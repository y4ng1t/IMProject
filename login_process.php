<?php
// Include database connection
include("dbconnect.php");

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform SQL query to check if the username and password match
    // This is just a placeholder example, you should use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Check if a row is returned
    if ($result->num_rows == 1) {
        // If user exists, set session variables and redirect to dashboard
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit(); // Ensure script stops executing after redirect
    } else {
        // If no match found, redirect back to login page with an error message
        header("Location: login.php?error=invalid_credentials");
        exit(); // Ensure script stops executing after redirect
    }
}
?>
