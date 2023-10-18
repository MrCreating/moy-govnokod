<?php

namespace l\objects;

/**
 * Core class site
 */

class Core extends BaseObject
{
    /**
     * @var Core
     */
    static Core $currentApplication;

    /**
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public static function init (array $params = []): Core
    {
        if (!isset(self::$currentApplication)) {
            self::$currentApplication = new static($params);
        }

        return self::$currentApplication;
    }

    /**
     * @param callable $session
     * @return void
     */
    public function run (callable $session): void
    {
        $result = call_user_func($session, $this);

        if (!$result) {
            throw new \Exception('Failed to resolve application!');
        }
    }

    public function loadController (?string $url = NULL): BaseController
    {
        $url = explode('?', is_null($url) ? $_SERVER['REQUEST_URI'] : $url);
        $link = explode('/', $url[0]);

        $controllerName = ucfirst((!isset($link[1]) || empty($link[1])) ? 'main' : strtolower($link[1]));

        try {
            if (!file_exists(__DIR__ . '/../pages/' . $controllerName . 'Controller.php')) {
                throw new \Exception('Class not found!');
            }

            require_once __DIR__ . '/../pages/' . $controllerName . 'Controller.php';

            $className = ("\\l\\pages\\" . $controllerName . 'Controller');

            if (!class_exists($className)) {
                throw new \Exception('Class not found!');
            }

            return new $className([
                'url' => $url[0]
            ]);
        } catch (\Exception $e) {
            return $this->loadController('/error/e404');
        }
    }
}

?>
