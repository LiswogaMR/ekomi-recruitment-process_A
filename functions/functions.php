<?php

    require_once 'user.php';
    require_once 'tasks.php';

    $actionType = '';
    if(isset($_POST['actionType'])){
        $actionType = $_POST['actionType'];
    }

    switch($actionType){
        case 'adduser':
            if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['surname'])){
                $name =  $_POST['name'];
                $email = $_POST['email'];
                $surname = $_POST['surname'];

                //Because the field is not mandotory we use an if 
                if(isset($_POST['contactNo'])){
                    $contactNo = $_POST['contactNo'];
                }else{
                    $contactNo = "NULL";
                }

                $users = $userModel->createUser($name, $email, $surname,$contactNo);
                

            }
        break;
        case 'updateUser':
            if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['surname'])){
                $name =  $_POST['name'];
                $id =  $_POST['id'];
                $email = $_POST['email'];
                $surname = $_POST['surname'];

                //Because the field is not mandotory we use an if 
                if(isset($_POST['contactNo'])){
                    $contactNo = $_POST['contactNo'];
                }else{
                    $contactNo = "NULL";
                }

                $users = $userModel->updateUser($id,$name, $email, $surname,$contactNo);
                

            }
        break;
        
        case 'deleteUser':
            if(isset($_POST['id'])){
                $id =  $_POST['id'];

                $users = $userModel->deleteUser($id);
                
            }
        break;

        case 'addtask':
            if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['status'])){
                $title =  $_POST['title'];
                $description = $_POST['description'];
                $status = $_POST['status'];
                $date_created = date('Y-m-d H:i:s');
                
                $task = $taskModel->createTask($title, $description, $status,$date_created);

            }
        break;

        case 'updateTask':
            if(isset($_POST['id']) && isset($_POST['status']) ){
                $status =  $_POST['status'];
                $id = $_POST['id'];
                $date_updated = date('Y-m-d H:i:s');

                $task = $taskModel->updateTask($id,$status, $date_updated);
            }
        break;

        case 'deletetask':
            if(isset($_POST['id']) ){
                $id = $_POST['id'];
            
                $task = $taskModel->deleteTask($id);
            }
        break;


        
    }

?>