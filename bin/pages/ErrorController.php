<?php

namespace l\pages;

use l\objects\BaseController;

class ErrorController extends BaseController
{
    /**
     * @return bool
     */
    function index(): bool
    {
        return '';
    }

    /**
     * @return string
     */
    public function e404 (): string
    {
        return '<b>Requested page not found</b>';
    }
}
