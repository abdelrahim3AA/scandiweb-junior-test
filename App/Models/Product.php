<?php

namespace App\Models;

use App\Core\Database;
use App\Factories\ProductFactory;
use Exception;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }
    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }
    abstract public function getSpecificDetails();

    abstract public function save();

    // Check if SKU exists in the database
    public static function checkSku($sku)
    {
        // Get the database connection instance
        $db = Database::getInstance()->getConnection();

        // Prepare the query to check for existing SKU
        $stmt = $db->prepare('SELECT COUNT(*) FROM products WHERE sku = ?');
        $stmt->execute([$sku]);

        // Return true if SKU exists, otherwise false
        return $stmt->fetchColumn() > 0;
    }

    // Get all products from the database
    public static function all()
    {
        $db = Database::getInstance()->getConnection();

        // Step 1: Fetch all products from the main table
        $sql = "SELECT * FROM products";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $productObjects = [];

        foreach ($products as $productData) {
            $productType = strtolower($productData['product_type']);

            // Step 2: Fetch specific attributes for the product type
            $attributes = self::fetchAttributes($productType, $productData['id']);

            // Merge the attributes with the main product data
            $fullProductData = array_merge($productData, $attributes);

            try {
                // Step 3: Create the product object using the factory
                $productObjects[] = ProductFactory::create($productType, $fullProductData);
            } catch (Exception $e) {
                continue; // Skip invalid products
            }
        }

        return $productObjects;
    }

    // Helper function to fetch attributes based on product type
    private static function fetchAttributes($productType, $productId)
    {
        $db = Database::getInstance()->getConnection();

        switch ($productType) {
            case 'dvd':
                $sql = "SELECT size FROM dvd_attributes WHERE product_id = ?";
                break;
            case 'book':
                $sql = "SELECT weight FROM book_attributes WHERE product_id = ?";
                break;
            case 'furniture':
                $sql = "SELECT height, width, length FROM furniture_attributes WHERE product_id = ?";
                break;
            default:
                return []; // No additional attributes
        }

        $stmt = $db->prepare($sql);
        $stmt->execute([$productId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public static function deleteBySku($sku)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM products WHERE sku = ?');
        $stmt->execute([$sku]);
    }

}
