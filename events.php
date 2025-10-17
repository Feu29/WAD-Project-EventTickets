<?php
session_start();
header("Content-Type: application/json");

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}
$user_email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
   echo  json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
}
if (isset($_POST['book_event'])) {
    $event_id = intval($_POST['event_id']);
    $booking_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

    $stmt = $conn->prepare("INSERT INTO bookings (user_email, event_id, booking_code) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $user_email, $event_id, $booking_code);
    $stmt->execute();
    $stmt->close();

   
}


$sql = "SELECT id, event_name, description, event_date, image_path FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit;
}


$events = [];


    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
$conn->close();

echo json_encode($events);


?>
