<?php

namespace App\Models; 

use App\Models\Product; 
use App\Core\Database;

class Furniture extends Product
{
    private $length;
    private $width;
    private $height;
    private $db;

    public function __construct($sku, $name, $price, $length, $width, $height) 
    {
        parent::__construct($sku, $name, $price);

        $this->length = $length;
        $this->width = $width;
        $this->height = $height;

        // Get the database connection instance
        $this->db = Database::getInstance()->getConnection();

    }
    public function save()
    {
        // Save in the `product` table
        $productSql = 'INSERT INTO `products` (sku, name, price, product_type) VALUES (?, ?, ?, ?)';
        $this->prepareAndExecute($productSql, [$this->sku, $this->name, $this->price, 'furniture']);

        // Get the last inserted product ID
        $productId = $this->db->lastInsertId();

        // Save in the `furniture_attributes` table
        $attributeSql = 'INSERT INTO `furniture_attributes` (product_id, height, width, length) VALUES (?, ?, ?, ?)';
        $this->prepareAndExecute($attributeSql, [$productId, $this->height, $this->width, $this->length]);
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
        return "Dimensions: {$this->height}x{$this->width}x{$this->length}";
    }
}