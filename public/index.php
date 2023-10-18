<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../bin/init.php';

\l\objects\Core::init()->run(function (\l\objects\Core $core) {
    return $core->loadController()->enter();
});
?>
