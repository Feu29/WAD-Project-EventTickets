<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

if (isset($_GET["id"])) {
  $id = intval($_GET["id"]);

  // Get image path first to delete the file
  $sql = "SELECT image_path FROM events WHERE id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if ($row && file_exists($row["image_path"])) {
    unlink($row["image_path"]);
  }

  // Delete event
  $deleteSQL = "DELETE FROM events WHERE id = $id";
  if ($conn->query($deleteSQL)) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false]);
  }
} else {
  echo json_encode(["success" => false, "message" => "No ID provided."]);
}

$conn->close();
?>
