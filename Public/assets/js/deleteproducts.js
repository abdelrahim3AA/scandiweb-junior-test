document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('product_form');
    const deleteBtn = document.getElementById('delete-product-btn');

    deleteBtn.addEventListener('click', async function (event) {
        event.preventDefault(); // Prevent default to manage submission for tests

        const checkedBoxes = document.querySelectorAll('input[name="products[]"]:checked');

        if (checkedBoxes.length > 0) {
            productForm.submit(); // Submit the form if at least one product is selected
        }
    });
});
