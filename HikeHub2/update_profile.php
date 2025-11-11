<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

// 1. Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$new_image_path = null;
$old_image_path = null;

// --- 2. HANDLE FILE UPLOAD ---
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    
    $target_dir = "uploads/profiles/"; // The folder we made in Step 0
    
    $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $new_image_path = $target_dir . "user_" . $user_id . "_" . uniqid() . '.' . $file_ext;
    
    // Validate file
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);

    if ($check !== false && in_array($file_ext, $allowed_exts)) {
        // --- Before saving new pic, get old pic path to delete it ---
        $stmt_old = $conn->prepare("SELECT profile_picture FROM users WHERE email = ?");
        $stmt_old->bind_param("s", $email);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        if ($result_old->num_rows === 1) {
            $old_image_path = $result_old->fetch_assoc()['profile_picture'];
        }
        $stmt_old->close();

        // Move the new file
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $new_image_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
            exit();
        }
        
        // --- Delete old picture if it exists and is not the default ---
        if ($old_image_path && file_exists($old_image_path)) {
            unlink($old_image_path);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, JPEG, PNG, GIF allowed.']);
        exit();
    }
}

// --- 3. GET TEXT DATA ---
$newName = trim($_POST['name'] ?? '');
$newBio = trim($_POST['bio'] ?? '');
$newLocation = trim($_POST['location'] ?? '');
$newExperience = trim($_POST['experience_level'] ?? '');
$newPhone = trim($_POST['phone_number'] ?? '');
$newEmergency = trim($_POST['emergency_contact'] ?? '');
$newTrailType = trim($_POST['favorite_trail_type'] ?? '');
$newHikeTime = trim($_POST['best_hiking_time'] ?? '');
$newCompanion = trim($_POST['companion_preference'] ?? '');

if (empty($newName)) {
    echo json_encode(['status' => 'error', 'message' => 'Name cannot be empty']);
    exit();
}

// --- 4. PREPARE DATABASE UPDATE ---
if ($new_image_path) {
    // If a new image was uploaded, update its path
    $stmt = $conn->prepare("UPDATE users SET 
        name = ?, bio = ?, location = ?, experience_level = ?, 
        phone_number = ?, emergency_contact = ?, favorite_trail_type = ?, 
        best_hiking_time = ?, companion_preference = ?, profile_picture = ?
    WHERE email = ?");
    $stmt->bind_param("sssssssssss", 
        $newName, $newBio, $newLocation, $newExperience, $newPhone, 
        $newEmergency, $newTrailType, $newHikeTime, $newCompanion, 
        $new_image_path, $email
    );
} else {
    // If no new image, update everything EXCEPT the picture path
    $stmt = $conn->prepare("UPDATE users SET 
        name = ?, bio = ?, location = ?, experience_level = ?, 
        phone_number = ?, emergency_contact = ?, favorite_trail_type = ?, 
        best_hiking_time = ?, companion_preference = ? 
    WHERE email = ?");
    $stmt->bind_param("ssssssssss", 
        $newName, $newBio, $newLocation, $newExperience, $newPhone, 
        $newEmergency, $newTrailType, $newHikeTime, $newCompanion, 
        $email
    );
}

// --- 5. EXECUTE AND RESPOND ---
if ($stmt->execute()) {
    // IMPORTANT: Update session variables
    $_SESSION['name'] = $newName;
    if ($new_image_path) {
        $_SESSION['profile_picture'] = $new_image_path;
    }
    
    // Fetch the *current* profile picture path to send back
    $final_pic_path = $_SESSION['profile_picture'] ?? 'img/default-avatar.png'; // Use default if still null

    echo json_encode([
        'status' => 'success',
        'newName' => $newName,
        'newBio' => $newBio,
        'newLocation' => $newLocation,
        'newExperience' => $newExperience,
        'newPhone' => $newPhone,
        'newEmergency' => $newEmergency,
        'newTrailType' => $newTrailType,
        'newHikeTime' => $newHikeTime,
        'newCompanion' => $newCompanion,
        'newProfilePicPath' => $final_pic_path // <-- SEND NEW PATH
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
}

$stmt->close();
$conn->close();
?>