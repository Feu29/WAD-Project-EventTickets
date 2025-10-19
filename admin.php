<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_database"; 
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['delete_event'])) {
  $event_id = intval($_POST['event_id']);

  // Delete image file first 
  $getImage = $conn->prepare("SELECT image_path FROM events WHERE id = ?");
  $getImage->bind_param("i", $event_id);
  $getImage->execute();
  $getImage->bind_result($image_path);
  if ($getImage->fetch() && file_exists($image_path)) {
    unlink($image_path);
  }
  $getImage->close();

  // Delete event record from database
  $delete = $conn->prepare("DELETE FROM events WHERE id = ?");
  $delete->bind_param("i", $event_id);
  $delete->execute();
  $delete->close();

  echo "<script>alert('Event deleted successfully.'); window.location='admin.php';</script>";
  exit;
}

// Fetch events from database
$sql = "SELECT * FROM events ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Event Management</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    /* Simple styling for delete button */
    .delete-btn {
      background: #e60000;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: background 0.2s ease;
    }

    .delete-btn:hover {
      background: #ff3333;
    }

    table img {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Event Management - Admin Panel</h1>
    <div class="clock-container">
      <div id="clock"></div>
    </div>
  </div>

  <div class="dashboard">
    <!-- LEFT: ADD NEW EVENT -->
    <div class="form-section">
      <h2>Add New Event</h2>
      <form action="addevent.php" method="POST" enctype="multipart/form-data">
        <label>Event Name</label>
        <input type="text" name="event_name" required>

        <label>Event Date</label>
        <input type="date" name="event_date" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Event Image</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Event</button>
      </form>
    </div>

    <!-- RIGHT: EVENT TABLE -->
    <div class="table-section">
      <h2>All Events</h2>
      <table id="eventsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Event Name</th>
            <th>Date</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td><img src='" . htmlspecialchars($row['image_path']) . "' alt='Event Image'></td>";
              echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
              echo "<td>" . htmlspecialchars($row['description']) . "</td>";
              echo "<td>
                      <form method='POST' style='display:inline;' onsubmit='return confirmDelete();'>
                        <input type='hidden' name='event_id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete_event' class='delete-btn'>Delete</button>
                      </form>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No events found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- CLOCK + DELETE CONFIRMATION -->
  <script>
    function updateClock() {
      const clock = document.getElementById("clock");
      const now = new Date();
      const hours = now.getHours().toString().padStart(2, '0');
      const minutes = now.getMinutes().toString().padStart(2, '0');
      const seconds = now.getSeconds().toString().padStart(2, '0');
      clock.textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    function confirmDelete() {
      return confirm("Are you sure you want to delete this event?");
    }
  </script>
</body>
</html>

<?php $conn->close(); ?>
