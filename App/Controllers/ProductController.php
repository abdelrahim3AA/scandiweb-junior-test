<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Factories\ProductFactory;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    public function indexAction() {
        $products = Product::all();
        return $this->_view($products);
    }

    public function addproductAction() {
        return $this->_view([]);
    }
    public function storeAction()
    {
        $data = $_POST;
        $productType = $data['productType'] ?? null; // Ensure productType is set
        header('Content-Type: application/json');

        try {
            // Validate required fields
            if (!$productType || empty($data['sku'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing required fields.'
                ]);
                exit;
            }

            // Check if SKU already exists
            if (ProductFactory::checkSku($data['sku'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'SKU already exists!'
                ]);
                exit;
            }

            // Create and save product
            $product = ProductFactory::create($productType, $data);
            $product->save();

            // Return success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Product added successfully!'
            ]);

        } catch (Exception $e) {
            // Handle any exceptions and return the error message
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        exit; // Ensure no further output
    }


    public function deleteproductsAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['products'])) {
            $productsToDelete = $_POST['products']; // Array of selected SKUs

            foreach ($productsToDelete as $sku) {
                Product::deleteBySku($sku);
            }

            // Redirect back to the product list with a success message
            header('Location: http://localhost/scandiweb_test/');
            exit();
        } else {
            // Handle case where no products are selected
            echo "No products selected for deletion.";
        }
    }

}
