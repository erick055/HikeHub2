<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to post a review.']);
    exit;
}

// 2. Get data from POST
$user_id = $_SESSION['user_id'];
$trail_id = $_POST['trail_id'] ?? 0;
$rating = $_POST['rating'] ?? 0;
$review_text = trim($_POST['review_text'] ?? '');

// 3. Validate data
if (empty($trail_id) || empty($rating) || empty($review_text)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill out all fields.']);
    exit;
}

// 4. Handle File Upload
$image_path = NULL;
if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] == 0) {
    $target_dir = "uploads/reviews/"; // <-- IMPORTANT: Create this folder!
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = strtolower(pathinfo($_FILES['review_image']['name'], PATHINFO_EXTENSION));
    $image_path = $target_dir . uniqid() . '.' . $file_ext;

    // Check if it's a real image
    if (getimagesize($_FILES['review_image']['tmp_name'])) {
        if (!move_uploaded_file($_FILES['review_image']['tmp_name'], $image_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
        exit;
    }
}

// 5. Insert into Database
$stmt = $conn->prepare("INSERT INTO reviews (user_id, trail_id, rating, review_text, image_path) VALUES (?, ?, ?, ?, ?)");
// We use "iiiss" which stands for integer, integer, integer, string, string
$stmt->bind_param("iiiss", $user_id, $trail_id, $rating, $review_text, $image_path);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Review posted!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
}

$stmt->close();
$conn->close();
?>