<?php
include_once('config/config.php');

// Start the session
session_start();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
    header("Location: " . BASE_URL . '/admin/dashboard');
} else {
    header("Location: " . BASE_URL . '/login');
}
exit();

