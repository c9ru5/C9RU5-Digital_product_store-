<?php
namespace App\Controllers;

use App\Core\Controller;

class Home extends Controller {
    public $product_model;
    public $category_model;
    public $data = [];

    public function __construct() {
        $this->product_model = $this->model('Product');
        $this->category_model = $this->model('Category');
    }
    
    public function index() {
        $category_list = $this->category_model->getAllCategory();
        $product_list = $this->product_model->getAllProduct();
        $this->data['page_title'] = 'Trang chủ';
        $this->data['sub_content']['category_list'] = $category_list;
        $this->data['sub_content']['product_list'] = $product_list;
        $this->data['content'] = 'home/index';
        $this->render('layouts/client_layout', $this->data);
    }

    
}