<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /login');
}

include_once("./index.php"); ?>
<form>
    <img class="user__avatar" src="<?= $_SESSION['user']['avatar'] ?>" width="200" alt="">
    <h2 class="user__name" style="margin: 10px 0;">
        <?= $_SESSION['user']['login'] ?>
    </h2>
    <p class="user__email">
        <?= $_SESSION['user']['email'] ?>
    </p>
    <a class="user__logout-btn" href="vendor/logout">Выход</a>
</form>
<div class="animation-block hidden"></div>
<?php if ($_GET["rel"] != "page") {
    echo "</div>";
} ?>
<?php include_once("./footer.php"); ?>