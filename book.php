<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// Database connection
$conn = new mysqli("localhost", "root", "", "event_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['book_event'])) {
    $event_id = intval($_POST['event_id']);
    $booking_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

    // Check how many seats this user has already booked for this event
    $check_stmt = $conn->prepare("SELECT COUNT(*) as seat_count FROM bookings WHERE user_email = ? AND event_id = ?");
    $check_stmt->bind_param("si", $user_email, $event_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result()->fetch_assoc();
    $check_stmt->close();

    if ($check_result['seat_count'] >= 2) {
        echo "<script>alert('You cannot book more than 2 seats for this event.');</script>";
    } else {
        // Insert booking
        $stmt = $conn->prepare("INSERT INTO bookings (user_email, event_id, booking_code) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $user_email, $event_id, $booking_code);
        $stmt->execute();
        $stmt->close();

        // Send email
        $subject = "Your Booking Code";
        $message = "Thank you for booking!\nYour booking code for the event is: $booking_code";
        $headers = "From: noreply@universityevents.com";
        mail($user_email, $subject, $message, $headers);

        echo "<script>alert('Booking successful! Check your email for the code.');</script>";
    }
}

$conn->close();

// Redirect back with success message
header("Location: main.php?success=1");
exit;
?>
