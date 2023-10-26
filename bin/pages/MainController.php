<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\DataBase;

class MainController extends BaseController
{
    public function index(): string
    {
        if (!AccountManager::isLogged()) {
            return $this->redirect('/auth');
        }
        if (AccountManager::isBanned()) {
            return $this->redirect('/banned');
        }

        return (string) $this->redirect('/user');
    }
}
