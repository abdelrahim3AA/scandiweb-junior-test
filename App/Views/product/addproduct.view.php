<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>assets/css/addproduct.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="header-buttons">
        <h2>Add Product</h2>
        <div>
            <button type="button" id="saveBtn" class="save">Save</button>
            <a href="<?= BASE_URL ?>"><button type="button" class="cancel">Cancel</button></a>
        </div>
    </div>

    <div class="separator"></div>
    <div id="error-message" class="error-message"></div>

    <form id="product_form" data-action="<?= BASE_URL ?>product/store" method="post">
        <div class="main-btns">
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" required>
                <div id="skuError" class="sku-error"></div> <!-- SKU error will be shown here -->
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" required>
            </div>
        </div>

        <div class="dynamic_form">
            <div class="form-group">
                <label for="productType">Type Switcher</label>
                <select id="productType" name="productType" required>
                    <option value="">Type Switcher</option>
                    <option value="DVD" id="DVD">DVD</option>
                    <option value="Furniture" id="Furniture">Furniture</option>
                    <option value="Book" id="Book">Book</option>
                </select>
            </div>

            <div id="sizeField" class="hidden">
                <div class="form-group">
                    <label for="size">Size (MB)</label>
                    <input type="number" id="size" name="size">
                </div>
                <p class="product-desc">Please, provide size in MB for DVD-disk.</p>
            </div>

            <div id="dimensionField" class="hidden">
                <div class="form-group">
                    <label for="height">Height (CM)</label>
                    <input type="number" id="height" name="height">
                </div>
                <div class="form-group">
                    <label for="width">Width (CM)</label>
                    <input type="number" id="width" name="width">
                </div>
                <div class="form-group">
                    <label for="length">Length (CM)</label>
                    <input type="number" id="length" name="length">
                </div>
                <p class="product-desc">Please, provide dimensions in HxWxL format.</p>
            </div>

            <div id="weightField" class="hidden">
                <div class="form-group">
                    <label for="weight">Weight (KG)</label>
                    <input type="number" id="weight" name="weight">
                </div>
                <p class="product-desc">Please, provide weight in KG.</p>
            </div>
        </div>
    </form>

    <div class="footer_word">
        <div class="separator"></div>
        <p>Scandiweb Test Assignment</p>
    </div>
<script>
    baseUrl = "<?= BASE_URL ?>";
</script>
<script src="<?= PUBLIC_PATH  ?>assets/js/addproduct.js"></script>
</body>
</html>
