<?php
require_once 'DatabaseConnector.php';

class Product {
    private $productID;
    private $name;
    private $description;
    private $type;
    private $price;
    private $stockQuantity;
    private $imageBase64;

    public function __construct($productID, $name, $description, $type, $price, $stockQuantity, $imageBase64) {
        $this->productID = $productID;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->imageBase64 = $imageBase64;
    }
    public function getProductID() {
        return $this->productID;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getType() {
        return $this->type;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStockQuantity() {
        return $this->stockQuantity;
    }

    public function getImageBase64() {
        return $this->imageBase64;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setStockQuantity($stockQuantity) {
        $this->stockQuantity = $stockQuantity;
    }

    public function setImageBase64($imageBase64) {
        $this->imageBase64 = $imageBase64;
    }

    public static function getAllProducts() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM product";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute();

            $products = [];
            while ($row = $stmt->fetch()) {
                $product = new Product(
                    $row['productID'],
                    $row['name'],
                    $row['description'], 
                    $row['type'],
                    $row['price'],
                    $row['stockQuantity'],
                    $row['imageBase64']
                );
                $products[] = $product;
            }

            return $products;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    // Method to get a product by ID from the database
    public static function getProductByID($productID) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM product WHERE productID = :productID";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":productID", $productID);
            $stmt->execute();

            if ($row = $stmt->fetch()) {
                return new Product(
                    $row['productID'],
                    $row['name'], 
                    $row['description'],
                    $row['type'],
                    $row['price'],
                    $row['stockQuantity'],
                    $row['imageBase64']
                );
            }
            return null;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
}
?>