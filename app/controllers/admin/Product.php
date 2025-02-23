<?php

namespace App\Controllers\Admin;

use App\Core\Controller;

class Product extends Controller
{
    public $product_model;
    public $order_model;
    public $category_model;
    public $data = [];

    public function __construct()
    {
        $this->product_model = $this->model('Product');
        $this->category_model = $this->model('Category');
        $this->order_model = $this->model('Order');
    }

    public function index()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $products = $this->product_model->paginationProduct($limit, $offset);

        $total_products = $this->product_model->getTotalProducts();
        $total_pages = ceil($total_products / $limit);

        $this->data['page_title'] = 'Quản lý sản phẩm';
        $this->data['sub_content']['products'] = $products;
        $this->data['sub_content']['categories'] = $this->category_model->getAllCategory();
        $this->data['sub_content']['total_pages'] = $total_pages;
        $this->data['sub_content']['current_page'] = $page;
        $this->data['content'] = 'admin/product/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $discount = $_POST['discount'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $describe = $_POST['describe'] ?? '';
            $category = $_POST['category'] ?? '';
            $genre = $_POST['genre'] ?? '';
            $image = $_FILES['image']['name'] ?? '';

            if (!empty($name) && !empty($price) && !empty($discount) && !empty($quantity) && !empty($describe) && !empty($category) && !empty($genre) && !empty($image)) {
                // Upload file ảnh
                $upload_result = $this->product_model->uploadFile($_FILES['image']);

                if (!$upload_result['result']) {
                    echo json_encode($upload_result);
                    return;
                }

                // Lấy tên file ảnh mới
                $image = $upload_result['file_name'];

                // Set dữ liệu cho sản phẩm
                $this->product_model->setName(trim($name));
                $this->product_model->setPrice(trim($price));
                $this->product_model->setDiscount(trim($discount));
                $this->product_model->setQuantity(trim($quantity));
                $this->product_model->setDescription(trim($describe));
                $this->product_model->setCategoryId($category);
                $this->product_model->setGenre(trim($genre));
                $this->product_model->setImage($image); // Lưu tên ảnh mới

                // Thêm sản phẩm vào database
                $inserted = $this->product_model->addProduct($this->product_model);

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
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "Vui lòng không để trống", "type" => "warning"]);
            }
        }
    }

    public function editProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $discount = $_POST['discount'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $describe = $_POST['describe'] ?? '';
            $category = $_POST['category'] ?? '';
            $genre = $_POST['genre'] ?? '';
            $new_image = $_FILES['image']['name'] ?? '';

            if (!empty($name) && !empty($price) && !empty($discount) && !empty($quantity) && !empty($describe) && !empty($category) && !empty($genre) && !empty($new_image)) {
                // Lấy thông tin sản phẩm hiện tại
                $this->product_model->setId($id);
                $current_product = $this->product_model->getOneProduct($this->product_model);

                // Xử lý ảnh mới nếu có
                $image = $current_product['image']; // Giữ nguyên ảnh cũ nếu không có ảnh mới
                if (!empty($new_image)) {
                    // Upload file ảnh mới
                    $upload_result = $this->product_model->uploadFile($_FILES['image']);
                    if (!$upload_result['result']) {
                        echo json_encode($upload_result);
                        return;
                    }
                    $image = $upload_result['file_name'];

                    // Xóa ảnh cũ
                    $this->product_model->removeFile($current_product['image']);
                }

                // Set dữ liệu cho sản phẩm
                $this->product_model->setName(trim($name));
                $this->product_model->setPrice(trim($price));
                $this->product_model->setDiscount(trim($discount));
                $this->product_model->setQuantity(trim($quantity));
                $this->product_model->setDescription(trim($describe));
                $this->product_model->setCategoryId($category);
                $this->product_model->setGenre(trim($genre));
                $this->product_model->setImage($image); // Lưu tên ảnh mới

                // Thêm sản phẩm vào database
                $updated = $this->product_model->updateProduct($this->product_model);

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

    public function deleteProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $image = $_POST['image'] ?? '';

            if ($id > 0) {
                $order_check = $this->order_model->getDetailByProduct($id);


                if (!empty($order_check)) {
                    echo json_encode(["result" => false, "title" => "Thất bại", "mess" => "Có đơn hàng chứa sản phẩm, không thể xóa", "type" => "error"]);
                    return;
                }

                $remove_result = $this->product_model->removeFile($image);

                if ($remove_result['result'] == false) {
                    echo json_encode($remove_result);
                    return;
                }


                $this->product_model->setId($id);
                $deleted = $this->product_model->deleteProduct($this->product_model);


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

    public function showInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->product_model->setId($id);
                $product = $this->product_model->getOneProduct($this->product_model);
                echo json_encode(["result" => true, "id" => $product['id'], "name" => $product['name'], "image" => $product['image'], "category" => $product['category_id'], "genre" => $product['genre'], "price" => $product['price'], "discount" => $product['discount_percent'], "quantity" => $product['quantity'], "describe" => $product['product_description']]);
            } else {
                echo json_encode(["result" => false, "title" => "Lưu ý", "mess" => "ID không hợp lệ", "type" => "warning"]);
            }
        }
    }
}
