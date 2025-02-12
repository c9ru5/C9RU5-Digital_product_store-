<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'php2_asm');
define('DB_USER', 'root');
define('DB_PASS', '');

$link = str_replace('\\', '/', dirname(__DIR__));
define('_DIR_ROOT', $link);

// Xử lý http root
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
$web_root = $protocol . $_SERVER['HTTP_HOST'];

// Xác định thư mục gốc dự án
$documentRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
$projectRoot = str_replace($documentRoot, '', _DIR_ROOT);

// Đảm bảo dấu "/" đúng
$web_root .= '/' . trim($projectRoot, '/');

define('_WEB_ROOT', rtrim($web_root, '/'));

