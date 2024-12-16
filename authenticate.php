<?php
session_start();

// Enable error reporting for debugging during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli("127.0.0.1", "root", "", "college_database","3308");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $captchaInput = trim($_POST['captcha']);
    $captchaHidden = trim($_POST['captcha-hidden']);

    // Validate captcha
    if ($captchaInput !== $captchaHidden) {
        echo "<script>alert('Invalid captcha.'); window.location.href='login.html';</script>";
        exit;
    }

    // Hash the password using SHA-256
    $hashedPassword = hash('sha256', $password);

    // Use prepared statements to check the credentials
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User authenticated
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            // Redirect to add_college.html
            header("Location:add_college.html");
            exit;
        } else {
            // Invalid credentials
            echo "<script>alert('Invalid credentials.'); window.location.href='login.html';</script>";
        }

        $stmt->close();
    } else {
        // Error in preparing the statement
        error_log("Failed to prepare the SQL statement: " . $conn->error);
        echo "<script>alert('An error occurred. Please try again later.'); window.location.href='login.html';</script>";
    }
}

$conn->close();
?>
