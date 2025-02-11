<?php
session_start();
spl_autoload_register(function($class) {
    $baseDir = __DIR__ . '/app/';
    $path = $baseDir . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});
require_once __DIR__ . '/config/routes.php';
require_once __DIR__ . '/config/config.php';
use App\Core\App;
$app = new App();



