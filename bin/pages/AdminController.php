<?php

namespace l\pages;

use l\objects\AccountManager;
use l\objects\BaseController;

class AdminController extends BaseController
{
    function index(): string
    {
        if (AccountManager::permitted(1)) {
        }

        return $this->redirect('/user');
    }
}
