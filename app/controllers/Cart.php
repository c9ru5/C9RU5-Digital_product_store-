<?php

namespace App\Controllers;

use App\Core\Controller;
use Exception;

class Cart extends Controller
{
    public $cart_model;
    public $data = [];

    public function __construct()
    {
        $this->cart_model = $this->model('Cart');
    }

    public function index()
    {
        $this->cart_model->setUserId($_SESSION['user']['id']);
        $cart = $this->cart_model->getCart($this->cart_model);
        $this->data['page_title'] = "Giỏ hàng";
        $this->data['sub_content']['cart'] = $cart;
        $this->data['content'] = 'cart/index';
        $this->render('layouts/client_layout', $this->data);
    }

    public function addCart()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ!"]);
            return;
        }

        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(["success" => false, "message" => "Bạn chưa đăng nhập!"]);
            return;
        }

        // Lấy dữ liệu JSON từ request body
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['product_id'])) {
            echo json_encode(["success" => false, "message" => "Thiếu thông tin sản phẩm!"]);
            return;
        }

        try {
            $this->cart_model->setUserId($_SESSION['user']['id']);
            $this->cart_model->setProductId($data['product_id']);
            $this->cart_model->setDetailQuantity(1);
            $this->cart_model->insertCart($this->cart_model);

            echo json_encode(["success" => true, "message" => "Thêm vào giỏ hàng thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Lỗi: " . $e->getMessage()]);
        }
    }

    public function deleteCart() {
        header("Content-Type: application/json"); // Đảm bảo trả về JSON
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['detail_id'])) {
                throw new Exception("Thiếu detail_id!");
            }
    
            $this->cart_model->setDetailId($data['detail_id']);
            $this->cart_model->deleteCart($this->cart_model);
    
            echo json_encode(["success" => true]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Lỗi: " . $e->getMessage()]);
        }
        exit; // Đảm bảo không có dữ liệu nào thêm vào phản hồi
    }

    public function increaseCart($id) {
        $this->cart_model->setDetailId($id);
        $this->cart_model->increaseCart($this->cart_model);
        header('Location: '._WEB_ROOT.'/gio-hang');
    }

    public function decreaseCart($id) {
        $this->cart_model->setDetailId($id);
        $this->cart_model->decreaseCart($this->cart_model);
        header('Location: '._WEB_ROOT.'/gio-hang');
    }
    
}
