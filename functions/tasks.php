<?php

    include("connection.php");
    class Task {
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        //new task
        public function createTask($title, $description, $status, $date_created ){
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

                $sql = "INSERT INTO task (title, description, status, date_created ) VALUES (:title, :description, :status, :date_created)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':date_created', $date_created);
                $stmt->execute();
                 
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
                exit();
 
             }
        }

        //Read all task
        public function getAllTask(){
            $sql = "SELECT * FROM task";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
