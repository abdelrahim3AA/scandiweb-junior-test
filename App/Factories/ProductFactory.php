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
        switch (strtolower($productType)) {  // Case-insensitive comparison
            case 'dvd':
                return new DVD($data['sku'], $data['name'], $data['price'], $data['size']);
            case 'book':
                return new Book($data['sku'], $data['name'], $data['price'], $data['weight']);
            case 'furniture':
                return new Furniture(
                    $data['sku'], $data['name'], $data['price'], 
                    $data['height'], $data['width'], $data['length']
                );
            default:
                throw new Exception("Invalid product type: $productType");
        }
    }
}