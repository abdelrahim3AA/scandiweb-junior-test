<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>assets/css/index.css">
</head>
<body>

    <!-- Header Section: ADD and MASS DELETE buttons -->
    <div class="header-buttons">
        <div>
            <h2>Product List</h2>
        </div>
        <div>
           <a href="<?=  BASE_URL ?>add-product"><button type="button">ADD</button></a>
           <button type="button" id="delete-product-btn"  class="mass-delete">MASS DELETE</button>
        </div>
    </div>

    <!-- Separator Line -->
    <div class="separator"></div>

    <!-- Cart List with 4 items per row -->
    <!-- Mass Delete Form -->
<form action="<?= BASE_URL ?>product/deleteproducts" id="product_form" method="POST" >
    <div class="cart-list">
        <?php foreach ($_data as $product): ?>
            <div class="product-item">
                <input 
                    type="checkbox" 
                    name="products[]" 
                    value="<?= htmlspecialchars($product->getSku()) ?>" 
                    id="product-<?= htmlspecialchars($product->getSku()) ?>"
                    class="delete-checkbox"
                >
                <div class="product-details">
                    <span><?= htmlspecialchars($product->getSku()) ?></span> <!-- SKU -->
                    <span><?= htmlspecialchars($product->getName()) ?></span> <!-- Product Name -->
                    <span><?= htmlspecialchars($product->getPrice()) ?> $</span> <!-- Price -->
                    <span><?= htmlspecialchars($product->getSpecificDetails()) ?></span> <!-- Specific Details -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</form>
    <!-- Separator Line -->

    <!-- Separator Line -->
    
    <div class="footer_word">
        <div class="separatorFooter"></div>
        <p>Scandiweb Test assignment</p>
    </div>
    <script>
    baseUrl = "<?= BASE_URL ?>";
    </script>
    <script src="<?= PUBLIC_PATH ?>assets/js/deleteproducts.js"></script>
</body>
</html>
    
