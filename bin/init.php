<?php

namespace l;

session_start();

spl_autoload_register(function ($namespace) {
    $path = explode('\\', $namespace);

    unset($path[0]);

    require_once __DIR__ . '/' . implode('/', $path) . '.php';
});

?>
