<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;

class BannedController extends BaseController
{
    function index(): string
    {
        if (!AccountManager::isBanned()) {
            return $this->redirect('/');
        }

        return 'Your current user is banned. You can <a href="/user/logout">logout.</a>';
    }
}
