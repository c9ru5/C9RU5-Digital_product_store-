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
            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            $scriptName = str_replace('\\', '/', $scriptName); // Chuẩn hóa đường dẫn
            $url = str_replace($scriptName, '', $url);  // Loại bỏ thư mục gốc chuẩn hóa
            
            // Tách đường dẫn thành mảng và xử lý
            $urlParts = explode('/', trim($url, '/'));
            
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

                // Kiểm tra xem file controller có tồn tại không
                $controllerPath = _DIR_ROOT . '/app/controllers/' . $fileCheck . '.php';
                if (file_exists($controllerPath)) {
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

        // Xây dựng đường dẫn đầy đủ đến file controller
        $controllerPath = _DIR_ROOT . '/app/controllers/' . $urlCheck . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;

            // Xây dựng namespace đầy đủ cho controller
            $namespace = 'App\\Controllers\\';
            if (str_contains($urlCheck, '/')) {
                // Nếu controller nằm trong thư mục con (ví dụ: admin/Dashboard)
                $namespace .= str_replace('/', '\\', dirname($urlCheck)) . '\\';
            }
            $controllerClass = $namespace . $this->__controller;

            // Kiểm tra class controller có tồn tại không
            if (class_exists($controllerClass)) {
                $this->__controller = new $controllerClass;
                unset($urlArr[0]);
            } else {
                $this->loadError("Controller không tồn tại: $controllerClass");
                return;
            }
        } else {
            $this->loadError("File controller không tồn tại: $controllerPath");
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
            $this->loadError("Action không tồn tại: " . $this->__action);
        }
    }

    public function loadError($message = '404', $name = '404') {
        // Hiển thị thông báo lỗi chi tiết
        echo "<pre>Lỗi: $message</pre>";
        require_once _DIR_ROOT . '/app/errors/' . $name . '.php';
    }
}