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
}
