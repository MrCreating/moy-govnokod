<?php

namespace l\pages;

use l\objects\BaseController;

class BannedController extends BaseController
{
    function index(): string
    {
        return 'Your current user is banned.';
    }
}
