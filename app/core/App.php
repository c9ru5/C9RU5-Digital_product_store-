<?php
namespace App\Core;

class App {

    private $__controller, $__action, $__params, $__routes;

    function __construct() {
        global $routes;

        $this->__routes = new Route();

        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }
        
        $this->__action = 'index';
        $this->__params = [];

        $this->handleUrl();
    }

    function getUrl() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
            // Loại bỏ query string nếu có
            $url = strtok($url, '?');
            
            // Lấy thư mục gốc chuẩn hóa
            $scriptName = realpath(dirname($_SERVER['SCRIPT_NAME']));
            $url = str_replace($scriptName, '', $url);  // Loại bỏ thư mục gốc chuẩn hóa
            
            // Tách đường dẫn thành mảng và xử lý
            $urlParts = explode('/', trim($url, '/'));
            
            // Loại bỏ thư mục đầu tiên nếu cần
            array_shift($urlParts);
            
            // Nối lại các phần còn lại thành URL mới
            $url = '/' . implode('/', $urlParts);
    
        } else {
            $url = '/';
        }
        return $url;
    }
    
    
    public function handleUrl() {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);

        $urlCheck = '';
        if (!empty($urlArr)) {
            foreach ($urlArr as $key => $item) {
                $urlCheck .= $item . '/';
                $fileCheck = rtrim($urlCheck, '/');
                $fileArr = explode('/', $fileCheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                $fileCheck = implode('/', $fileArr);
                
                if (!empty($urlArr[$key - 1])) {
                    unset($urlArr[$key - 1]);
                }
                if (file_exists(_DIR_ROOT . '/app/controllers/' . $fileCheck . '.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }
            $urlArr = array_values($urlArr);
        }

        // Xử lý controller
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        // Xử lý khi $urlCheck rỗng
        if (empty($urlCheck)) {
            $urlCheck = $this->__controller;
        }

        $controllerPath = _DIR_ROOT . '/app/controllers/' . $urlCheck . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;

            // Kiểm tra class controller có tồn tại không
            $controllerClass = 'App\\Controllers\\' . $this->__controller;
            if (class_exists($controllerClass)) {
                $this->__controller = new $controllerClass;
                unset($urlArr[0]);
            } else {
                echo 'Controller không tồn tại' . $controllerClass;
                $this->loadError();
                return;
            }
        } else {
            echo 'File controller không tồn tại' . $controllerPath;
            $this->loadError();
            return;
        }

        // Xử lý action
        if (!empty($urlArr[1])) {
            $this->__action = $urlArr[1];
            unset($urlArr[1]);
        }

        // Xử lý params
        $this->__params = array_values($urlArr);

        // Kiểm tra action có tồn tại trong controller không
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            echo 'Action không tồn tại' . $this->__action;
            $this->loadError();
        }
    }

    public function loadError($name = '404') {
        require_once _DIR_ROOT . '/app/errors/' . $name . '.php';
    }
}