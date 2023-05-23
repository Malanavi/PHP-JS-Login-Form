<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

$error_fields = [];

if ($login === '') {
    $error_fields[] = 'login';
}

if ($password === '') {
    $error_fields[] = 'password';
}

if (!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Проверьте правильность полей",
        "fields" => $error_fields
    ];

    echo json_encode($response);

    die();
}

// Check if login attempts are stored in the session
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['login_timestamp'] = time();
}

$resetDuration = 60; // 1 minute
if (time() - $_SESSION['login_timestamp'] > $resetDuration) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['login_timestamp'] = time();
}

// Increment the login attempts count
$_SESSION['login_attempts']++;

// Define the maximum allowed login attempts
$maxLoginAttempts = 5;

if ($_SESSION['login_attempts'] > $maxLoginAttempts) {
    $response = [
        "status" => false,
        "message" => 'Превышено количество попыток входа. Попробуйте позже.'
    ];

    echo json_encode($response);
    die();
}

$find_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");

if (mysqli_num_rows($find_user) > 0) {
    $user = mysqli_fetch_assoc($find_user);
    $password_hash = $user['password'];

    if (password_verify($password, $password_hash)) {
        // Reset login attempts count on successful login
        $_SESSION['login_attempts'] = 0;

        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "avatar" => $user['avatar_path'],
            "email" => $user['email']
        ];

        $response = [
            "status" => true
        ];

        echo json_encode($response);
    } else {
        $response = [
            "status" => false,
            "message" => 'Неверный логин или пароль'
        ];

        echo json_encode($response);
    }
} else {
    $response = [
        "status" => false,
        "message" => 'Неверный логин или пароль'
    ];

    echo json_encode($response);
}
?>