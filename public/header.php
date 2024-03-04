<?php
$totalProductCount = $shop->getTotalProductCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- style -->
    <link rel="stylesheet" href="../style/style.css">
    <title></title>
</head>
<body>
    <header>
        <div class="nav container">
            <i class="bx bx-menu" id="menu-icon"></i>
            <a href="../public/home.php" class="logo">Budol Shop</a>
            <div class="navbar">
                <a href="#" class="nav-link">iPhone</a>
                <a href="#" class="nav-link">iPad</a>
                <a href="#" class="nav-link">Watch</a>
                <a href="#" class="nav-link">Tv & Home</a>
                <a href="#" class="nav-link">Accessories</a>
            </div>
            <a href="cart.php">
                <i class="bx bx-shopping-bag" id="cart-icon" data-quantity="<?= $totalProductCount ?>"></i>
            </a>
        </div>
    </header>
</body>
</html>