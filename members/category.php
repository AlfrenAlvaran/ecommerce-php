<?php
require_once("../function.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop->addCategory();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
</head>
<body>
    <form method="post">
        <div class="input-box">
            <input type="text" name="category">
        </div>

        <button type="submit" name="addCaegory">add</button>
    </form>
    <a href="addProduct.php">Back</a>
</body>
</html>