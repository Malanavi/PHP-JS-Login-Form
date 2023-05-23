<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: /profile');
}

include_once("./index.php"); ?>
<form>
    <div class="input-field">
        <input class="input" type="text" name="login" placeholder="Введите логин">
        <i class='bx bx-user'></i>
    </div>
    <div class="input-field">
        <input class="input" type="email" name="email" placeholder="Введите адрес своей почты">
        <i class='bx bxs-envelope'></i>
    </div>
    <div class="input-field">
        <input class="input" type="file" name="avatar">
        <i class='bx bxs-image-add'></i>
    </div>
    <div class="input-field">
        <input class="input" type="password" name="password" placeholder="Введите пароль">
        <i class='bx bx-lock-alt'></i>
    </div>
    <div class="input-field">
        <input class="input" type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <i class='bx bxs-check-square'></i>
    </div>
    <button class="register-btn submit" type="submit">Зарегистрироваться</button>
    <p>
        Есть аккаунт? <a href="/login">Авторизоваться.</a>
    </p>
    <p class="msg hidden"></p>
</form>
<script src="static/js/register_ajax.js"></script>
<?php if ($_GET["rel"] != "page") {
    echo "</div>";
} ?>
<?php include_once("./footer.php"); ?>