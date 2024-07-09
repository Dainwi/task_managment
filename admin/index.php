<?php
session_start();
include "../config/config.php";
include "../config/constant.php";

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    $sql = "SELECT * FROM user_tokens WHERE token = '$token' AND expires_at > NOW()";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // $sql1 = "SELECT * FROM users WHERE id = " .$row['user_id'];
        // $result1 = mysqli_query($conn, $sql1);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        header("Location: ".BASE_URL.'/admin/dashboard');
    } else {
        // Invalid or expired token, clear the cookie
        setcookie('remember_me', '', time() - 3600, "/", "", false, true);
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ".BASE_URL);
    exit;
}

