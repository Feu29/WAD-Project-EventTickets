<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel – Add Event</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>
  <header>
    <h1>🛠️ Admin Panel</h1>
  </header>

  <main>
    <form id="eventForm" enctype="multipart/form-data">
      <h2>Add New Event</h2>

      <label for="title">Event Title:</label>
      <input type="text" id="title" name="title" required />

      <label for="date">Event Date:</label>
      <input type="date" id="date" name="date" required />

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required />

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="image">Event Image:</label>
      <input type="file" id="image" name="image" accept="image/*" required />

      <button type="submit">Add Event</button>
    </form>

    <p id="statusMessage"></p>
  </main>

  <footer>
    <p>© 2025 Event Tickets – Admin Panel</p>
  </footer>

  <script src="main.js"></script>
</body>
</html>
