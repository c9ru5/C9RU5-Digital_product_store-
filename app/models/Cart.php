<?php
namespace App\Models;

use App\Core\Model;

class Cart {
    private $id;
    private $user_id;
    private $detail_id;
    private $detail_quantity;
    private $product_id;
    private $db;

    public function __construct(){$this->db = new Model();}
    public function setId($id){return $this->id = $id;}
    public function getId(){return $this->id;}
    public function setUserId($user_id){return $this->user_id = $user_id;}
    public function getUserId(){return $this->user_id;}
    public function setDetailId($detail_id){return $this->detail_id = $detail_id;}
    public function getDetailId(){return $this->detail_id;}
    public function setDetailQuantity($detail_quantity){return $this->detail_quantity = $detail_quantity;}
    public function getDetailQuantity(){return $this->detail_quantity;}
    public function setProductId($product_id){return $this->product_id = $product_id;}
    public function getProductId(){return $this->product_id;}

    public function getCart(Cart $cart) {
        $sql = "SELECT C.*, D.*, P.*,
                D.id AS detail_id, 
                D.quantity AS cart_quantity,
                P.quantity AS stock_quantity 
                FROM users U
                JOIN carts C ON C.user_id = U.id
                JOIN detail_carts D ON D.cart_id = C.id
                JOIN products P ON P.id = D.product_id
                WHERE U.id = ?";
        $result = $this->db->getAll($sql, $cart->getUserId());
        return (!empty($result)) ? $result : false; // Trả về false nếu không có dữ liệu
    }

    public function insertCart(Cart $cart) {
        // Kiểm tra xem giỏ hàng của user đã tồn tại chưa
        $checkCart = $this->db->getOne("SELECT * FROM carts WHERE user_id = ?", $cart->getUserId());
    
        if (!$checkCart) {
            // Nếu chưa có giỏ hàng, tạo mới
            $this->db->insert("INSERT INTO carts (user_id) VALUES (?)", $cart->getUserId());
            $cart_id = $this->db->getLastInsertId();
        } else {
            $cart_id = $checkCart['id']; // ✅ Lấy ID từ DB thay vì getId()
        }
    
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $detail = $this->db->getOne("SELECT * FROM detail_carts WHERE cart_id = ? AND product_id = ?", $cart_id, $cart->getProductId());
    
        if ($detail) {
            // Nếu đã có, cập nhật số lượng
            $new_quantity = $detail['quantity'] + $cart->getDetailQuantity();
            $this->db->insert("UPDATE detail_carts SET quantity = ? WHERE cart_id = ? AND product_id = ?", $new_quantity, $cart_id, $cart->getProductId());
        } else {
            // Nếu chưa có, thêm mới
            $this->db->insert("INSERT INTO detail_carts (cart_id, product_id, quantity) VALUES (?, ?, ?)", $cart_id, $cart->getProductId(), $cart->getDetailQuantity());
        }
    
        return true;
    }

    public function increaseCart(Cart $cart) {
        $sql = "UPDATE detail_carts SET quantity = quantity+1 WHERE id = ?";
        return $this->db->update($sql, $cart->getDetailId());
    }

    public function decreaseCart(Cart $cart) {
        // Kiểm tra số lượng hiện tại
        $sql_check = "SELECT quantity FROM detail_carts WHERE id = ?";
        $quantity = $this->db->fetchColumn($sql_check, $cart->getDetailId());
    
        if ($quantity > 1) {
            // Nếu số lượng lớn hơn 1 thì giảm số lượng
            $sql = "UPDATE detail_carts SET quantity = quantity - 1 WHERE id = ?";
            return $this->db->update($sql, $cart->getDetailId());
        } else {
            // Nếu số lượng = 1 thì xóa sản phẩm khỏi giỏ hàng
            $sql_delete = "DELETE FROM detail_carts WHERE id = ?";
            return $this->db->delete($sql_delete, $cart->getDetailId());
        }
    }
    

    public function deleteCart(Cart $cart) {
        $sql = "DELETE FROM detail_carts WHERE id = ?";
        return $this->db->delete($sql, $cart->getDetailId());
    }
    
    
}