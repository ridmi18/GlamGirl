<?php
class ContactUs {
    private $contactID;
    private $name;
    private $message;

    public function __construct($contactID, $name, $message) {
        $this->contactID = $contactID;
        $this->name = $name;
        $this->message = $message;
    }

    // Getters
    public function getContactID() {
        return $this->contactID;
    }

    public function getName() {
        return $this->name;
    }

    public function getMessage() {
        return $this->message;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
}
?>