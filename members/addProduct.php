<?php 
    require_once("../function.php");
    $msg = '';
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $msg = $shop->AddProduct();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <?php if (!empty($msg) && strpos($msg, 'Error') == 0) { ?>
            <span class="error"><?= $msg ?></span>
        <?php } elseif(!empty($msg)) { ?>
            <span class="sucess"><?= $msg ?></span>
        <?php } ?>
        <select name="folder" id="">
            <option value="">---</option>
            <?php
                $folderDirectory = "../assets/"; 
                $folders = array_filter(glob($folderDirectory . '*'), 'is_dir');

                foreach ($folders as $folder) {
                    $folderName = basename($folder);
                    echo "<option value='$folderName'>$folderName</option>";
                }
            ?>
        </select>
        <input type="text" name="ProductName" id="">
        <input type="text" name="brand" id="" placeholder="Band">
        <input type="text" name="price" id="" inputmode="numeric" placeholder="Type">
        <input type="file" name="image" accept=".jpg, .jpeg, .png">
        <button type="submit" name="Add">ADD</button>
    </form>
    <a href="category.php">Add category</a>
</body>
</html>