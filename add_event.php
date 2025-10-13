<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// ✅ MySQL connection for XAMPP
$servername = "localhost"; // default for XAMPP
$username = "root";        // default XAMPP user
$password = "";            // default XAMPP password is empty
$dbname = "event_db";      // replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// ✅ Get POST data safely
$title = isset($_POST['title']) ? $_POST['title'] : '';
$event_date = isset($_POST['date']) ? $_POST['date'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';

// Validate required fields
if (empty($title) || empty($event_date) || empty($location) || empty($description)) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);
    exit;
}

// ✅ Handle image upload
$imagePath = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
    $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to upload image."
        ]);
        exit;
    }
}

// ✅ Insert event into database
$sql = "INSERT INTO events (title, event_date, location, description, image)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $title, $event_date, $location, $description, $imagePath);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Event added successfully!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
