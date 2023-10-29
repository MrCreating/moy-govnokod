<?php

/**
 * @var array $user
 * @var array $users
 * @var array $project_settings
 */

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/sources/css/materialize.min.css">
    <script src="/sources/js/jquery.min.js"></script>
    <script src="/sources/js/materialize.min.js"></script>
    <script src="/sources/js/pages/admin.js"></script>
    <title>Админ-панель</title>
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
            <li>Current user is: <?= htmlspecialchars($user['login']); ?> (IN ADMIN MODE)</li>
        </ul>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/user">Go back</a></li>
            <li><a href="/user/logout">Log out</a></li>
        </ul>
    </div>
</nav>
<br>
<div>
    <div>
        <ul class="tabs card">
            <li class="tab col s3"><a class="active" href="#users">Users list</a></li>
            <li class="tab col s3"><a href="#projectSettings">Project Settings</a></li>
        </ul>
    </div>
    <div id="users">
        <div class="card" style="margin-top: 0px;">
            <table class="highlight">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user_item): ?>
                    <tr>
                        <td><?= htmlspecialchars($user_item['user_id']); ?></td>
                        <td><?= htmlspecialchars($user_item['login']); ?></td>
                        <td><?= $user_item['role'] <= 0 ? 'USER' : 'ADMIN'; ?></td>
                        <td>
                            <?php if (\l\objects\AccountManager::getUserId() === (int)$user_item['user_id']): ?>
                                <div>Current user is uneditable</div>
                            <?php else: ?>
                                <a href="/admin/edit?user_id=<?= $user_item['user_id']; ?>">Edit</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="projectSettings">
        <div class="card" style="padding: 20px; margin-top: 0">
            <div><b>Project settings</b></div>
            <form id="saveProjectSettings" method="post" action="/admin/saveProjectSettings">
                <div class="input-field" aria-required="true">
                    <input value="<?= $project_settings['min_password_length']; ?>" name="min_password_length" id="min_password_length" type="text" class="validate">
                    <label for="min_password_length">Minimal password length</label>
                </div>
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
