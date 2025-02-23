<?php

namespace App\Models;

use App\Core\Model;

class Order
{
    private $id;
    private $status;
    private $user_id;
    private $date_created;
    private $detail_id;
    private $product_id;
    private $detail_quantity;
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
    public function setUserId($user_id)
    {
        return $this->user_id = $user_id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }
    public function setDetailId($detail_id)
    {
        return $this->detail_id = $detail_id;
    }
    public function getDetailId()
    {
        return $this->detail_id;
    }
    public function setDetailQuantity($detail_quantity)
    {
        return $this->detail_quantity = $detail_quantity;
    }
    public function getDetailQuantity()
    {
        return $this->detail_quantity;
    }
    public function setProductId($product_id)
    {
        return $this->product_id = $product_id;
    }
    public function getProductId()
    {
        return $this->product_id;
    }
    public function setStatus($status)
    {
        return $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setDate($date)
    {
        return $this->date_created = $date;
    }
    public function getDate()
    {
        return $this->date_created;
    }

    public function paginationOrder($limit, $offset, $status)
    {
        $sql = "SELECT * FROM orders";
        $sql .= " WHERE status = $status";
        $sql .= " LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }

    public function getTotalOrder($status)
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE status = ?";
        $result = $this->db->getOne($sql, $status);
        return $result['total'] ?? 0;
    }

    public function getOneOrder(Order $order)
    {
        $sql = "SELECT o.*, u.email, u.name 
        FROM orders o JOIN users u 
        ON o.user_id = u.id  
        WHERE o.id = ?";
        return $this->db->getOne($sql, $order->getId());
    }

    public function getDetailOrder(Order $order)
    {
        $sql = "SELECT d.*, p.name, p.price, p.discount_percent
        FROM detail_orders d JOIN products p 
        ON d.product_id = p.id
        WHERE order_id = ?";
        return $this->db->getAll($sql, $order->getId());
    }

    public function getDetailByProduct($product_id)
    {
        $sql = "SELECT * FROM detail_orders WHERE product_id = ?";
        return $this->db->getAll($sql, $product_id);
    }

    public function getTotalOrderByUser(Order $order)
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as success,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as cancel
            FROM orders
            WHERE user_id = ?";
        $result = $this->db->getOne($sql, $order->getUserId());
        return [
            'total' => $result['total'] ?? 0,
            'success' => $result['success'] ?? 0,
            'processing' => $result['processing'] ?? 0,
            'cancel' => $result['cancel'] ?? 0
        ];
    }

    public function getTotalOrderByStatus()
    {
        $sql = "SELECT 
                SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as success,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as cancel
            FROM orders";

        $result = $this->db->getOne($sql);

        return [
            'success' => $result['success'] ?? 0,
            'processing' => $result['processing'] ?? 0,
            'cancel' => $result['cancel'] ?? 0
        ];
    }


    public function changeStatus(Order $order)
    {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        return $this->db->update($sql, $order->getStatus(), $order->getId());
    }

    public function deleteOrder(Order $order)
    {
        $sql = "DELETE FROM detail_orders WHERE order_id = ?";
        $this->db->delete($sql, $order->getId());

        $sql = "DELETE FROM orders WHERE id = ?";
        $this->db->delete($sql, $order->getId());

        return true;
    }

    public function getRevenueByMonth()
    {
        $sql = "SELECT DATE_FORMAT(date_created, '%Y-%m-%d') as month, SUM(value) as total_revenue
            FROM orders
            WHERE status = 2
            GROUP BY DATE_FORMAT(date_created, '%Y-%m-%d')
            ORDER BY month";
        $result = $this->db->getAll($sql);

        $labels = [];
        $values = [];
        foreach ($result as $row) {
            $labels[] = $row['month'];
            $values[] = (float)$row['total_revenue'];
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
