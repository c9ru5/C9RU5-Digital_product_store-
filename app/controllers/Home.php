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
        $new_products = $this->product_model->getNewProduct();
        $hot_products = $this->product_model->getHotProduct();
        $steam_games = $this->product_model->getSteamGame();
        $this->data['page_title'] = 'Trang chủ';
        $this->data['sub_content']['category_list'] = $category_list;
        $this->data['sub_content']['new_products'] = array_slice($new_products, 0, 8);
        $this->data['sub_content']['hot_products'] = array_slice($hot_products, 0, 8);
        $this->data['sub_content']['steam_games'] = array_slice($steam_games, 0, 8);
        $this->data['content'] = 'home/index';
        $this->render('layouts/client_layout', $this->data);
    }

    
}