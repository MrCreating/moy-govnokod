<?php

/**
 * @var $err string
 */

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/sources/css/materialize.min.css">
    <script src="/sources/js/jquery.min.js"></script>
    <script src="/sources/js/materialize.min.js"></script>
    <title>Регистрация</title>
</head>
<style>
    body, html {
        background-color: #eeeeee !important;
    }
</style>
<body style="display: flex; align-items: center; justify-content: center; height: 600px">
<div style="text-align: center; padding: 30px;" class="card">
    <div><?= $err; ?></div>
    <a href="/auth"><- Назад к авторизации</a>
    <form method="post" action="/register/check">
        <div class="input-field" aria-required="true">
            <input name="login" id="login" type="text" class="validate">
            <label for="login">Login</label>
        </div>
        <div class="input-field" aria-required="true">
            <input name="password" id="password" type="password" class="validate">
            <label for="password">Password</label>
        </div>
        <div class="input-field" aria-required="true">
            <input name="repeat_password" id="repeat_password" type="password" class="validate">
            <label for="repeat_password">Repeat password</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">REGISTER
        </button>
    </form>
    <br>
</div>
</body>
</html>
