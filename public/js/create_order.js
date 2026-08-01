document.addEventListener('DOMContentLoaded', function () {
    const priceMap = [];
    document.querySelectorAll('.option_checkbox_item').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const quantityInput = document.querySelector(`#option_quantity_${checkbox.dataset.itemIndex}`);
            const subtotal = document.querySelector(`#option_subtotal_${checkbox.dataset.itemIndex}`);
            const tax = document.querySelector('#tax_price');
            const total = document.querySelector('#total_price');
            if (checkbox.checked) {
                priceMap[checkbox.dataset.itemIndex].enabled = true;
                subtotal.textContent = `$${(priceMap[checkbox.dataset.itemIndex].price * quantityInput.value).toFixed(2)}`;
            } else {
                priceMap[checkbox.dataset.itemIndex].enabled = false;
                subtotal.textContent = '$0.00';
            }
            document.querySelector('#subtotal_price').textContent = `$${calculateSubtotal()}`;
            tax.textContent = `$${(calculateSubtotal() * taxRate).toFixed(2)}`;
            total.textContent = `$${(calculateSubtotal() * (1 + taxRate)).toFixed(2)}`;
        });
        const quantityInput = document.querySelector(`#option_quantity_${checkbox.dataset.itemIndex}`);
        priceMap[checkbox.dataset.itemIndex] = {
            price: parseFloat(quantityInput.dataset.priceSnapshot),
            enabled: true,
        };
        quantityInput.addEventListener('input', function () {
            const price = priceMap[checkbox.dataset.itemIndex].price;
            const subtotal = document.querySelector(`#option_subtotal_${checkbox.dataset.itemIndex}`);
            const tax = document.querySelector('#tax_price');
            const total = document.querySelector('#total_price');
            subtotal.textContent = `$${(price * this.value).toFixed(2)}`;
            document.querySelector('#subtotal_price').textContent = `$${calculateSubtotal()}`;
            tax.textContent = `$${(calculateSubtotal() * taxRate).toFixed(2)}`;
            total.textContent = `$${(calculateSubtotal() * (1 + taxRate)).toFixed(2)}`;
        });
        quantityInput.dispatchEvent(new Event('input')); // Trigger initial calculation
    });
    function calculateSubtotal() {
        let subtotal = 0;
        for (const index in priceMap) {
            if (priceMap[index].enabled) {
                const quantityInput = document.querySelector(`#option_quantity_${index}`);
                subtotal += priceMap[index].price * parseFloat(quantityInput.value);
            }
        }
        return subtotal.toFixed(2);
    }
});
