<?php

namespace App\Models;

use App\Core\Model;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $image;
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
    public function setEmail($email)
    {
        return $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setPassword($password)
    {
        return $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setRole($role)
    {
        return $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setImage($image)
    {
        return $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function login(User $user)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        return $this->db->getOne($sql, $user->getEmail(), $user->getPassword());
    }

    public function register(User $user)
    {
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        return $this->db->insert($sql, $user->getEmail(), $user->getPassword());
    }

    public function checkEmail(User $user)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->getOne($sql, $user->getEmail());
    }

    public function checkPassword(User $user)
    {

        // Kiểm tra độ dài mật khẩu
        if (strlen($user->getPassword()) < 6) {
            return false;
        }

        // Kiểm tra có ít nhất một chữ hoa
        if (!preg_match('/[A-Z]/', $user->getPassword())) {
            return false;
        }

        // Kiểm tra có ít nhất một chữ thường
        if (!preg_match('/[a-z]/', $user->getPassword())) {
            return false;
        }

        // Kiểm tra có ít nhất một số
        if (!preg_match('/\d/', $user->getPassword())) {
            return false;
        }

        // Kiểm tra có ít nhất một ký tự đặc biệt
        if (!preg_match('/[\W_]/', $user->getPassword())) {
            return false;
        }

        return true;
    }
}
