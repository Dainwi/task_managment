<?php
include "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $rememberMe = isset($_POST['rememberMe']) ? $_POST['rememberMe'] : false;

    // check first where email is in the database or not
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // email found, now check password
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row["password"];
        if (password_verify($password, $hashed_password)) {
            // password is correct, login successful
            session_start();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
            $userId = $row["id"];

            if ($rememberMe) {
                $token = bin2hex(random_bytes(16));
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days

                setcookie('remember_me', $token, $expiry, "/", "", false, true);

                $expiryDate = date('Y-m-d H:i:s', $expiry);
                $sql = "INSERT INTO user_tokens (user_id, token, expires_at) VALUES ('$userId', '$token', '$expiryDate')";
                mysqli_query($conn, $sql);
            }
            echo "success";
            exit();
        } else {
            echo "InvalidPassword";
            exit();
        }
    }else{
        echo "InvalidEmail";
        exit();
    }

}
