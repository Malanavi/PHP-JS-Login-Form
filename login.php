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
        <input class="input" type="password" name="password" placeholder="Введите пароль">
        <i class='bx bx-lock-alt'></i>
    </div>
    <div class="input-field">
        <button class="login-btn submit" type="submit">Войти</button>
    </div>
    <p>
        Нет аккаунта? <a href="/register">Зарегистрироваться.</a>
    </p>
    <p class="msg hidden"></p>
</form>
<script src="static/js/login_ajax.js"></script>
<?php if ($_GET["rel"] != "page") {
    echo "</div>";
} ?>
<?php include_once("./footer.php"); ?>