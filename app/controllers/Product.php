<?php
namespace App\Controllers;

use App\Core\Controller;

class Product extends Controller {
    public $product_model;
    public $category_model;
    public $data = [];

    public function __construct() {
        $this->product_model = $this->model('Product');
        $this->category_model = $this->model('Category');
    }

    public function detail($id) {
        $this->product_model->setId($id);
        $product = $this->product_model->getOneProduct($this->product_model);
        $related_product = $this->product_model->getRelatedProduct($this->product_model);
        $this->data['page_title'] = $product['name'];
        $this->data['sub_content']['product'] = $product;
        $this->data['sub_content']['related_product'] = $related_product;
        $this->data['content'] = 'product/detail';
        $this->render('layouts/client_layout', $this->data);
    }
    
}