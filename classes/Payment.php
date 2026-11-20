<?php
class Payment {
    private $paymentID;
    private $orderID;
    private $paymentDate;
    private $amount;
    private $paymentStatus;

    public function __construct($paymentID, $orderID, $paymentDate, $amount, $paymentStatus) {
        $this->paymentID = $paymentID;
        $this->orderID = $orderID;
        $this->paymentDate = $paymentDate;
        $this->amount = $amount;
        $this->paymentStatus = $paymentStatus;
    }

    // Getters
    public function getPaymentID() {
        return $this->paymentID;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPaymentStatus() {
        return $this->paymentStatus;
    }

    // Setters
    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function setPaymentDate($paymentDate) {
        $this->paymentDate = $paymentDate;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setPaymentStatus($paymentStatus) {
        $this->paymentStatus = $paymentStatus;
    }
}
?>