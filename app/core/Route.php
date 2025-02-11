<?php
namespace App\Core;

class Route {
    function handleRoute($url) {
        global $routes;

        // Kiểm tra xem biến $routes có tồn tại và là một mảng không
        if (!isset($routes) || !is_array($routes)) {
            throw new \Exception('Biến $routes không tồn tại hoặc không phải là một mảng');
        }

        unset($routes['default_controller']);

        $url = trim($url, '/');
        if (empty($url)) {
            $url = '/';
        }

        $handleUrl = $url; 
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (preg_match('~' . $key . '~is', $url)) {
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url);
                }
            }
        }
        return $handleUrl;
    }
}