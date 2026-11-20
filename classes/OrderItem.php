<?php
class OrderItem {
    private $orderItemID;
    private $orderID;
    private $productID;
    private $quantity;

    public function __construct($orderID = null, $productID = null, $quantity = null) {
        $this->orderID = $orderID;
        $this->productID = $productID;
        $this->quantity = $quantity;
    }

    // Getters
    public function getOrderItemID() {
        return $this->orderItemID;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getProductID() {
        return $this->productID;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    // Setters
    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function setProductID($productID) {
        $this->productID = $productID;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function save() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "INSERT INTO orderitem (orderID, productID, quantity) 
                 VALUES (:orderID, :productID, :quantity)";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindParam(":orderID", $this->orderID);
            $stmt->bindParam(":productID", $this->productID);
            $stmt->bindParam(":quantity", $this->quantity);

            if($stmt->execute()) {
                $this->orderItemID = $db->lastInsertId();
                return true;
            }
            return false;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public function delete() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "DELETE FROM orderitem WHERE orderItemID = :orderItemID";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":orderItemID", $this->orderItemID);

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public function update() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "UPDATE orderitem 
                 SET quantity = :quantity
                 WHERE orderItemID = :orderItemID";


        try {
            $stmt = $db->prepare($query);
            
            $stmt->bindParam(":quantity", $this->quantity);
            $stmt->bindParam(":orderItemID", $this->orderItemID);

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public static function getOrderItemsByOrderID($orderID) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT oi.quantity, p.productID, oi.orderItemID, p.name, p.price, p.imageBase64 
                    FROM orderitem oi
                    JOIN product p ON oi.productID = p.productID 
                    WHERE oi.orderID = :orderID";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":orderID", $orderID);
            $stmt->execute();

            $orderItems = [];
            while ($row = $stmt->fetch()) {
                $orderItems[] = [
                    'productID' => $row['productID'],
                    'orderItemID' => $row['orderItemID'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                    'imageBase64' => $row['imageBase64']
                ];
            }

            return $orderItems;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public static function getOrderItemByID($itemID) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM orderitem WHERE orderItemID = :itemID";


        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":itemID", $itemID);
            $stmt->execute();

            if ($row = $stmt->fetch()) {
                $orderItem = new OrderItem(
                    $row['orderID'],
                    $row['productID'],
                    $row['quantity']
                );
                $orderItem->orderItemID = $row['orderItemID'];
                return $orderItem;
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