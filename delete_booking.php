<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "Error: Not logged in";
    exit;
}

$user_email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_code'])) {
    $booking_code = $_POST['booking_code'];

    $conn = new mysqli("localhost", "root", "", "event_database");
    if ($conn->connect_error) {
        echo "Error: Database connection failed";
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_code = ? AND user_email = ?");
    $stmt->bind_param("ss", $booking_code, $user_email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Booking canceled successfully!";
    } else {
        echo "Error: Booking not found or already deleted";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
