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
    private $status;
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
    public function setStatus($status)
    {
        return $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
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
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        return $this->db->insert($sql, $user->getName(), $user->getEmail(), $user->getPassword(), $user->getRole());
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

    public function getAllUserByRole($role)
    {
        $sql = "SELECT * FROM users WHERE role = ?";
        return $this->db->getAll($sql, $role);
    }

    public function getAllUser()
    {
        $sql = "SELECT * FROM users";
        return $this->db->getAll($sql);
    }

    public function getOneUser(User $user)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->getOne($sql, $user->getId());
    }

    public function paginationUser($limit, $offset, $role)
    {
        $sql = "SELECT * FROM users WHERE role = $role";
        $sql .= " LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }

    public function getTotalUser($role)
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role = ?";
        $result = $this->db->getOne($sql, $role);
        return $result['total'] ?? 0;
    }

    public function changeStatus(User $user)
    {
        $sql = "UPDATE users SET status = ? WHERE id = ?";
        return $this->db->update($sql, $user->getStatus(), $user->getId());
    }

    public function deleteUser(User $user)
    {
        try {
            // Bắt đầu transaction
            $this->db->beginTransaction();

            // Xóa chi tiết đơn hàng (detail_orders) liên quan đến các đơn hàng của người dùng
            $sql = "DELETE detail_orders FROM detail_orders
                JOIN orders ON detail_orders.order_id = orders.id
                WHERE orders.user_id = ? AND (orders.status = 0 OR orders.status = 2)";
            $this->db->delete($sql, $user->getId());

            // Xóa các đơn hàng có trạng thái 0 hoặc 2
            $sql = "DELETE FROM orders WHERE user_id = ? AND (status = 0 OR status = 2)";
            $this->db->delete($sql, $user->getId());

            // Xóa chi tiết giỏ hàng (detail_carts) liên quan đến giỏ hàng của người dùng
            $sql = "DELETE detail_carts FROM detail_carts
                JOIN carts ON detail_carts.cart_id = carts.id
                WHERE carts.user_id = ?";
            $this->db->delete($sql, $user->getId());

            // Xóa giỏ hàng của người dùng
            $sql = "DELETE FROM carts WHERE user_id = ?";
            $this->db->delete($sql, $user->getId());

            // Xóa người dùng
            $sql = "DELETE FROM users WHERE id = ?";
            $this->db->delete($sql, $user->getId());

            // Commit transaction nếu tất cả các thao tác thành công
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            // Rollback transaction nếu có lỗi
            $this->db->rollback();
            echo "Lỗi khi xóa người dùng: " . $e->getMessage();
            return false;
        }
    }
    public function updateUser(User $user) {
        $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
        return $this->db->update($sql, $user->getName(), $user->getEmail(), $user->getPassword(), $user->getId());
    }
}
