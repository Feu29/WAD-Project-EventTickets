<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$user_email = $_SESSION['email'];

// Database connection
$conn = new mysqli("localhost", "root", "", "event_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the event ID
if (!isset($_POST['event_id'])) {
    die("Invalid request.");
}

$event_id = intval($_POST['event_id']);
$booking_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
$seat_number = rand(1, 200); // Generate random seat number (or use seat allocation logic)

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (user_email, event_id, booking_code, seat_number) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sisi", $user_email, $event_id, $booking_code, $seat_number);
$stmt->execute();
$stmt->close();

// Get event name for email
$event_query = $conn->prepare("SELECT event_name FROM events WHERE id = ?");
$event_query->bind_param("i", $event_id);
$event_query->execute();
$event_query->bind_result($event_name);
$event_query->fetch();
$event_query->close();

// Send email
$subject = " Your Booking Confirmation - $event_name";
$message = "Hi there,\n\nYou have successfully booked a seat for *$event_name*.\n\nSeat Number: $seat_number\nBooking Code: $booking_code\n\nThank you for using our system!";
$headers = "From: noreply@universityevents.com";

mail($user_email, $subject, $message, $headers);

$conn->close();

// Redirect back with success message
header("Location: main.php?success=1");
exit;
?>
