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
<br>
<div>
    <div>
        <ul class="tabs card">
            <li class="tab col s3"><a class="active" href="#profileItem">Profile info</a></li>
            <li class="tab col s3"><a href="#changePasswordItem">Change password</a></li>
        </ul>
    </div>
    <div id="profileItem">
        <div class="card" style="text-align: center; padding: 30px; margin-top: 0">
            <div class="valign-wrapper">
                <img class="circle" height="64" width="64" style="background-color: gray">
                <div style="margin-left: 20px"><?= htmlspecialchars($user['login']); ?></div>
            </div>
        </div>
    </div>
    <div id="changePasswordItem">
        <div class="card" style="text-align: center; padding: 30px; margin-top: 0">
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
    </div>
</div>
</body>
</html>
