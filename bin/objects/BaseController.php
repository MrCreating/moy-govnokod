<?php

namespace l\objects;

/**
 * Base controller class
 */

abstract class BaseController extends BaseObject
{
    protected string $url = '';

    abstract function index (): string;

    /**
     * @return bool
     */
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

    /**
     * @param string $path
     * @param array $params
     * @return string
     */
    public function render (string $path, array $params = []): string
    {
        $filePath = __DIR__ . '/../design/' . $path . '.php';

        if (!file_exists($filePath)) {
            return '';
        }

        ob_start();
        extract($params);
        require $filePath;
        return ob_get_clean();
    }

    /**
     * @param string $path
     * @param array $params
     * @return bool
     */
    public function show (string $path, array $params = []): bool
    {
        echo $this->render($path, $params);
        return true;
    }
}
