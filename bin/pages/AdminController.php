<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\DataBase;
use l\objects\Form;

class AdminController extends BaseController
{
    private array $errors = [
        '-1' => 'У Вас нет прав доступа к разделу',
        '-2' => 'Минимальная длина пароля не должна быть отрицательной'
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
}
