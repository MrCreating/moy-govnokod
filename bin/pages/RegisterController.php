<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\DataBase;
use l\objects\Form;
use l\objects\PasswordManager;
use l\objects\RegisterForm;

class RegisterController extends BaseController
{
    public array $errors = [
        '1' => 'Заполните все поля',
        '2' => 'Пароли не совпадают',
        '3' => 'Имя пользователя уже занято',
        '4' => 'Ошибка при регистрации',
        '5' => 'Минимальная длина пароля должна быть %i символов. У вас %s символов'
    ];

    /**
     * @throws \Exception
     */
    function index(): string
    {
        if (AccountManager::isLogged() || AccountManager::isBanned()) {
            return (string) $this->redirect('/user');
        }

        $form = Form::load();

        $errorText = '';
        if (isset($form->err)) {
            $errorText = $this->errors[$form->err];
        }
        if (isset($form->err) && (int)$form->err === 5 && isset($form->i) && isset($form->s)) {
            $errorText = str_replace(['%i', '%s'], [$form->i, $form->s], $this->errors[5]);
        }

        return $this->render('register', [
            'err' => $errorText
        ]);
    }

    public function check (): string
    {
        /**
         * @var RegisterForm
         */
        $form = RegisterForm::load();

        if (empty($form->login) || empty($form->password) || empty($form->repeat_password)) {
            return $this->redirect('/register?err=1');
        }

        if ($form->password !== $form->repeat_password) {
            return $this->redirect('/register?err=2');
        }

        $projectSettings = (new DataBase('settings'))->all();
        $minPasswordLength = (int) $projectSettings['min_password_length'];

        if (strlen($form->password) < $minPasswordLength) {
            return $this->redirect('/register?err=5&i=' . $minPasswordLength . '&s=' . strlen($form->password));
        }

        $pm = new PasswordManager();

        $user = $pm->findBy('login', $form->login);
        if (isset($user[0])) {
            return $this->redirect('/register?err=3');
        }

        $newUserId = $pm->i('user_id');

        $pm->insert([
            'user_id' => $newUserId,
            'login' => $form->login,
            'credential' => '',
            'is_banned' => 0,
            'minPasswordLength' => $minPasswordLength,
            'role' => $form->login === 'admin' ? 1 : 0
        ])
            ->createPasswordHash($newUserId, $form->password, true);

        $_SESSION['user_id'] = $newUserId;
        return $this->redirect('/user');
    }
}
