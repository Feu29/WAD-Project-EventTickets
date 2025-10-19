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

 
    <button id="toggleTheme" style="margin-left:20px; padding:6px 12px; border:none; border-radius:6px; cursor:pointer;">
       Light Mode
    </button>

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

 
  <script src="main.js"></script>
  <script src="blues.css"></script>
</body>
</html>
