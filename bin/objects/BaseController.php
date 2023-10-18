<?php

namespace l\objects;

/**
 * Base controller class
 */

abstract class BaseController extends BaseObject
{
    protected string $url = '';

    private array $js = [];
    private array $css = [];

    private string $title = '';

    abstract function index (): bool;

    public function enter (): bool
    {
        $link = explode('/', $this->url);

        $actionName = isset($link[2]) ? strtolower($link[2]) : 'index';

        if (!method_exists($this, $actionName)) {
            return false;
        }

        $result = call_user_func([$this, $actionName]);

        if (is_string($result)) {
            echo $result;
        }
        return true;
    }
}
