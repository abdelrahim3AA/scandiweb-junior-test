<?php

namespace App\Models; 

use App\Models\Product; 
use App\Core\Database;

class Book extends Product
{
    private $weight;
    private $db;

    public function __construct($sku, $name, $price, $weight) 
    {
        parent::__construct($sku, $name, $price);

        $this->weight = $weight;

        // Get the database connection instance
        $this->db = Database::getInstance()->getConnection();

    }
    public function save()
    {
        // Save in the `product` table
        $productSql = 'INSERT INTO `products` (sku, name, price, product_type) VALUES (?, ?, ?, ?)';
        $this->prepareAndExecute($productSql, [$this->sku, $this->name, $this->price, 'book']);

        // Get the last inserted product ID
        $productId = $this->db->lastInsertId();

        // Save in the `book_attributes` table
        $attributeSql = 'INSERT INTO `book_attributes` (product_id, weight) VALUES (?, ?)';
        $this->prepareAndExecute($attributeSql, [$productId, $this->weight]);
    }

    private function prepareAndExecute($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql); 
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function getSpecificDetails() {
        return "Weight: {$this->weight}KG";
    }
}