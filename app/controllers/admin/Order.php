<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class Order extends Controller {
    public $data = [];
    public $order_model;
    public $user_model;

    public function __construct()
    {
        $this->order_model = $this->model('Order');
        $this->user_model = $this->model('User');
    }

    public function processing() {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $status = 1;

        $orders = $this->order_model->paginationOrder($limit, $offset, $status);

        $total_orders = $this->order_model->getTotalOrder($status);
        $total_pages = ceil($total_orders / $limit);

        $this->data['page_title'] = 'Quản lý đơn hàng đang xử lý';
        $this->data['sub_content']['orders'] = $orders;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['sub_content']['users'] = $this->user_model->getAllUser();
        $this->data['content'] = 'admin/order/processing';
        $this->render('layouts/admin_layout', $this->data);
        
    }

    public function success() {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $status = 2;

        $orders = $this->order_model->paginationOrder($limit, $offset, $status);

        $total_orders = $this->order_model->getTotalOrder($status);
        $total_pages = ceil($total_orders / $limit);

        $this->data['page_title'] = 'Quản lý đơn hàng thành công';
        $this->data['sub_content']['orders'] = $orders;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['sub_content']['users'] = $this->user_model->getAllUser();
        $this->data['content'] = 'admin/order/success';
        $this->render('layouts/admin_layout', $this->data);
        
    }

    public function cancel() {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $status = 0;

        $orders = $this->order_model->paginationOrder($limit, $offset, $status);

        $total_orders = $this->order_model->getTotalOrder($status);
        $total_pages = ceil($total_orders / $limit);

        $this->data['page_title'] = 'Quản lý đơn hàng đã hủy';
        $this->data['sub_content']['orders'] = $orders;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['sub_content']['users'] = $this->user_model->getAllUser();
        $this->data['content'] = 'admin/order/cancel';
        $this->render('layouts/admin_layout', $this->data);
        
    }

    public function showInfo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->order_model->setId($id);
                $order = $this->order_model->getOneOrder($this->order_model);
                $detail = $this->order_model->getDetailOrder($this->order_model);
                echo json_encode([
                    "result" => true,
                    "name" => $order['name'],
                    "email" => $order['email'],
                    "date" => $order['date_created'],
                    "value" => $order['value'],
                    "products" => $detail
                ]);
               
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function approvalOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->order_model->setId($id);
                $this->order_model->setStatus(2);
                $this->order_model->changeStatus($this->order_model);
                $_SESSION['noti'] = [
                    'title' => 'Thành công',
                    'mess'  => 'Duyệt đơn thành công',
                    'type'  => 'success'
                ];
                echo json_encode(["result" => true]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->order_model->setId($id);
                $this->order_model->setStatus(0);
                $this->order_model->changeStatus($this->order_model);
                $_SESSION['noti'] = [
                    'title' => 'Thành công',
                    'mess'  => 'Hủy đơn thành công',
                    'type'  => 'success'
                ];
                echo json_encode(["result" => true]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function deleteOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->order_model->setId($id);
                $this->order_model->deleteOrder($this->order_model);
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
}