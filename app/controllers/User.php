<?php

namespace App\Controllers;

use App\Core\Controller;

class User extends Controller
{
    public $user_model;
    public $data = [];

    public function __construct()
    {
        $this->user_model = $this->model('User');
    }

    public function login()
    {
        $this->user_model->setEmail($_POST['email-lg']);
        $this->user_model->setPassword($_POST['password-lg']);
        $user = $this->user_model->login($this->user_model);

        if ($user) {
            $_SESSION['user'] = $user;
            $_SESSION['noti'] = [
                'title' => 'Thành công',
                'mess'  => 'Đăng nhập thành công',
                'type'  => 'success'
            ];
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
        exit();
    }


    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header("Location: " . _WEB_ROOT . "/");
        exit();
    }

    public function register()
    {
        $this->user_model->setEmail($_POST['email-rg']);
        $this->user_model->setPassword($_POST['password-rg']);
        if ($_POST['password-rg'] == $_POST['confirm-rg']) {
            $this->user_model->register($this->user_model);
            echo json_encode(["success" => true, "message" => "Đăng ký thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Sai email hoặc mật khẩu"]);
        }
    }

    public function profile()
    {
        $this->user_model->setId($_SESSION['user']['id']);
        $this->data['page_title'] = 'Thông tin cá nhân';
        $this->data['sub_content']['bruh'] = 'bruh';
        $this->data['content'] = 'user/profile';
        $this->render('layouts/client_layout', $this->data);
    }
}
