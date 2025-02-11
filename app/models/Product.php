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
    public function getOneProduct(Product $product)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        return $this->db->getOne($sql, $product->getId());
    }
    public function getRelatedProduct(Product $product)
    {
        $sql = "SELECT * FROM products WHERE category_id = ? LIMIT 4";
        return $this->db->getAll($sql, $product->getCategoryId());
    }
}
