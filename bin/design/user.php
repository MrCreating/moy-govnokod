<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/sources/css/materialize.min.css">
    <script src="/sources/js/materialize.min.js"></script>
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
</body>
</html>
