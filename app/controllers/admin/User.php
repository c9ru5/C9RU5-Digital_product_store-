<?php

namespace App\Controllers\Admin;

use App\Core\Controller;

class User extends Controller
{
    public $data = [];
    public $user_model;
    public $order_model;

    public function __construct()
    {
        $this->user_model = $this->model('User');
        $this->order_model = $this->model('Order');
    }

    public function staff()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $role = 1;

        $users = $this->user_model->paginationUser($limit, $offset, $role);

        $total_users = $this->user_model->getTotalUser($role);
        $total_pages = ceil($total_users / $limit);

        $this->data['page_title'] = 'Quản lý nhân viên';
        $this->data['sub_content']['users'] = $users;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['content'] = 'admin/user/staff';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function client()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $role = 2;

        $users = $this->user_model->paginationUser($limit, $offset, $role);

        $total_users = $this->user_model->getTotalUser($role);
        $total_pages = ceil($total_users / $limit);

        $this->data['page_title'] = 'Quản lý khách hàng';
        $this->data['sub_content']['users'] = $users;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['content'] = 'admin/user/client';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function showInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->user_model->setId($id);
                $user = $this->user_model->getOneUser($this->user_model);
                if (!$user) {
                    echo json_encode([
                        "result" => false,
                        "title" => "Thất bại",
                        "mess" => "Không tìm thấy người dùng",
                        "type" => "error"
                    ]);
                    exit;
                }
                $this->order_model->setUserId($id);
                $order_count = $this->order_model->getTotalOrderByUser($this->order_model);
                echo json_encode([
                    "result" => true,
                    "id" => $user['id'],
                    "name" => $user['name'],
                    "email" => $user['email'],
                    "password" => $user['password'],
                    "order_s" => $order_count['success'] ?? 0, // Sử dụng toán tử null coalescing để tránh lỗi
                    "order_c" => $order_count['cancel'] ?? 0  // Sử dụng toán tử null coalescing để tránh lỗi
                ]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function changeStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $status = $_POST['status'] ?? 0;
            if ($id > 0) {
                $this->order_model->setUserId($id);
                $order_check = $this->order_model->getTotalOrderByUser($this->order_model);
                if ($order_check['processing'] > 0) {
                    echo json_encode([
                        "result" => false,
                        "title" => "Thất bại",
                        "mess" => "Người dùng có đơn hàng đang xử lý, không thể đổi trạng thái",
                        "type" => "error"
                    ]);
                    exit;
                }
                if ($status == 1) {
                    $status = 0;
                } else {
                    $status = 1;
                }
                $this->user_model->setId($id);
                $this->user_model->setStatus($status);
                $this->user_model->changeStatus($this->user_model);
                $_SESSION['noti'] = [
                    'title' => 'Thành công',
                    'mess'  => 'Thay đổi trạng thái thành công',
                    'type'  => 'success'
                ];
                echo json_encode(["result" => true]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->order_model->setUserId($id);
                $order_check = $this->order_model->getTotalOrderByUser($this->order_model);
                if ($order_check['processing'] > 0) {
                    echo json_encode([
                        "result" => false,
                        "title" => "Thất bại",
                        "mess" => "Người dùng có đơn hàng đang xử lý, không thể đổi xóa",
                        "type" => "error"
                    ]);
                    exit;
                }

                $this->user_model->setId($id);
                $result = $this->user_model->deleteUser($this->user_model);
                if (!$result) {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Lỗi xóa", "type" => "error"]);
                    exit;
                }
                $_SESSION['noti'] = [
                    'title' => 'Thành công',
                    'mess'  => 'Xóa thành công',
                    'type'  => 'success'
                ];
                echo json_encode(["result" => true]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($name) && !empty($email) && !empty($password)) {
                $this->user_model->setName(trim($_POST['name']));
                $this->user_model->setRole(1);
                $this->user_model->setEmail(trim($_POST['email']));
                $this->user_model->setPassword(trim($_POST['password']));
                if ($this->user_model->checkEmail($this->user_model)) {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Email đã tồn tại", "type" => "error"]);
                } elseif ($this->user_model->checkPassword($this->user_model) == false) {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Mật khẩu phải có ít nhất 6 ký tự và chứa ít nhất một chữ hoa, chữ thường, số và ký tự đặc biệt", "type" => "error"]);
                } elseif ($_POST['password'] != $_POST['confirm']) {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Mật khẩu không khớp", "type" => "error"]);
                } else {
                    $this->user_model->register($this->user_model);
                    $_SESSION['noti'] = [
                        'title' => 'Thành công',
                        'mess'  => 'Thêm người dùng thành công',
                        'type'  => 'success'
                    ];
                    echo json_encode(["result" => true]);
                }
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "Vui lòng không để trống", "type" => "warning"]);
            }
        }
    }

    public function editUser()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($name) && !empty($email) && !empty($password)) {
                $this->user_model->setId($id);
                $this->user_model->setName(trim($_POST['name']));
                $this->user_model->setEmail(trim($_POST['email']));
                $this->user_model->setPassword(trim($_POST['password']));

                $updated = $this->user_model->updateUser($this->user_model);

                if ($updated) {
                    $_SESSION['noti'] = [
                        'title' => 'Thành công',
                        'mess'  => 'Cập nhật thành công',
                        'type'  => 'success'
                    ];
                    echo json_encode(["result" => true]);
                } else {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Cập nhật thất bại", "type" => "error"]);
                }
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "Vui lòng không để trống", "type" => "warning"]);
            }
        }
    }
}
