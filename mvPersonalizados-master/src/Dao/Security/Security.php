<?php

namespace Dao\Security;

use Dao\Dao;

class Security {
    
    public static function getUserByEmail($email)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function getUserById($id)
    {
        $conn = Dao::getConn();
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function createUser($name, $email, $password)
    {
        $conn = Dao::getConn();
        $sql = "INSERT INTO users (name, email, password, created_at) VALUES (:name, :email, :password, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    public static function updateUser($id, $name, $email)
    {
        $conn = Dao::getConn();
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
?>
