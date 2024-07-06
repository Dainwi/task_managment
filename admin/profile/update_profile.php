<?php
session_start();
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}
// Get user ID from session
$userId = $_SESSION['user_id'];

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$old_password = mysqli_real_escape_string($conn, $_POST['old_password']);

// Validate old password
$sql = "SELECT password FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
if (!password_verify($old_password, $user['password'])) {
    die('Incorrect old password');
}

// Hash the new password if provided
if (!empty($password)) {
    $password = password_hash($password, PASSWORD_BCRYPT);
} else {
    $password = $user['password']; // Keep old password if new one is not provided
}

// Handle profile picture upload
// $profile_picture = $user['profile_picture'];
$profile_picture = '';
if (!empty($_FILES['profile_picture']['name'])) {
    $file = $_FILES['profile_picture'];
    if ($file['size'] <= 1048576) {
        $upload_dir = '../../uploads/profile_pictures/';
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $profile_picture = $upload_dir . $userId . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $profile_picture);
    } else {
        die('Profile picture must be 1MB or less');
    }
}

// Update user data in the database
$sql = "UPDATE users SET name='$name', email='$email', password='$password', profile_picture='$profile_picture' WHERE id=$userId";
if (mysqli_query($conn, $sql)) {
    echo 'Profile updated successfully';
} else {
    echo 'Error updating profile: ' . mysqli_error($conn);
}
