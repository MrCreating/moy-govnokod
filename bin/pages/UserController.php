<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;

class UserController extends BaseController
{
    function index(): string
    {
        if (!AccountManager::isLogged()) {
            return (string) $this->redirect('/auth');
        }
        if (AccountManager::isBanned()) {
            return (string) $this->redirect('/banned');
        }

        return $this->render('user', [
            'user' => AccountManager::getUser()
        ]);
    }

    public function logout (): string
    {
        $_SESSION = [];

        return (string) $this->redirect('/auth');
    }
}
