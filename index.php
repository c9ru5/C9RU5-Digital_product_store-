<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/config/routes.php';
require_once __DIR__ . '/config/config.php';
session_start();

spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
    $relativePath = str_replace(['App\\', '\\'], ['', DIRECTORY_SEPARATOR], $class) . '.php';
    $path = $baseDir . $relativePath;

    if (!file_exists($path)) {
        die("Autoload Error: File not found at $path");
    }

    require_once $path;
});


// Khởi tạo ứng dụng
use App\Core\App;
$app = new App();


