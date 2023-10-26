<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;
use l\objects\DataBase;

class AdminController extends BaseController
{
    function index(): string
    {
        if (AccountManager::permitted(1)) {
            return $this->render('admin', [
                'user' => AccountManager::getUser(),
                'users' => (new DataBase('users'))->getManyByField('user_id')
            ]);
        }

        return $this->redirect('/user');
    }
}
