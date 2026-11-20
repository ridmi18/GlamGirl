<?php
require_once 'DatabaseConnector.php';

class Feedback {
    private $feedbackID;
    private $orderID;
    private $customerID;
    private $rating;
    private $feedbackMessage;

    public function __construct($feedbackID = null, $orderID = null, $customerID = null, $rating = null, $feedbackMessage = null) {
        $this->feedbackID = $feedbackID;
        $this->orderID = $orderID;
        $this->customerID = $customerID;
        $this->rating = $rating;
        $this->feedbackMessage = $feedbackMessage;
    }

    public function getFeedbackID() {
        return $this->feedbackID;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function getCustomerID() {
        return $this->customerID;
    }

    public function setCustomerID($customerID) {
        $this->customerID = $customerID;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getFeedbackMessage() {
        return $this->feedbackMessage;
    }

    public function setFeedbackMessage($feedbackMessage) {
        $this->feedbackMessage = $feedbackMessage;
    }

    public function save() {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "INSERT INTO feedback (orderID, customerID, rating, feedbackMessage) 
                 VALUES (:orderID, :customerID, :rating, :feedbackMessage)";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":orderID", $this->orderID);
            $stmt->bindParam(":customerID", $this->customerID);
            $stmt->bindParam(":rating", $this->rating);
            $stmt->bindParam(":feedbackMessage", $this->feedbackMessage);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }

    public static function getFeedbackByOrderID($orderID) {
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT * FROM feedback WHERE orderID = :orderID";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(":orderID", $orderID);
            $stmt->execute();

            if ($row = $stmt->fetch()) {
                return new Feedback(
                    $row['feedbackID'],
                    $row['orderID'],
                    $row['customerID'],
                    $row['rating'],
                    $row['feedbackMessage']
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
