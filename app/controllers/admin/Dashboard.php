<?php

namespace App\Controllers\Admin;

use App\Core\Controller;

class Dashboard extends Controller
{
    public $data = [];
    public $order_model;
    public $user_model;
    public $product_model;

    public function __construct()
    {
        $this->order_model = $this->model('Order');
        $this->user_model = $this->model('User');
        $this->product_model = $this->model('Product');
    }

    public function index()
    {
        $stock = $this->product_model->totalInStock();
        $user = $this->user_model->getTotalUser(2);
        $order_count = $this->order_model->getTotalOrderByStatus();
        $rate_order = ($order_count['success'] + $order_count['cancel']) > 0
            ? round(($order_count['success'] * 100) / ($order_count['success'] + $order_count['cancel']), 1) : 0;

        // Lấy dữ liệu doanh thu 
        $sales_data = $this->order_model->getRevenueByMonth();

        // Lấy dữ liệu tỷ lệ sản phẩm theo danh mục
        $product_distribution = $this->product_model->getProductDistribution();

        $this->data['page_title'] = 'Thống kê';
        $this->data['sub_content']['new_order'] = $order_count['processing'];
        $this->data['sub_content']['rate_order'] = $rate_order;
        $this->data['sub_content']['user'] = $user;
        $this->data['sub_content']['stock'] = $stock;
        $this->data['sub_content']['sales_data'] = json_encode($sales_data);
        $this->data['sub_content']['product_distribution'] = json_encode($product_distribution);
        $this->data['content'] = 'admin/dashboard/index';

        $this->render('layouts/admin_layout', $this->data);
    }
}
