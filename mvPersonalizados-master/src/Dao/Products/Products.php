<?php

namespace Dao\Products;

use Dao\Dao;

class Products {
    
    public static function getAll($limit = null, $offset = 0)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM products WHERE active = 1 ORDER BY name";
        if ($limit !== null) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function getById($id)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM products WHERE id = :id AND active = 1 LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function getCount()
    {
        $conn = Dao::getConn();
        $sql = "SELECT COUNT(*) as total FROM products WHERE active = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result->total;
    }

    public static function create($name, $description, $price, $quantity, $image_url)
    {
        $conn = Dao::getConn();
        $sql = "INSERT INTO products (name, description, price, quantity, image_url, active, created_at) 
                VALUES (:name, :description, :price, :quantity, :image_url, 1, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':image_url', $image_url);
        return $stmt->execute();
    }

    public static function updateQuantity($id, $quantity)
    {
        $conn = Dao::getConn();
        $sql = "UPDATE products SET quantity = quantity - :qty WHERE id = :id AND quantity >= :qty";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':qty', $quantity);
        return $stmt->execute();
    }

    public static function getByName($name)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM products WHERE name LIKE :name AND active = 1";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%{$name}%";
        $stmt->bindParam(':name', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
?>
