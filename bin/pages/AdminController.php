<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\DataBase;
use l\objects\Form;
use l\objects\PasswordManager;

class AdminController extends BaseController
{
    private array $errors = [
        '-1' => 'У Вас нет прав доступа к разделу',
        '-2' => 'Минимальная длина пароля не должна быть отрицательной',
        '-3' => 'Не указан пользователь для редактирования',
        '-4' => 'Не указана роль пользователя',
        '-5' => 'Не указана минимальная длина пароля для пользователя',
        '-6' => 'В пароле должен быть хотя бы 1 символ'
    ];

    function index(): string
    {
        if (AccountManager::permitted(1)) {
            return $this->render('admin', [
                'user' => AccountManager::getUser(),
                'users' => (new DataBase('users'))->getManyByField('user_id'),
                'project_settings' => (new DataBase('settings'))->all()
            ]);
        }

        return $this->redirect('/user');
    }

    /**
     * @throws \Exception
     */
    public function saveProjectSettings (): string
    {
        if (!AccountManager::permitted(1)) {
            return $this->json(['error' => $this->errors['-1']]);
        }

        $settings = (new DataBase('settings'));

        $newSettings = Form::load();
        $newPasswordLength = empty($newSettings->min_password_length) ? 0 : (int) $newSettings->min_password_length;

        if ($newPasswordLength <= 0) {
            return $this->json(['error' => $this->errors['-2']]);
        }

        $settings->all('min_password_length', $newPasswordLength);
        return $this->json(['ok' => 1]);
    }

    /**
     * @throws \Exception
     */
    public function edit (): string
    {
        if (!AccountManager::permitted(1)) {
            return $this->redirect('/user');
        }

        $userInfo = Form::load();
        if (empty($userInfo->user_id)) {
            return $this->redirect('/admin');
        }

        $userId = (int) $userInfo->user_id;
        $user = AccountManager::getUser($userId);

        return $this->render('adminEdit', [
            'user' => AccountManager::getUser(),
            'editUser' => $user
        ]);
    }

    /**
     * @throws \Exception
     */
    public function updateUserInfo (): string
    {
        if (!AccountManager::permitted(1)) {
            return $this->json(['error' => $this->errors['-1']]);
        }

        $newUserSettings = Form::load();

        if (empty($newUserSettings->user_id)) {
            return $this->json(['error' => $this->errors['-3']]);
        }

        $pm = new PasswordManager();
        $user = AccountManager::getUser($newUserSettings->user_id);
        if (!empty($newUserSettings->user_delete)) {
            $pm->deleteByField([
                'user_id' => $user['user_id']
            ]);
            return $this->json(['ok' => 1]);
        }

        $userRole = empty($newUserSettings->user_role) || $newUserSettings->user_role < 0 ? 0 : $newUserSettings->user_role;
        if ($userRole >= 1) {
            $userRole = 1;
        }

        if (empty($newUserSettings->min_password_length)) {
            return $this->json(['error' => $this->errors['-5']]);
        }

        if ((int)$newUserSettings->min_password_length <= 1) {
            return $this->json(['error' => $this->errors['-6']]);
        }

        $pm->updateItemBy('minPasswordLength', $newUserSettings->min_password_length, [
            'user_id' => $user['user_id']
        ])->updateItemBy('role', $userRole, [
            'user_id' => $user['user_id']
        ]);

        if (!empty($newUserSettings->new_password)) {
            $pm->createPasswordHash($user['user_id'], $newUserSettings->new_password, true);
        }

        return $this->json(['ok' => 1]);
    }
}
