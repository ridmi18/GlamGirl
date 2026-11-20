<?php
// Include the database connection file
require_once 'classes/DatabaseConnector.php';
class User {
    private $userid;
    private $name;
    private $username;
    private $password;
    private $contactNumber;
    private $userType;

    public function __construct($name, $username, $password, $contactNumber, $userType) {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->contactNumber = $contactNumber;
        $this->userType = $userType;
    }

    // Getters
    public function getUserId() {
        return $this->userid;
    }

    public function getName() {
        return $this->name;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getContactNumber() {
        return $this->contactNumber;
    }

    public function getUserType() {
        return $this->userType;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    public function setContactNumber($contactNumber) {
        $this->contactNumber = $contactNumber;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
    }

    // Method to create a new user in the database
    public function create() {
        // Create a new Database instance
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        // Hash the password for security
        $this->password = password_hash($this->password, PASSWORD_DEFAULT); 

        // SQL query to insert a new user
        $query = "INSERT INTO user (name, username, password, contactNumber, userType) 
                  VALUES (:name, :username, :password, :contactNumber, :userType)";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':contactNumber', $this->contactNumber);
            $stmt->bindParam(':userType', $this->userType);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $database->closeConnection();
        }
    }
    
    public static function login($username, $password) {
        
        $database = new DatabaseConnector();
        $db = $database->getConnection();

        $query = "SELECT userid, username, password FROM user WHERE username = :username LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['userid'] = $user_data['userid'];
                $_SESSION['username'] = $user_data['username'];
                return true;
            } else {
                return false;
            }

        }
        return false;
    }
}
?>