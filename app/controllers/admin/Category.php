<?php

namespace App\Controllers\Admin;

use App\Core\Controller;

class Category extends Controller
{
    public $category_model;
    public $product_model;
    public $data = [];

    public function __construct()
    {
        $this->category_model = $this->model('Category');
        $this->product_model = $this->model('Product');
    }

    public function index()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $categories = $this->category_model->paginationCategory($limit, $offset);

        $total_categories = $this->category_model->getTotalCategory();
        $total_pages = ceil($total_categories / $limit);

        $this->data['page_title'] = 'Quản lý danh mục';
        $this->data['sub_content']['categories'] = $categories;
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['content'] = 'admin/category/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function addCategory()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $icon = $_POST['icon'] ?? '';

            if (!empty($name)) {
                $this->category_model->setName(trim($name));
                $this->category_model->setIcon(trim($icon));

                $inserted = $this->category_model->addCategory($this->category_model);

                if ($inserted) {
                    $_SESSION['noti'] = [
                        'title' => 'Thành công',
                        'mess'  => 'Thêm thành công',
                        'type'  => 'success'
                    ];
                    echo json_encode(["result" => true]);
                } else {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Thêm thất bại", "type" => "error"]);
                }
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "Vui lòng không để trống tên", "type" => "warning"]);
            }
        }
    }

    public function editCategory()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $icon = $_POST['icon'] ?? '';

            if (!empty($name)) {
                $this->category_model->setId($id);
                $this->category_model->setName(trim($name));
                $this->category_model->setIcon(trim($icon));

                $updated = $this->category_model->updateCategory($this->category_model);

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
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "Vui lòng không để trống tên", "type" => "warning"]);
            }
        }
    }

    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;

            if ($id > 0) {
                $this->product_model->setCategoryId($id);
                $product_check = $this->product_model->getTotalProductsByCategory($this->product_model);

                // Kiểm tra nếu danh mục có sản phẩm thì không cho xóa
                if ($product_check > 0) {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Danh mục vẫn còn sản phẩm, không thể xóa", "type" => "error"]);
                    return;
                }

                // Nếu không có sản phẩm, tiến hành xóa danh mục
                $this->category_model->setId($id);
                $deleted = $this->category_model->deleteCategory($this->category_model);
                if ($deleted) {
                    $_SESSION['noti'] = [
                        'title' => 'Thành công',
                        'mess'  => 'Xóa thành công',
                        'type'  => 'success'
                    ];
                    echo json_encode(["result" => true]);
                } else {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Xóa thất bại", "type" => "error"]);
                }
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }

    public function showInfo() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if($id > 0) {
                $this->category_model->setId($id);
                $category = $this->category_model->getOneCategory($this->category_model);
                echo json_encode(["result" => true, "id" => $category['id'], "name" => $category['name'], "icon" => $category['icon']]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }
}
