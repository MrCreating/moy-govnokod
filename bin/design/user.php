<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/sources/css/materialize.min.css">
    <script src="/sources/js/jquery.min.js"></script>
    <script src="/sources/js/materialize.min.js"></script>
    <script src="/sources/js/pages/user.js"></script>
    <title>Информация о пользователе <?= $user['login']; ?></title>
</head>
<style>
    body, html {
        background-color: #eeeeee !important;
    }
</style>
<body>
<nav>
    <div class="nav-wrapper">
        <ul class="left">
            <li>Current user is: <?= htmlspecialchars($user['login']); ?></li>
        </ul>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <?php if ($user['role'] > 0): ?>
                <li><a href="/admin">Admin panel</a></li>
            <?php endif; ?>
            <li><a href="/user/logout">Log out</a></li>
        </ul>
    </div>
</nav>
<div class="card" style="text-align: center; padding: 30px;">
    <form id="changePassword" method="post" action="/auth/changePassword">
        <div class="input-field" aria-required="true">
            <input name="old_password" id="old_password" type="password" class="validate">
            <label for="old_password">Old password</label>
        </div>
        <div class="input-field" aria-required="true">
            <input name="password" id="password" type="password" class="validate">
            <label for="password">New password</label>
        </div>
        <div class="input-field" aria-required="true">
            <input name="repeat_password" id="repeat_password" type="password" class="validate">
            <label for="repeat_password">Repeat password</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">CHANGE PASSWORD
        </button>
    </form>
</div>
</body>
</html>
