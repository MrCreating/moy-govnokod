<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\DataBase;
use l\objects\Form;
use l\objects\LoginForm;
use l\objects\PasswordManager;

class AuthController extends BaseController
{
    public array $errors = [
        '1' => 'Заполните все поля',
        '2' => 'Неверный логин или пароль',
        '3' => 'Пароли не совпадают',
        '4' => 'Старый пароль некорректен',
        '5' => 'Минимальная длина пароля должна быть %i символов. У вас %s символов'
    ];

    /**
     * @throws \Exception
     */
    public function index(): string
    {
        if (AccountManager::isLogged() || AccountManager::isBanned()) {
            return $this->redirect('/user');
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
            return $this->redirect('/auth?err=1');
        }

        $result = AccountManager::auth($form->login, $form->password);
        if ($result) {
            return $this->redirect('/user');
        }

        return $this->redirect('/auth?err=2');
    }

    /**
     * @throws \Exception
     */
    public function changePassword (): string
    {
        $form = Form::load();

        if (empty($form->old_password) || empty($form->password) || empty($form->repeat_password)) {
            return $this->json(['error' => $this->errors['1']]);
        }

        if ($form->password !== $form->repeat_password) {
            return $this->json(['error' => $this->errors['3']]);
        }

        if (PasswordManager::load()->isPasswordCorrect(AccountManager::getUserId(), $form->old_password)) {
            $user = AccountManager::getUser();
            $minPasswordLength = (int) $user['minPasswordLength'];

            if (($passwordLength = strlen($form->password)) < $minPasswordLength) {
                $errorText = str_replace(['%i', '%s'], [$minPasswordLength, $passwordLength], $this->errors['5']);
                return $this->json(['error' => $errorText]);
            }

            return $this->json([
                'ok' => PasswordManager::load()
                                ->createPasswordHash(AccountManager::getUserId(), $form->password, true)
            ]);
        } else {
            return $this->json(['error' => $this->errors['4']]);
        }
    }
}
