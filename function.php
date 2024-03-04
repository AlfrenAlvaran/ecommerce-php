<?php

class eShop {
    private $server = "mysql:host=localhost;dbname=eShop";
    private $username = "root";
    private $password = "chen0502";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $conn;
    public function OpenConnection () {
        try{
            $this->conn = new PDO($this->server,$this->username,$this->password,$this->options);
            return $this->conn;
        }catch(PDOException $e) {
            echo "There was probelem in the connection: ".$e->getMessage();
        }
    }


    public function addCategory () {
        if (isset($_POST['addCaegory'])) {
            $folderDirectory = "../assets/";
            $foldername = $_POST['category'];
            $folderPath = $folderDirectory . $foldername;

            if (!is_dir($folderPath)) {
                if (mkdir ($folderPath, 0777, true)) {
                    return "Successful created";
                }else {
                    return "Error: Fiald to create a folder";
                }
            }else {
                echo "Error: Folder is already exist";
            }
            // if (!is_dir($foldername)) {
            //     if(mkdir($foldername)) {
            //         echo  "Folder Created";
            //     }else {
            //         echo "Faild to create a folder";
            //     }
            // }else {
            //     echo "Folder is already exist";
            // }
        }
    }
    public function GetSIZE ($size) {
        $kb = $size  / 1024;
        $format = number_format($kb, 2);
        return $format;
    }
    // Add Product 
    public function AddProduct () {
        if (isset($_POST['Add'])){
            $folder = "../assets/" . $_POST['folder'];
            $ProductName = $_POST['ProductName'];
            $filename = $_FILES['image']['name'];
            $tmpname = $_FILES['image']['tmp_name'];
            $validate = ['jpg', 'jpeg', 'png'];
            $size = $this->GetSIZE($_FILES['image']['size']);
            $imgExtension = explode('.', $filename);
            $imgExtension = strtolower(end($imgExtension));
            $brand = $_POST['brand'];
            $price = $_POST['price'];
            if (!in_array($imgExtension,$validate)) {
                return "Error: Image invalid should be format JPG JPEG PNG";
            } else if ($size < 4.0) {
                return "Error: Image too large";
            } else {
                $newImgName = uniqid(). "." . $imgExtension;
                $uploadPath = $folder . '/' . $newImgName;
                
                if(move_uploaded_file($tmpname, $uploadPath)){
                    $connection = $this->OpenConnection();
                    $stmt = $connection->prepare("INSERT INTO `product`(`productName`, `img`, brand, price) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$ProductName, $uploadPath, $brand, $price]);
                    return "Successful upload";
                }
            }
        }
    }
    // End Add Product 

    // Get Products
    public function getProducts () {
        $con = $this->OpenConnection();
        $stmt = $con->prepare("SELECT * FROM product");
        $stmt->execute();
        $products = $stmt->fetchAll();
        $total = $stmt->rowCount();

        if ($total > 0) {
            return $products;
        }else {
            return FALSE;
        }
    }
    // End get products
    public function getTotalProductCount () {
        $connection =$this->OpenConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) AS total FROM cart");
        $stmt->execute();
        $count = $stmt->fetch();

        return isset($count['total']) ? $count['total'] : 0;
    }
    // Check Out 
    public function CheckOut($productDetails) {
        $name = $productDetails['name'];
        $price = $productDetails['price'];
        $qty = $productDetails['quantity'];
        $img = $productDetails['img'];
        $cartId = uniqid();
        $con = $this->OpenConnection();
        $stm = $con->prepare("INSERT INTO `cart` (`cart_id`, `img`, `productname`, `qty`, `price`) VALUES (?, ?, ?, ?, ?)");
        return $stm->execute([$cartId, $img, $name, $qty, $price]);
    }
    // check out

    public function getCart() {
        $conn = $this->OpenConnection();
        $stm = $conn->prepare("SELECT * FROM cart ");
        $stm->execute();
        $cart = $stm->fetchAll();
        $total = $stm->rowCount();

        if($total > 0) {
            return $cart;
        } else {
            return false;
        }
    }


    public function RemoveCart() {
       if(isset($_POST['removeCart'])) {
        $CartId = $_POST['cartId'];
        $conn = $this->OpenConnection();
        $stm = $conn->prepare("DELETE FROM `cart` WHERE `cart_id` = ?");
        $stm->execute([$CartId]);
       }
    }
}

// End class
$shop = new eShop();