<?php

    if(!isset($_SESSION)){ 
        session_start();

        // Check if the session timestamp exists
        if (isset($_SESSION['last_activity'])) {
            // Get the current timestamp
            $current_time = time();
    
            // Get the last activity timestamp from the session
            $last_activity = $_SESSION['last_activity'];
    
            // Calculate the time difference in seconds
            $time_difference = $current_time - $last_activity;
    
            // Define the timeout duration in seconds (5 minutes = 300 seconds)
            $timeout_duration = 1200;
    
            // Check if the user has been away for more than the timeout duration
            if($time_difference > $timeout_duration){
                // Destroy the session
                session_destroy();
                header("Location: index.php");
            }
        }

        // Update the last activity timestamp
        $_SESSION['last_activity'] = time();
        
    } 

    if(!isset($_SESSION['user']['id'])){
        // session_destroy();
        header("Location: index.php");
    }

?>