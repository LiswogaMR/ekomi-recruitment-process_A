<?php

    $host = 'localhost';
    $db = 'ekomi_recruitment';
    $username = 'root';
    $password = 'virtual@PayDay5.2';

    //I used try to test if my connection was a success else I catch the error message that is for debbuging.
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Database connection successful!";
    } catch (PDOException $e) {
        // echo "Database connection failed: " . $e->getMessage();
    }

?>
