<?php
$server = 'mysql';
$username = 'user';
$password = 'root';
$database = 'database';

try{
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
    die( "Connection failed: " . $e->getMessage());
}