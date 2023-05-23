<?php

ini_set("error_reporting", 1);
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Cache-Control: pre-check=0, post-check=0", false);
header("Pragma: no-cache");

$isAuthorized = isset($_SESSION["user"]);

if ($_GET["rel"] != "page") {
    // Redirect to the login page if the user is not authorized and not already on the login page or register page
    if (!$isAuthorized && (basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'register.php')) {
        header("Location: login"); // Redirect to the login page
        exit();
    }

    if ($isAuthorized && basename($_SERVER['PHP_SELF']) !== 'profile.php') {
        header("Location: profile"); // Redirect to the login page
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Авторизация PHP/JS</title>
        <link rel="stylesheet" href="static/css/style.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>
        <div class="content" id="load">
        <?php } ?>