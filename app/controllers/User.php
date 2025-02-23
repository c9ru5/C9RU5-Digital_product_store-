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
            if ($user['status'] == 0) {
                echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Tài khoản đã bị khóa", "type" => "error"]);
                exit;
            }
            $_SESSION['user'] = $user;
            $_SESSION['noti'] = [
                'title' => 'Thành công',
                'mess'  => 'Đăng nhập thành công',
                'type'  => 'success'
            ];
            if ($user['role'] == 2) {
                echo json_encode(["result" => true, "redirect" => _WEB_ROOT . '/trang-chu']);
                exit;
            } else {
                echo json_encode(["result" => true, "redirect" => _WEB_ROOT . '/admin/thong-ke']);
                exit;
            }
        } else {
            echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Email hoặc mật khẩu không đúng", "type" => "error"]);
            exit;
        }
        exit();
    }


    public function logout()
    {
        unset($_SESSION['user']);
        $_SESSION['noti'] = [
            'title' => 'Thành công',
            'mess'  => 'Đăng xuất thành công',
            'type'  => 'success'
        ];
        header("Location: " . _WEB_ROOT . "/");
        exit();
    }

    public function register()
    {   
        $this->user_model->setName($_POST['name-rg']);
        $this->user_model->setRole(2);
        $this->user_model->setEmail($_POST['email-rg']);
        $this->user_model->setPassword($_POST['password-rg']);
        if ($this->user_model->checkEmail($this->user_model)) {
            echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Email đã tồn tại", "type" => "error"]);
        } elseif ($this->user_model->checkPassword($this->user_model) == false) {
            echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Mật khẩu phải có ít nhất 6 ký tự và chứa ít nhất một chữ hoa, chữ thường, số và ký tự đặc biệt", "type" => "error"]);
        } elseif ($_POST['password-rg'] != $_POST['confirm-rg']) {
            echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Mật khẩu không khớp", "type" => "error"]);
        } else {
            $this->user_model->register($this->user_model);
            echo json_encode(["result" => true, "title" => "Thành công", "mess" => "Đăng ký thành công", "type" => "success"]);
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
