<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\Form;
use l\objects\LoginForm;

class AuthController extends BaseController
{
    public array $errors = [
        '1' => 'Заполните все поля',
        '2' => 'Неверный логин или пароль'
    ];

    /**
     * @throws \Exception
     */
    public function index(): string
    {
        if (AccountManager::isLogged() || AccountManager::isBanned()) {
            return (string) $this->redirect('/user');
        }

        $form = Form::load();

        return $this->render('auth', [
            'err' => isset($form->err) ? $this->errors[$form->err] : ''
        ]);
    }

    /**
     * @throws \Exception
     */
    public function check (): string
    {
        /**
         * @var LoginForm
         */
        $form = LoginForm::load();

        if (empty($form->login) || empty($form->password)) {
            return (string) $this->redirect('/auth?err=1');
        }

        $result = AccountManager::auth($form->login, $form->password);
        if ($result) {
            return (string) $this->redirect('/user');
        }

        return (string) $this->redirect('/auth?err=2');
    }
}
