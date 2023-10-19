<?php

namespace l\pages;

use l\objects\BaseController;

class BannedController extends BaseController
{
    function index(): string
    {
        return 'ban';
    }
}
