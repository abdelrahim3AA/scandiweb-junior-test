<?php

namespace App\Models; 

use App\Models\Product; 
use App\Core\Database;

class DVD extends Product
{
    private $size;
    private $db;

    public function __construct($sku, $name, $price, $size) 
    {
        parent::__construct($sku, $name, $price);

        $this->size = $size;

        // Get the database connection instance
        $this->db = Database::getInstance()->getConnection();

    }
    public function save()
    {
        // Save in the `product` table
        $productSql = 'INSERT INTO `products` (sku, name, price, product_type) VALUES (?, ?, ?, ?)';
        $this->prepareAndExecute($productSql, [$this->sku, $this->name, $this->price, 'dvd']);

        // Get the last inserted product ID
        $productId = $this->db->lastInsertId();

        // Save in the `dvd_attributes` table
        $attributeSql = 'INSERT INTO `dvd_attributes` (product_id, size) VALUES (?, ?)';
        $this->prepareAndExecute($attributeSql, [$productId, $this->size]);
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
        return "Size: {$this->size} MB";
    }
}