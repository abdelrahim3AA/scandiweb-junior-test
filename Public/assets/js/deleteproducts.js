document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('product_form');
    const deleteBtn = document.getElementById('mass-delete-btn');

    deleteBtn.addEventListener('click', function () {
        // Query the checkboxes inside the click event to get the updated state
        const checkedBoxes = document.querySelectorAll('input[name="products[]"]:checked');
    
        if (checkedBoxes.length > 0) {
            productForm.submit(); // Submit the form if any checkbox is checked
        }        
        
    });
});
