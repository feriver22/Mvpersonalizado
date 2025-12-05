<?php

namespace Dao;

class Table {
    protected $tableName = "";
    protected $conn = null;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->conn = Dao::getConn();
    }

    public function getAll($orderBy = "id", $limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY {$orderBy}";
        if ($limit !== null) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function findBy($field, $value)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function findFirst($field, $value)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = :value LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function insert($data)
    {
        $fields = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO {$this->tableName} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public function update($id, $data)
    {
        $sets = implode(", ", array_map(function($k) { return "$k = ?"; }, array_keys($data)));
        $sql = "UPDATE {$this->tableName} SET {$sets} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $values = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->tableName}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result->total;
    }
}
?>
