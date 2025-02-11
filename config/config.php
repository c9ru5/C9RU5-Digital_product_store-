<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'php2_asm');
define('DB_USER', 'root');
define('DB_PASS', '');

$link = str_replace('\\', '/', dirname(__DIR__));
define('_DIR_ROOT', $link);
//Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}
$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
$web_root .= $folder;
define('_WEB_ROOT', $web_root);
