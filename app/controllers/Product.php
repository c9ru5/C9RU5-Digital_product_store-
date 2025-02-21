<?php

namespace App\Controllers;

use App\Core\Controller;

class Product extends Controller
{
    public $product_model;
    public $category_model;
    public $data = [];

    public function __construct()
    {
        $this->product_model = $this->model('Product');
        $this->category_model = $this->model('Category');
    }

    public function index()
    {
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? trim($_GET['search']) : null;

        // Kiểm tra xem người dùng đã chọn sắp xếp sản phẩm theo gì chưa
        $order = isset($_GET['order']) ? ($_GET['order'] == 'asc' ? 'asc' : 'desc') : null;
        $new_order = ($order == 'asc') ? 'desc' : 'asc';

        $products = $this->product_model->paginationProduct($limit, $offset, $order, $search);

        $total_products = $this->product_model->getTotalProducts($search);
        $total_pages = ceil($total_products / $limit);

        $this->data['page_title'] = 'Sản phẩm';
        $this->data['sub_content']['products'] = $products;
        $this->data['sub_content']['categories'] = $this->category_model->getAllCategory();
        $this->data['sub_content']['search'] = $search;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['sub_content']['order'] = $order;
        $this->data['sub_content']['new_order'] = $new_order;
        $this->data['content'] = 'product/index';
        $this->render('layouts/client_layout', $this->data);
    }

    public function productByCategory($category_id)
    {
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Kiểm tra xem người dùng đã chọn sắp xếp sản phẩm theo gì chưa
        $order = isset($_GET['order']) ? ($_GET['order'] == 'asc' ? 'asc' : 'desc') : null;
        $new_order = ($order == 'asc') ? 'desc' : 'asc';

        $this->product_model->setCategoryId($category_id);
        $products = $this->product_model->getProductByCategory($this->product_model, $limit, $offset, $order);

        $total_products = $this->product_model->getTotalProductsByCategory($this->product_model);
        $total_pages = ceil($total_products / $limit);

        $this->category_model->setId($category_id);
        $category = $this->category_model->getOneCategory($this->category_model);
        $this->data['page_title'] = 'Sản phẩm';
        $this->data['sub_content']['products'] = $products;
        $this->data['sub_content']['categories'] = $this->category_model->getAllCategory();
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['sub_content']['current_category'] = $category;
        $this->data['sub_content']['order'] = $order;
        $this->data['sub_content']['new_order'] = $new_order;
        $this->data['content'] = 'product/index';
        $this->render('layouts/client_layout', $this->data);
    }


    public function detail($id)
    {
        $this->product_model->setId($id);
        $product = $this->product_model->getOneProduct($this->product_model);
        $this->product_model->setCategoryId($product['category_id']);
        $related_product = $this->product_model->getRelatedProduct($this->product_model);
        $this->data['page_title'] = $product['name'];
        $this->data['sub_content']['detail_product'] = $product;
        $this->data['sub_content']['related_product'] = $related_product;
        $this->data['content'] = 'product/detail';
        $this->render('layouts/client_layout', $this->data);
    }
}
