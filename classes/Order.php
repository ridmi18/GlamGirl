<?php
class Order {
    private $orderID;
    private $customerID;
    private $paymentMethod;
    private $orderDate;
    private $status;
    private $totalAmount;
    
    public function __construct($orderID = null, $customerID = null, $paymentMethod = null, $orderDate = null, $status = null, $totalAmount = null) {
        $this->orderID = $orderID;
        $this->customerID = $customerID;
        $this->paymentMethod = $paymentMethod;
        $this->orderDate = $orderDate;
        $this->status = $status;
        $this->totalAmount = $totalAmount;
    }

    // Getters
    public function getOrderID() {
        return $this->orderID;
    }

    public function getCustomerID() {
        return $this->customerID;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTotalAmount() {
        return $this->totalAmount;
    }
    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }
    // Setters


    public function setCustomerID($customerID) {
        $this->customerID = $customerID;
    }



    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function setOrderDate($orderDate) {
        $this->orderDate = $orderDate;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setTotalAmount($totalAmount) {
        $this->totalAmount = $totalAmount;
    }

    public function save() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "INSERT INTO orders (customerID, paymentMethod, orderDate, status, totalAmount) 
                 VALUES (:customerID, :paymentMethod, :orderDate, :status, :totalAmount)";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindParam(":customerID", $this->customerID);
            $stmt->bindParam(":paymentMethod", $this->paymentMethod); 
            $stmt->bindParam(":orderDate", $this->orderDate);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":totalAmount", $this->totalAmount);

            if($stmt->execute()) {
                $this->orderID = $db->lastInsertId();
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

    public static function getOrderById($orderId) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM orders WHERE orderID = :orderId";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":orderId", $orderId);
            $stmt->execute();

            if ($row = $stmt->fetch()) {
                $order = new Order(
                    $row['customerID'],
                    $row['paymentMethod'],
                    $row['orderDate'],
                    $row['status'],
                    $row['totalAmount']
                );
                $order->orderID = $row['orderID'];
                return $order;
            }
            return null;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public static function delete($orderID) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        try {
            $sql = "UPDATE orders SET status = :status WHERE orderID  = :orderID ";
            $stmt = $db->prepare($sql);
            $status = "cancelled";
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":orderID", $orderID);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public static function updateStatus($orderID, $status) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "UPDATE orders SET status = :status WHERE orderID = :orderID";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":orderID", $orderID);

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    public static function update($orderID, $paymentMethod, $orderDate, $status, $totalAmount) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "UPDATE orders 
                    SET 
                        paymentMethod = :paymentMethod, 
                        orderDate = :orderDate,
                        status = :status,
                        totalAmount = :totalAmount


                    WHERE orderID = :orderID";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":paymentMethod", $paymentMethod);
            $stmt->bindParam(":orderDate", $orderDate);
            $stmt->bindParam(":status", $status); 
            $stmt->bindParam(":totalAmount", $totalAmount);
            $stmt->bindParam(":orderID", $orderID);



            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }

    public static function getOrdersByCustomerIDAndStatus($customerID, $status) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM orders 
                 WHERE customerID = :customerID 
                 AND status = :status
                 ORDER BY orderDate DESC";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":customerID", $customerID);
            $stmt->bindParam(":status", $status);
            $stmt->execute();

            $orders = [];
            while ($row = $stmt->fetch()) {
                $order = new Order(
                    $row['orderID'],
                    $row['customerID'],
                    $row['paymentMethod'],
                    $row['orderDate'], 
                    $row['status'],
                    $row['totalAmount']
                );
                $orders[] = $order;
            }

            return $orders;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }

    public static function getOrdersByCustomerID($customerID) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM orders 
                 WHERE customerID = :customerID
                 ORDER BY orderDate DESC";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":customerID", $customerID);
            $stmt->execute();

            $orders = [];
            while ($row = $stmt->fetch()) {
                $order = new Order(
                    $row['orderID'],
                    $row['customerID'],
                    $row['paymentMethod'],
                    $row['orderDate'], 
                    $row['status'],
                    $row['totalAmount']
                );
                $orders[] = $order;
            }

            return $orders;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
}



?>