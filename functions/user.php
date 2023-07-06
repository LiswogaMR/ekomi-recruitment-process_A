<?php

    include("connection.php");
    
    class User {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        // Create a new user
        public function createUser($name, $email, $surname,$contactNo){

            //Check if the user already exists before adding a new one
            $UserQuery = "SELECT * FROM user WHERE email = :email";
            $UserQuery = $this->conn->prepare($UserQuery);
            $UserQuery->bindParam(':email', $email);
            $UserQuery->execute();

            if($UserQuery->rowCount() > 0){
                // User already exists, don't do anything 
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                exit();
            }else{

                $sql = "INSERT INTO user (name, email,surname,contactNo) VALUES (:name, :email, :surname, :contactNo)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':contactNo', $contactNo);
                $stmt->execute();
                
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();

            }
            
        }

        // Read all users
        public function getAllUsers() {
            $sql = "SELECT * FROM user";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Update a user
        public function updateUser($id, $name, $email, $surname,$contactNo) {
            $sql = "UPDATE user SET name = :name, email = :email, surname = :surname, contactNo = :contactNo WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':contactNo', $contactNo);
            $success = $stmt->execute();

            if ($success && $stmt->rowCount() > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
            }else{
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=2');
                exit();
            }
        }

        // Delete a user
        public function deleteUser($id) {
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $success = $stmt->execute();

            if ($success && $stmt->rowCount() > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
            }else{
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=2');
                exit();
            }
        }
    }

    $userModel = new User($conn);

?>
