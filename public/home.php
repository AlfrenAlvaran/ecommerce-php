
<?php
require_once("../function.php");

// Start or resume the session
session_start();

// if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addtocart'])) {
//     $productId = $_POST['product_id'];
//     $productName = $_POST['product_name'];
//     $productPrice = $_POST['product_price'];
//     $productQuantity = $_POST['product_quantity'];
//     $productImg = $_POST['product_img'];

//     // Create an array to store the product details
//     $productDetails = [
//         'id' => $productId,
//         'name' => $productName,
//         'price' => $productPrice,
//         'quantity' => $productQuantity,
//         'img' => $productImg
//     ];

//     // Insert product into the database
//     $inserted = $shop->CheckOut($productDetails);

//     if ($inserted) {
//         // Product successfully inserted, add it to the cart session array
//         $_SESSION['cart'][] = $productDetails;
//     }
// }

// Process form submission
// Process form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'product_id_') !== false && isset($_POST['product_name_' . $_POST[$key]])) {
            $productId = $_POST[$key];
            $productName = $_POST['product_name_' . $productId];
            $productPrice = $_POST['product_price_' . $productId];
            $productQuantity = $_POST['product_quantity_' . $productId];
            $productImg = $_POST['product_img_' . $productId];

         
            $buttonName = 'addtocart_' . $productId;
            if (isset($_POST[$buttonName])) {
               
                $productDetails = [
                    'id' => $productId,
                    'name' => $productName,
                    'price' => $productPrice,
                    'quantity' => $productQuantity,
                    'img' => $productImg
                ];

                
                $inserted = $shop->CheckOut($productDetails);

                if ($inserted) {
                    
                    $_SESSION['cart'][] = $productDetails;
                }
            }
        }
    }
}


if (!isset($_SESSION['products']) || !isset($_POST['addtocart'])) {
    $_SESSION['products'] = $shop->getProducts();
    $products = $_SESSION['products'];
}

$products = $_SESSION['products'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Home</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
</head>
<body>
    <?php include "header.php"; ?>
   <!-- home or header page -->
  
   <!-- products -->
   <section class="section-p1" id="products">
    <h2 class="heading">Discover Feature</h2>
   </section>

   <section class="section-p1" id="product1">
    <form method="post" class="products-container">
        <?php 
        if (isset($products) && !empty($products)) {
            foreach($products as $product) {?>
                <div class="product">
                    <img src="../assets/<?= $product['img'] ?>" alt="">
                    <div class="des">
                        <span><?= $product['brand'] ?></span>
                        <h5><?= $product['productName'] ?></h5>
                        <h4>₱ <?= number_format($product['price'], 2, '.', '.') ?></h4>
                        <!-- Hidden input fields to store product details -->
                        <input type="hidden" name="product_id_<?= $product['id'] ?>" value="<?= $product['id'] ?>">
                        <input type="hidden" name="product_name_<?= $product['id'] ?>" value="<?= $product['productName'] ?>">
                        <input type="hidden" name="product_price_<?= $product['id'] ?>" value="<?= $product['price'] ?>">
                        <input type="hidden" name="product_quantity_<?= $product['id'] ?>" value="1">
                        <input type="hidden" name="product_img_<?= $product['id'] ?>" value="../assets/<?= $product['img'] ?>">
                        <button type="submit" name="addtocart_<?= $product['id'] ?>">
                            <i class="fas fa-shopping-cart" id="cart"></i>
                        </button>
                    </div>
                </div>
            <?php }
        } else {
            echo "<p>No products available</p>";
        }
        ?>
    </form>
    </section>
</body>
</html>