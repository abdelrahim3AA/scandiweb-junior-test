document.addEventListener('DOMContentLoaded', function () {
    const productType = document.getElementById('productType');
    const sizeField = document.getElementById('sizeField');
    const dimensionField = document.getElementById('dimensionField');
    const weightField = document.getElementById('weightField');
    const saveBtn = document.getElementById('saveBtn');
    const form = document.getElementById('product_form');
    const errorMessageDiv = document.getElementById('error-message');
    const skuError = document.getElementById('skuError'); // Element for SKU errors

    // Show/Hide fields based on selected product type
    productType.addEventListener('change', function () {
        // Remove 'required' from all fields
        document.querySelectorAll('input[required]').forEach(input => input.removeAttribute('required'));

        // Hide all fields
        sizeField.classList.add('hidden');
        dimensionField.classList.add('hidden');
        weightField.classList.add('hidden');

        // Add 'required' for the appropriate field based on selected type
        switch (this.value) {
            case 'dvd':
                sizeField.classList.remove('hidden');
                document.getElementById('size').setAttribute('required', 'required');
                break;
            case 'furniture':
                dimensionField.classList.remove('hidden');
                document.getElementById('height').setAttribute('required', 'required');
                document.getElementById('width').setAttribute('required', 'required');
                document.getElementById('length').setAttribute('required', 'required');
                break;
            case 'book':
                weightField.classList.remove('hidden');
                document.getElementById('weight').setAttribute('required', 'required');
                break;
        }
    });

    // Handle form submission with fetch API
    saveBtn.addEventListener('click', async function (event) {
        event.preventDefault(); // Prevent default form submission
        hideErrorMessages(); // Clear previous error messages

        // Validate form before submission
        if (!form.checkValidity()) {
            displayErrorMessage('Please, submit required data.');
            return;
        }

        // Validate inputs before submission
        if (!validateInputs()) {
            return; // If validation fails, do not proceed
        }

        const formData = new FormData(form); // Collect form data
        const actionUrl = form.getAttribute('data-action'); // Get action URL from data attribute

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData
            });

            // Check if the response is ok
            if (!response.ok) {
                throw new Error('Network response was not ok'); // Handle network errors
            }

            const data = await response.json(); // Parse the JSON response

            if (data.status === 'error') {
                if (data.message.includes('SKU already exists!')) {
                    displayErrorMessage(data.message); // Show SKU error
                } else {
                    displayErrorMessage(data.message); // Show other error messages
                }
            } else {
                window.location.href = baseUrl; // Redirect to home page on success
            }
        } catch (error) {
            console.error('Error:', error);
            displayErrorMessage('An error occurred. Please try again.'); // Handle any network errors
        }
    });

     // Function to validate inputs
     function validateInputs() {
        let isValid = true;
        hideErrorMessages(); // Hide previous error messages

        // Check that all required fields are filled
        const requiredFields = [
            document.getElementById('sku'),
            document.getElementById('name'),
            document.getElementById('price')
        ];
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                displayErrorMessage('Please, submit required data.'); // Error message for empty fields
                isValid = false;
            }
        });

        // Validate price value
        const price = parseFloat(document.getElementById('price').value);
        if (isNaN(price) || price <= 0) {
            displayErrorMessage('Please, provide a valid price.'); // Error message for invalid price
            isValid = false;
        }

        // Validate size if product is DVD
        const size = parseFloat(document.getElementById('size').value);
        if (productType.value === 'dvd' && (isNaN(size) || size <= 0)) {
            displayErrorMessage('Please, provide a valid size for DVD.'); // Error message for invalid size
            isValid = false;
        }

        // Validate dimensions if product is Furniture
        const height = parseFloat(document.getElementById('height').value);
        const width = parseFloat(document.getElementById('width').value);
        const length = parseFloat(document.getElementById('length').value);
        if (productType.value === 'furniture' && (isNaN(height) || height <= 0 || isNaN(width) || width <= 0 || isNaN(length) || length <= 0)) {
            displayErrorMessage('Please, provide valid dimensions for furniture.'); // Error message for invalid dimensions
            isValid = false;
        }

        // Validate weight if product is Book
        const weight = parseFloat(document.getElementById('weight').value);
        if (productType.value === 'book' && (isNaN(weight) || weight <= 0)) {
            displayErrorMessage('Please, provide a valid weight for the book.'); // Error message for invalid weight
            isValid = false;
        }

        return isValid;
    }

    // Function to display general error messages
    function displayErrorMessage(message) {
        errorMessageDiv.textContent = message;
        errorMessageDiv.style.display = 'block';
    }

    // Function to display SKU error messages next to SKU field
    function displaySkuError(message) {
        skuError.textContent = message;
        skuError.style.display = 'block';
    }

    // Function to hide all error messages
    function hideErrorMessages() {
        errorMessageDiv.style.display = 'none';
        skuError.style.display = 'none';
    }
});
