<?php

namespace App\Models;

use App\Core\Model;

class Product
{
    private $id;
    private $name;
    private $price;
    private $discount_percent;
    private $product_description;
    private $image;
    private $quantity;
    private $category_id;
    private $genre;
    private $sales;
    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setName($name)
    {
        return $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setPrice($price)
    {
        return $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setDiscount($discount_percent)
    {
        return $this->discount_percent = $discount_percent;
    }
    public function getDiscount()
    {
        return $this->discount_percent;
    }
    public function setDescription($product_description)
    {
        return $this->product_description = $product_description;
    }
    public function getDescription()
    {
        return $this->product_description;
    }
    public function setImage($image)
    {
        return $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setQuantity($quantity)
    {
        return $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setCategoryId($category_id)
    {
        return $this->category_id = $category_id;
    }
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setGenre($genre)
    {
        return $this->genre = $genre;
    }
    public function getGenre()
    {
        return $this->genre;
    }
    public function setSales($sales)
    {
        return $this->sales = $sales;
    }
    public function getSales()
    {
        return $this->sales;
    }

    public function getAllProduct()
    {
        $sql = "SELECT * FROM products";
        return $this->db->getAll($sql);
    }
    public function getProductByCategory(Product $product, $limit, $offset, $order = null)
    {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        if ($order) {
            $sql .= " ORDER BY (price - (price * discount_percent)/100) $order";
        }
        $sql .= " LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql, $product->getCategoryId());
    }
    public function getTotalProductsByCategory(Product $product)
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE category_id = ?";
        $result = $this->db->getOne($sql, $product->getCategoryId());
        return $result['total'] ?? 0;
    }
    public function paginationProduct($limit, $offset, $order = null, $keyword = null)
    {
        $sql = "SELECT * FROM products";
        if (!empty($keyword)) {
            $sql .= " WHERE name LIKE '%$keyword%'";
        }
        if ($order) {
            $sql .= " ORDER BY (price - (price * discount_percent)/100) $order";
        }
        $sql .= " LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }
    public function getHotProduct()
    {
        $sql = "SELECT * FROM products ORDER BY sales DESC";
        return $this->db->getAll($sql);
    }
    public function getNewProduct()
    {
        $sql = "SELECT * FROM products ORDER BY id DESC";
        return $this->db->getAll($sql);
    }
    public function getSteamGame()
    {
        $sql = "SELECT * FROM products WHERE category_id = 4";
        return $this->db->getAll($sql);
    }
    public function getTotalProducts($keyword = null)
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        if (!empty($keyword)) {
            $sql .= " WHERE name LIKE '%$keyword%'";
        }
        $result = $this->db->getOne($sql);
        return $result['total'] ?? 0;
    }
    public function getOneProduct(Product $product)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        return $this->db->getOne($sql, $product->getId());
    }
    public function getRelatedProduct(Product $product)
    {
        $sql = "SELECT * FROM products WHERE category_id = ? AND id <> ? LIMIT 4";
        return $this->db->getAll($sql, $product->getCategoryId(), $product->getId());
    }
    public function addProduct(Product $product)
    {
        $sql = "INSERT INTO products (name, price, discount_percent, image, quantity, product_description, genre, category_id)";
        $sql .= " VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, $product->getName(), $product->getPrice(), $product->getDiscount(), $product->getImage(), $product->getQuantity(), $product->getDescription(), $product->getGenre(), $product->getCategoryId());
    }
    public function uploadFile($file)
    {
        // Kiểm tra xem có file nào được tải lên không
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return ["result" => false, "title" => "Lưu ý", "mess" => "Không có file hợp lệ để tải lên", "type" => "warning"];
        }

        // Kiểm tra định dạng file hợp lệ (chỉ chấp nhận ảnh)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ["result" => false, "title" => "Lưu ý", "mess" => "Chỉ cho phép tải lên file ảnh", "type" => "warning"];
        }

        // Đổi tên file để tránh trùng lặp (theo timestamp)
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION); // Lấy đuôi file
        $fileName = time() . "_" . uniqid() . "." . $ext; // Tạo tên mới
        $uploadDir = _DIR_ROOT . '/public/assets/images/'; // Thư mục lưu file
        $uploadPath = $uploadDir . $fileName;

        // Kiểm tra thư mục, nếu chưa có thì tạo mới
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Di chuyển file đến thư mục đích
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ["result" => true, "file_name" => $fileName, "title" => "Thành công", "mess" => "Tải lên thành công", "type" => "success"];
        } else {
            return ["result" => false, "title" => "Thất bại", "mess" => "Không thể di chuyển file", "type" => "error"];
        }
    }
    public function removeFile($fileName)
    {
        $filePath = _DIR_ROOT . '/public/assets/images/' . $fileName;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return ["result" => true, "title" => "Thành công", "mess" => "Xóa file thành công", "type" => "success"];
            } else {
                return ["result" => false, "title" => "Thất bại", "mess" => "Không thể xóa file", "type" => "error"];
            }
        } else {
            return ["result" => false, "title" => "Lưu ý", "mess" => "File không tồn tại", "type" => "warning"];
        }
    }
    public function deleteProduct(Product $product)
    {
        // Xóa chi tiết giỏ hàng có chứa sản phẩm trước
        $sql = "DELETE FROM detail_carts WHERE product_id =?";
        $this->db->delete($sql, $product->getId());
        // Xóa sản phẩm
        $sql = "DELETE FROM products WHERE id = ?";
        return $this->db->delete($sql, $product->getId());
    }
    public function updateProduct(Product $product)
    {
        $sql = "UPDATE products SET 
            name = ?, 
            price = ?, 
            discount_percent = ?, 
            image = ?, 
            quantity = ?, 
            product_description = ?, 
            genre = ?, 
            category_id = ? 
            WHERE id = ?";

        return $this->db->update(
            $sql,
            $product->getName(),
            $product->getPrice(),
            $product->getDiscount(),
            $product->getImage(),
            $product->getQuantity(),
            $product->getDescription(),
            $product->getGenre(),
            $product->getCategoryId(),
            $product->getId()
        );
    }
    public function totalInStock()
    {
        $sql = "SELECT COALESCE(SUM(quantity), 0) as total FROM products";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    public function getProductDistribution()
    {
        $sql = "SELECT c.name as category, COUNT(p.id) as total_products
            FROM products p
            JOIN categories c ON p.category_id = c.id
            GROUP BY c.name";
        $result = $this->db->getAll($sql);

        $labels = [];
        $values = [];
        foreach ($result as $row) {
            $labels[] = $row['category'];
            $values[] = (int)$row['total_products'];
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
