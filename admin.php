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
    .delete-btn {
      background: #e63946;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
    }
    .delete-btn:hover {
      background: #c1121f;
    }
  </style>
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <h1>🎟️ Event Management - Admin Dashboard</h1>
    <div class="clock-container">
      <div id="clock"></div>
    </div>
  </header>

  <!-- MAIN DASHBOARD -->
  <div class="dashboard">

    <!-- LEFT: EVENT FORM -->
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
    $id = $row['id'];
    echo "<tr id='event-$id'>";
    echo "<td>" . $id . "</td>";
    echo "<td><img src='" . $row['image_path'] . "' alt='Event Image' width='80'></td>";
    echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
    echo "<td>
            <button class='delete-btn' data-id='$id'>🗑 Delete</button>
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

  <!-- CLOCK SCRIPT -->
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
  </script>
</body>
</html>

<?php $conn->close(); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const eventId = this.getAttribute('data-id');
            if (!confirm('Are you sure you want to delete this event?')) return;

            fetch('delete_event.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'event_id=' + encodeURIComponent(eventId)
            })
            .then(response => response.text())
            .then(message => {
                alert(message);
                if (message.includes('successfully')) {
                    const row = document.getElementById('event-' + eventId);
                    if (row) row.remove();
                }
            })
            .catch(err => alert('Error deleting event.'));
        });
    });
});
</script>

