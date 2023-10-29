<?php

/**
 * @var array $editUser
 * @var array $user
 */

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/sources/css/materialize.min.css">
    <script src="/sources/js/jquery.min.js"></script>
    <script src="/sources/js/materialize.min.js"></script>
    <script src="/sources/js/pages/adminEdit.js"></script>
    <title>Редактирование пользователя: <?= $editUser['login']; ?></title>
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
            <li>Edit user info: <?= htmlspecialchars($editUser['login']); ?></li>
        </ul>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/admin#users">Back to users list</a></li>
            <li><a href="/user/logout">Log out</a></li>
        </ul>
    </div>
</nav>
<br>
<div>
    <div class="card" style="padding: 20px; margin-top: 0">
        <form id="updateUserInfo" method="post" action="/admin/updateUserInfo?user_id=<?= $editUser['user_id']; ?>">
            <div>
                <div><b>User role</b></div>
                <div class="input-field" aria-required="true">
                    <input value="<?= $editUser['role']; ?>" name="user_role" id="user_role" type="text" class="validate">
                    <label for="user_role">User role</label>
                </div>
                <p>
                    <label>
                        <input id="isBanned" type="checkbox" class="filled-in" <?= (int)$editUser['is_banned'] === 1 ? 'checked="checked"' : ''; ?> name="isBanned" />
                        <span>User is blocked</span>
                    </label>
                </p>
            </div>
            <br>
            <div>
                <div><b>User password</b></div>
                <div class="input-field" aria-required="true">
                    <input value="<?= $editUser['minPasswordLength']; ?>" name="min_password_length" id="min_password_length" type="number" class="validate">
                    <label for="min_password_length">Min password length</label>
                </div>
                <div class="input-field">
                    <input name="new_password" id="new_password" type="password" class="validate">
                    <label for="new_password">New password</label>
                </div>
                <div class="input-field">
                    <input name="repeat_password" id="repeat_password" type="password" class="validate">
                    <label for="repeat_password">Repeat password</label>
                </div>
            </div>

            <button type="submit" id="saveUser" class="btn">Save</button>
            <button class="btn red" id="deleteUser">Delete user</button>
        </form>
    </div>
</div>
</body>
</html>
