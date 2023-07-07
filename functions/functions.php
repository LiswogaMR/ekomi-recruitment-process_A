<?php

    require_once 'user.php';
    require_once 'tasks.php';

    $actionType = '';
    if(isset($_POST['actionType'])){
        $actionType = $_POST['actionType'];
    }

    switch($actionType){
        case 'login':
            if(isset($_POST['email']) && isset($_POST['password'])){
                $email = $_POST['email'];
                $password = $_POST['password'];
            
                $users = $userModel->loginUser( $email, $password);

            }else{
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                exit();
            }
        break;
        case 'changePassword':
            if(isset($_POST['email']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword']) ){
                $email = $_POST['email'];
                $confirmpassword = $_POST['confirmpassword'];
                $password = $_POST['newpassword'];

                if($password == $confirmpassword ){
                    $users = $userModel->changePassword( $email, $password);
                }else{
                    //the two password are not the same return false
                    header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                    exit();
                }

            }
        break;
        case 'adduser':
            if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['surname']) && isset($_POST['password']) && isset($_POST['Permission'])){
                $name =  $_POST['name'];
                $email = $_POST['email'];
                $surname = $_POST['surname'];

                $password = $_POST['password'];
                $permission_group_id = $_POST['Permission'];

                //Because the field is not mandotory we use an if 
                if(isset($_POST['contactNo'])){
                    $contactNo = $_POST['contactNo'];
                }else{
                    $contactNo = "NULL";
                }

                $users = $userModel->createUser($name, $email, $surname,$contactNo, $permission_group_id, $password);

            }else{
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                exit();
            }
        break;
        case 'updateUser':
            if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['surname'])){
                $name =  $_POST['name'];
                $id =  $_POST['id'];
                $email = $_POST['email'];
                $surname = $_POST['surname'];
                $permission_group_id = $_POST['Permission'];

                //Because the field is not mandotory we use an if 
                if(isset($_POST['contactNo'])){
                    $contactNo = $_POST['contactNo'];
                }else{
                    $contactNo = "NULL";
                }

                $users = $userModel->updateUser($id,$name, $email, $surname,$contactNo,$permission_group_id);
            
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
                $assigned_to = $_POST['assigned_to'];
                
                $task = $taskModel->createTask($title, $description, $status,$date_created,$assigned_to);

            }
        break;
        case 'updateTask':
            if(isset($_POST['id']) && isset($_POST['status'])){
                $status =  $_POST['status'];
                $id = $_POST['id'];
                $date_updated = date('Y-m-d H:i:s');

                $task = $taskModel->updateTask($id,$status, $date_updated);
            
            }
        break;
        case 'deletetask':
            if(isset($_POST['id'])){
                $id = $_POST['id'];
            
                $task = $taskModel->deleteTask($id);
            }
        break;


        
    }

?>