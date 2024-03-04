<?php 
require_once("../function.php");
$carts = $shop->getCart();

$aggregatedProducts = [];
foreach ($carts as $item) {
    $productName = $item['productname'];
    $productPrice = $item['price'];

    $key = $productName . '_' . $productPrice;

    if (!array_key_exists($key, $aggregatedProducts)) {
        $aggregatedProducts[$key] = $item;
    } else {
        $aggregatedProducts[$key]['qty'] += $item['qty'];
    }
}

$aggregatedProductsJSON = json_encode(array_values($aggregatedProducts));


if($_SERVER['REQUEST_METHOD'] == "POST") {
    // $CartID = $_POST['cartId'];
    $shop->RemoveCart();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="../style/cart.css">
</head>
<body>
    <?php include "header.php"; ?>  
    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($aggregatedProducts as $index => $item) { ?>
                    <tr>
                        <form method="post">
                        <input type="hidden" name="cartId" value="<?= $item['cart_id'] ?>">
                        <td><button type="submit" name="removeCart"><i class="fas fa-times-circle"></i></button></td>
                        </form>
                        <td><img src="<?= $item['img']?>" alt=""></td>
                        <td><?= $item['productname']?></td>
                        <td>₱<?= number_format($item['price'], 2, '.', ',')?></td>
                        <td><input type="number" id="quantity_<?= $index ?>" class="quantity-input" value="<?= $item['qty'] ?>"></td>
                        <td class="subtotal" id="subtotal_<?= $index ?>">₱ <?= number_format($item['price'] * $item['qty'], 2, '.', ',') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
                    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const aggregatedProducts = <?= $aggregatedProductsJSON ?>;

            function updateSubtotal(index) {
                const quantityInput = document.getElementById(`quantity_${index}`);
                const subtotalElement = document.getElementById(`subtotal_${index}`);

                if (quantityInput && subtotalElement) {
                    const price = aggregatedProducts[index].price;
                    const quantity = parseInt(quantityInput.value);
                    const subtotal = (quantity * price).toFixed(2);

                    subtotalElement.textContent = `$${subtotal}`;
                }
            }

            function load() {
                if (window.location.pathname.includes("cart.php")) {
                    const quantityInputs = document.querySelectorAll(".quantity-input");
                    quantityInputs.forEach((input, index) => {
                        input.addEventListener("change", () => {
                            updateSubtotal(index);
                        });
                    });

                    aggregatedProducts.forEach((product, index) => {
                        updateSubtotal(index);
                    });
                }
            }

            load();
        });
    </script>
</body>
</html>
