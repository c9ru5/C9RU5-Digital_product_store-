<?php
namespace App\Controllers;

use App\Core\Controller;

class Order extends Controller {
    public $order_model;
    public $cart_model;
    public $data = [];

    public function __construct() {
        $this->order_model = $this->model('Order');
        $this->cart_model = $this->model('Cart');
    }
    
    public function index() {
        $this->cart_model->setUserId($_SESSION['user']['id']);
        $details = $this->cart_model->getCart($this->cart_model);
        
        $this->order_model->setUserId($_SESSION['user']['id']);
        $this->order_model->setValue($_SESSION['value']);
        $order_id = $this->order_model->addOrder($this->order_model);

        foreach ($details as $detail) {
            $this->order_model->setId($order_id);
            $this->order_model->setProductId($detail['product_id']);
            $this->order_model->setDetailQuantity($detail['cart_quantity']);
            $this->order_model->addOrderDetail($this->order_model);

            $this->cart_model->setDetailId($detail['detail_id']);
            $this->cart_model->deleteCart($this->cart_model);
        }

        $_SESSION['noti'] = [
            'title' => 'Thành công',
            'mess'  => 'Thanh toán thành công',
            'type'  => 'success'
        ];


        $result = true;
        $this->data['page_title'] = 'Thanh toán';
        $this->data['sub_content']['result'] = $result;
        $this->data['content'] = 'order/index';
        $this->render('layouts/client_layout', $this->data);
    }

    
}