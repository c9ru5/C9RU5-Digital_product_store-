<?php
namespace App\Models;

use App\Core\Model;

class Category
{
    private $id;
    private $name;
    private $icon;
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
    public function setIcon($icon)
    {
        return $this->icon = $icon;
    }
    public function getIcon()
    {
        return $this->icon;
    }

    public function getAllCategory()
    {
        $sql = "SELECT * FROM categories";
        return $this->db->getAll($sql);
    }
    public function getOneCategory(Category $category)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->db->getOne($sql, $category->getId());
    }
}
