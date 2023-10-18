<?php

namespace l\pages;

use l\objects\BaseController;
use l\objects\DataBase;

class MainController extends BaseController
{
    function index(): string
    {
        $db = new DataBase('users');

        $db->deleteByField(['user_id' => 1]);
    }
}
