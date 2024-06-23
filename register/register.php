<?php
include "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        echo "empty";
        exit;
    }

    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        echo "email";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {
        echo "failed";
    }
}