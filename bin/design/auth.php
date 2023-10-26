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
        <title>Авторизация</title>
    </head>
    <style>
        body, html {
            background-color: #eeeeee !important;
        }
    </style>
    <body style="display: flex; align-items: center; justify-content: center; height: 600px">
        <div style="text-align: center; padding: 30px;" class="card">
            <div><?= $err; ?></div>
            <form method="post" action="/auth/check">
                <div class="input-field" aria-required="true">
                    <input name="login" id="login" type="text" class="validate">
                    <label for="login">Login</label>
                </div>
                <div class="input-field" aria-required="true">
                    <input name="password" id="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">LOG IN
                </button>
            </form>
            <br>
            <a href="/register">Регистрация</a>
        </div>
    </body>
</html>
