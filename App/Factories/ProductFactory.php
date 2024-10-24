<?php

namespace App\Factories;

use App\Models\DVD;
use App\Models\Book;
use App\Models\Furniture;
use App\Models\Product;
use Exception;

class ProductFactory {
    public static function checkSku($sku) {
        return Product::checkSku($sku);
    }

    public static function create($productType, $data) {
        $productClasses = [
            'dvd' => DVD::class,
            'book' => Book::class,
            'furniture' => Furniture::class,
        ];
    
        // Map required fields for each product type
        $requiredFields = [
            'dvd' => ['sku', 'name', 'price', 'size'],
            'book' => ['sku', 'name', 'price', 'weight'], // Assuming 'weight' is needed for books
            'furniture' => ['sku', 'name', 'price', 'height', 'width', 'length'],
        ];
    
        // Normalize the product type to lowercase
        $productType = strtolower($productType);
    
        // Check if the product type exists in the mapping
        if (!isset($productClasses[$productType])) {
            throw new Exception("Invalid product type: $productType");
        }
    
        // Prepare required data based on the product type
        if (!isset($requiredFields[$productType])) {
            throw new Exception("No required fields defined for product type: $productType");
        }
    
        $requiredData = [];
        foreach ($requiredFields[$productType] as $field) {
            if (!isset($data[$field])) {
                throw new Exception("Missing required field: $field for product type: $productType");
            }
            $requiredData[] = $data[$field];
        }
    
        // Use reflection to pass data dynamically
        return new $productClasses[$productType](...$requiredData);
    }
    

}
