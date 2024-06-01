<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loan";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $sql = "SELECT users.*, customers.customerid FROM users
            LEFT JOIN customers ON users.userid = customers.userid
            WHERE users.Username = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password']; // Get hashed password from database

        $user_password = $_POST['password'];
        
        if (password_verify($user_password, $hashed_password)) {
            // Passwords match, authentication successful
            $_SESSION['username'] = $email; // Store the email in session
            $_SESSION['customerid'] = $row['customerid']; // Store the customerid in session
                
            // Set localStorage values for JavaScript
            echo "<script>";
            echo "localStorage.setItem('isLoggedIn', 'true');";
            echo "localStorage.setItem('username', '" . $email . "');";
            echo "window.location.href = 'pages/userdash.php';";
            echo "</script>";
            exit();
        } else {
            // Passwords do not match, authentication failed
            echo "<script>";
            echo "alert('Invalid email or password.');";
            echo "window.location.href = 'pages/sign-in.html';";
            echo "</script>";
            exit();
        }
    } else {
        // User not found, authentication failed
        echo "<script>";
        echo "alert('Invalid email or password.');";
        echo "window.location.href = 'pages/sign-in.html';";
        echo "</script>";
        exit();
    }

    // Close database connection
    $conn->close();
}
?>
