<?php

namespace Dao\Cart;

use Dao\Dao;

class Cart {
    
    public static function createTransaction($user_id, $total_amount, $status = 'PENDING')
    {
        $conn = Dao::getConn();
        $transaction_id = uniqid('TRX_');
        $sql = "INSERT INTO transactions (transaction_id, user_id, total_amount, status, created_at) 
                VALUES (:transaction_id, :user_id, :total_amount, :status, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':status', $status);
        $result = $stmt->execute();
        
        if ($result) {
            return $conn->lastInsertId();
        }
        return false;
    }

    public static function getTransactionById($id)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM transactions WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function getTransactionByTransactionId($transaction_id)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM transactions WHERE transaction_id = :transaction_id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function updateTransactionStatus($id, $status, $paypal_order_id = null)
    {
        $conn = Dao::getConn();
        $sql = "UPDATE transactions SET status = :status, paypal_order_id = :paypal_order_id, updated_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':paypal_order_id', $paypal_order_id);
        return $stmt->execute();
    }

    public static function getTransactionsByUser($user_id, $limit = null, $offset = 0)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function addTransactionItem($transaction_id, $product_id, $quantity, $unit_price)
    {
        $conn = Dao::getConn();
        $sql = "INSERT INTO transaction_items (transaction_id, product_id, quantity, unit_price) 
                VALUES (:transaction_id, :product_id, :quantity, :unit_price)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_price', $unit_price);
        return $stmt->execute();
    }

    public static function getTransactionItems($transaction_id)
    {
        $conn = Dao::getConn();
        $sql = "SELECT ti.*, p.name, p.image_url 
                FROM transaction_items ti 
                JOIN products p ON ti.product_id = p.id 
                WHERE ti.transaction_id = :transaction_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
?>
