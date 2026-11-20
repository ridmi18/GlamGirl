<?php
require_once 'classes/DatabaseConnector.php';

class BillingInformation {
    private $id;
    private $orderId;
    private $fullName;
    private $email;
    private $address;
    private $city;
    private $zip;
    private $phone;

    public function __construct($orderId, $fullName, $email, $address, $city, $zip, $phone) {
        $this->orderId = $orderId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
    }

    public function create() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "INSERT INTO billing_information (order_id, full_name, email, address, city, zip, phone) 
                 VALUES (:orderId, :fullName, :email, :address, :city, :zip, :phone)";
        try {
            $stmt = $db->prepare($query);

            $stmt->bindParam(':orderId', $this->orderId);
            $stmt->bindParam(':fullName', $this->fullName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':zip', $this->zip);
            $stmt->bindParam(':phone', $this->phone);

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZip() {
        return $this->zip;
    }

    public function getPhone() {
        return $this->phone;
    }

    // Setters
    public function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
}
?>
