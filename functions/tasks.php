<?php

    include("connection.php");
    include('session_data.php');
    // session_start();

    class Task {
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        //new task
        public function createTask($title, $description, $status, $date_created,$assigned_to ){
             //Check if the title already exists before adding a new one
             $taskQuery = "SELECT * FROM task WHERE title = :title";
             $taskQuery = $this->conn->prepare($taskQuery);
             $taskQuery->bindParam(':title', $title);
             $taskQuery->execute();
 
             if($taskQuery->rowCount() > 0){
                // User already exists, don't do anything 
                //  echo "Title already exists.";
                 header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                 exit();
             }else{

                $assigned_by = $_SESSION['user']['id'];
                
                $sql = "INSERT INTO task (title, description, status, date_created, assigned_to, assigned_by ) 
                VALUES (:title, :description, :status, :date_created, :assigned_to, :assigned_by)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':date_created', $date_created);
                $stmt->bindParam(':assigned_to', $assigned_to);
                $stmt->bindParam(':assigned_by', $assigned_by);
                $stmt->execute();
                 
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
 
             }
        }

        //Read all task
        public function getAllTask(){
            $permission_group_id = $_SESSION['user']['permission_group_id'];
            $user_id = $_SESSION['user']['id'];

            if($permission_group_id == '2'){ 
                $sql = "SELECT task.*, assigned_user.name AS assigned_to_name, assigned_user.surname AS assigned_to_surname, 
                                assigned_by_user.name AS assigned_by_name, assigned_by_user.surname AS assigned_by_surname 
                        FROM task 
                        JOIN user AS assigned_user ON assigned_user.id = task.assigned_to
                        JOIN user AS assigned_by_user ON assigned_by_user.id = task.assigned_by
                        WHERE task.assigned_to = $user_id";
                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }else{

                $sql = "SELECT task.*, assigned_user.name AS assigned_to_name, assigned_user.surname AS assigned_to_surname, 
                                assigned_by_user.name AS assigned_by_name, assigned_by_user.surname AS assigned_by_surname 
                        FROM task 
                        JOIN user AS assigned_user ON assigned_user.id = task.assigned_to
                        JOIN user AS assigned_by_user ON assigned_by_user.id = task.assigned_by";

                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }

        }

        //Update a task
        public function updateTask($id, $status, $date_updated){
            $sql = "UPDATE task SET status = :status , date_updated = :date_updated WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':date_updated', $date_updated);
            $success = $stmt->execute();

            if($success && $stmt->rowCount() > 0){
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
            }else{
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=2');
                exit();
            }
        }

        //Delete a task
        public function deleteTask($id){
            $sql = "DELETE FROM task WHERE id = :id";
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

    $taskModel = new Task($conn);

?>
