<?php
include_once('config/config.php');

// Start the session
session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    $sql = "SELECT user_id FROM user_tokens WHERE token = '$token' AND expires_at > NOW()";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: " . BASE_URL . '/admin');
    } else {
        // Invalid or expired token, clear the cookie
        setcookie('remember_me', '', time() - 3600, "/", "", false, true);
    }
} else {
    header("Location: " . BASE_URL . '/login');
}
exit();

