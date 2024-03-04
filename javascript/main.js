document.addEventListener("DOMContentLoaded", load);

function updateSubtotal(index) {
    const quantityInput = document.getElementById(`quantity_${index}`);
    const price = aggregatedProducts[index].price;
    const subtotalElement = document.getElementById(`subtotal_${index}`);

    const quantity = parseInt(quantityInput.value);
    const subtotal = (quantity * price).toFixed(2);
    subtotalElement.textContent = `$${subtotal}`;
}

function load() {
    if (window.location.pathname.includes("cart.php")) {
        aggregatedProducts.forEach((product, index) => {
            updateSubtotal(index);
        });
    }
}
load();
