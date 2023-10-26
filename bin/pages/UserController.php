<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;

class UserController extends BaseController
{
    function index(): string
    {
        if (!AccountManager::isLogged()) {
            return $this->redirect('/auth');
        }
        if (AccountManager::isBanned()) {
            return $this->redirect('/banned');
        }

        return $this->render('user', [
            'user' => AccountManager::getUser()
        ]);
    }

    public function logout (): string
    {
        AccountManager::logout();

        return $this->redirect('/auth');
    }
}
