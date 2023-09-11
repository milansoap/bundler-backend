<?php

$datasource = 'mysql:host=localhost;dbname=bundler';
$username = 'root';
$password = 'root';

try {
    $db = new PDO($datasource, $username, $password);
} catch (PDOException $error) {
    $errorMessage = "Database Error: ";
    $errorMessage .= $error->getMessage();
    header('Location: http://localhost:3000/errorPage');
    exit();
}
