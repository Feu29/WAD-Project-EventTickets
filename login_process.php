<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

// Get form input
$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user from DB
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Verify password
    if(password_verify($password, $user['password'])) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        header("Location: main.php"); // redirect to events page
        exit;
    } else {
        $_SESSION['error'] = "Invalid password!";
        header("Location: logIn.php");
        exit;
    }
} else {
    $_SESSION['error'] = "User not found!";
    header("Location: logIn.php");
    exit;
}

$stmt->close();
$conn->close();
?>
