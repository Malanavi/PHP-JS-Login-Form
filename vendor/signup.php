<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
if (mysqli_num_rows($check_login) > 0) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Такой логин уже существует",
        "fields" => ['login']
    ];

    echo json_encode($response);
    die();
}

$error_fields = [];

if (empty($login)) {
    $error_fields[] = 'login';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_fields[] = 'email';
}

if (empty($password)) {
    $error_fields[] = 'password';
}

if (empty($password_confirm)) {
    $error_fields[] = 'password_confirm';
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

if ($password === $password_confirm) {

    $path = '';

    if (!empty($_FILES['avatar']['name'])) {
        $path = 'uploads/' . time() . $_FILES['avatar']['name'];

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
            $response = [
                "status" => false,
                "type" => 2,
                "message" => "Ошибка загрузки изображения."
            ];
        
            echo json_encode($response);
        }
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($connect, 
        "INSERT INTO `users` (`id`, `login`, `email`, `password`, `avatar_path`) 
        VALUES (NULL, '$login', '$email', '$password', '$path')"
    );

    $response = [
        "status" => true,
        "message" => "Регистрация прошла успешно!"
    ];

    echo json_encode($response);

} else {
    $response = [
        "status" => false,
        "type" => 3,
        "message" => "Пароли не совпадают."
    ];

    echo json_encode($response);
}
?>