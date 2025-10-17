<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_database";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_name = $_POST['event_name'] ?? '';
    $event_date = $_POST['event_date'] ?? '';
    $description = $_POST['description'] ?? '';

    // Check if an image was uploaded
    echo "<pre>";
print_r($_FILES);
echo "</pre>";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . time() . "_" . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            die("Error: File is not an image.");
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO events (event_name, event_date, description, image_path)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $event_name, $event_date, $description, $target_file);

            if ($stmt->execute()) {
                echo "<script>alert('✅ Event added successfully!'); window.location.href='admin.html';</script>";
            } else {
                echo "❌ Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "❌ Failed to move uploaded image.";
        }
    } else {
        echo "⚠️ No image uploaded or upload error: " . ($_FILES['image']['error'] ?? 'No file field found.');
    }
}

$conn->close();
?>
