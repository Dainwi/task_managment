<?php
include_once('config/config.php');
include_once('config/constant.php');

// Start the session
session_start();

// Function to redirect to a specific URL
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Check if user is not logged in and remember me cookie is set
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    // Sanitize the token
    $token = mysqli_real_escape_string($conn, $_COOKIE['remember_me']);

    // Query to find user_id and name from the token
    $sql = "SELECT user_id, name FROM user_tokens WHERE token = '$token' AND expires_at > NOW()";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $name = $row['name'];

        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);

        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;

        // Redirect to admin
        redirect(BASE_URL . '/admin');
    } else {
        // Invalid or expired token, clear the cookie
        setcookie('remember_me', '', time() - 3600, "/", "", false, true);
        redirect(BASE_URL . '/login');
    }
} elseif (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to admin
    redirect(BASE_URL . '/admin');
} else {
    // User is not logged in, redirect to login page
    redirect(BASE_URL . '/login');
}

// Include the rest of your index.php content here, if needed
?>
