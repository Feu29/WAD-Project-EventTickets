<?php
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: logIn.php");
    exit;
}

$user_email = $_SESSION['email'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['book_event'])) {
    $event_id = intval($_POST['event_id']);
    $booking_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

    $stmt = $conn->prepare("INSERT INTO bookings (user_email, event_id, booking_code) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $user_email, $event_id, $booking_code);
    $stmt->execute();
    $stmt->close();

   }

// Fetch events
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows === 0) {
    die("No events found in the database.");
}

// Store events in array
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Event Ticketing</title>
  <link rel="stylesheet" href="blues.css">
</head>
<body>
  
  <div class="header">
    <img src="logo.png" alt="logo" width="120">
    <ul>
      <li><a href="logIn.html">LogIn</a></li>
      <li><a href="signUp.html">SignUp</a></li>
      <li><a href="#">Help</a></li>
    </ul>
    <div id="clock"></div>
  </div>

  
  <div class="row" id="events-container">
  <?php foreach($events as $event): ?>
  <div class="card">
    <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['event_name']) ?>">
    <h3><?= htmlspecialchars($event['event_name']) ?></h3>
    <p><?= htmlspecialchars($event['description']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
    <form method="POST" action="book.php">
      <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
      <button type="submit" name="book_event">Book Seat</button>
    </form>
  </div>
<?php endforeach; ?>
</div>
<?php
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$user_email = $_SESSION['email'];

$conn = new mysqli("localhost", "root", "", "event_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Success message after booking
if (isset($_GET['success'])) {
    echo "<p style='color:green; text-align:center; font-weight:bold;'>🎉 Booking successful! Check your email for the code.</p>";
}

// Fetch all events for display
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$events_result = $conn->query($sql);

// Fetch user bookings
$bookings_sql = "
    SELECT e.event_name, e.event_date, b.booking_code, b.seat_number 
    FROM bookings b
    JOIN events e ON b.event_id = e.id
    WHERE b.user_email = ?
    ORDER BY e.event_date ASC
";
$stmt = $conn->prepare($bookings_sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$bookings_result = $stmt->get_result();
?>

<div class="row" id="events-container"></div>

<hr style="margin: 40px 0;">

<h2 style="text-align:center; color:#004d99;">🎟️ Your Booked Events</h2>
<div class="row">
<?php
if ($bookings_result->num_rows > 0) {
    while ($booking = $bookings_result->fetch_assoc()) {
        echo "
        <div class='event-card'>
            <h3>{$booking['event_name']}</h3>
            <p><strong>Date:</strong> {$booking['event_date']}</p>
            <p><strong>Seat:</strong> {$booking['seat_number']}</p>
            <p><strong>Code:</strong> {$booking['booking_code']}</p>
        </div>
        ";
    }
} else {
    echo "<p style='text-align:center; color:#555;'>You haven’t booked any events yet.</p>";
}
?>
</div>



  <script src="main.js"></script>
</body>
</html>
