<?php

    include("connection.php");
    include('session_data.php');
    
    class User {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        //user login
        public function loginUser($email, $password) {
            // Check if user exists based on email
            $sql = "SELECT * FROM authentication WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if(!$user){
                //User does not exist
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                exit();
            }
            // Verify the hashed password
            if(password_verify($password, $user['password'])){
             
                session_start();
                $_SESSION['user'] = $user;
                unset($_SESSION['user']['password']);

                // Login successful
                $permission_group_id = $_SESSION['user']['permission_group_id'];
                if($permission_group_id == '2' ){ 
                    die(header("Location: ../employee-job-task.php"));
                }else{
                    die(header("Location: ../admin-job-task.php"));
                }
                
            }else{
                // return false; // Incorrect password
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
            }
        }

        public function changePassword($email, $password){
            // Check if user exists based on email
            $sql = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            //hash the password for security purpose
            $password = password_hash($password, PASSWORD_DEFAULT);
            $id = $user['id'];

            $sql = "UPDATE user SET password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $password);
            $success = $stmt->execute();

            if($success && $stmt->rowCount() > 0) {
                // Login successful
                $permission_group_id = $_SESSION['user']['permission_group_id'];
                if($permission_group_id == '2' ){ 
                    header("Location: ../employee-job-task.php");
                }else{
                    header("Location: ../admin-job-task.php");
                }
            }else{
                // Something Went Wrong
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
            }
        }

        // Create a new user
        public function createUser($name, $email, $surname,$contactNo, $permission_group_id, $password){

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

                //hash the password for security purpose
                $password_clear = '';
                $password_clear = $password;
                $password = password_hash($password, PASSWORD_DEFAULT);

                $created = date('Y-m-d H:i:s');

                $sql = "INSERT INTO user (name, email,surname,contactNo,permission_group_id,password, created) 
                                    VALUES (:name, :email, :surname, :contactNo, :permission_group_id, :password, :created)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':contactNo', $contactNo);
                $stmt->bindParam(':permission_group_id', $permission_group_id);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':created', $created);
                $success = $stmt->execute();

                if ($success && $stmt->rowCount() > 0) {

                    //send the email with the log-in creditials to the new user.
                    $to = $email;
                    $subject = "New User";

                    $message = "Your Have been added as a user on the Ekomi Software Systems";
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // More headers
                    $headers .= 'From: ekomi_recruitment@ekomi_recruitment.co.za' . "\r\n";
                    $template = file_get_contents('../emails/employee.php');
                    $template = str_replace('[name]', $name, $template);
                    $template = str_replace('[surname]', $surname, $template);
                    $template = str_replace('[message]', $message, $template);
                    $template = str_replace('[email]', $email, $template);
                    $template = str_replace('[password]', $password_clear, $template);

                    // mail($to,$subject,$template,$headers);

                    header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                    exit();
                }else{
                    header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=2');
                    exit();
                }
            }
        }

        // Read all users
        public function getAllUsers(){

            $permission_group_id = $_SESSION['user']['permission_group_id'];
            $user_id = $_SESSION['user']['id'];

            if($permission_group_id == '2' ){ 
                $sql = "SELECT user.*, permission_group.name AS 'Permission_Name'
                        FROM user
                        JOIN permission_group ON user.permission_group_id = permission_group.id
                        WHERE user.id = $user_id";
                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sql = "SELECT user.*, permission_group.name AS 'Permission_Name'
                        FROM user
                        JOIN permission_group ON user.permission_group_id = permission_group.id";
                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        }

        // Update a user
        public function updateUser($id, $name, $email, $surname,$contactNo, $permission_group_id) {
            $sql = "UPDATE user SET name = :name, email = :email, surname = :surname, contactNo = :contactNo, permission_group_id = :permission_group_id WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':contactNo', $contactNo);
            $stmt->bindParam(':permission_group_id', $permission_group_id);
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
