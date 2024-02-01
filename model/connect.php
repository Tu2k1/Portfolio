<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "cs471";
$mysqli = new mysqli($hostname,$username,$password,$database);


if($mysqli->connect_error){
    die("connection failed: ".$mysqli->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(20) NOT NULL,
    subject VARCHAR(15) NOT NULL,
    title VARCHAR(20),
    message VARCHAR(55) NOT NULL
    )";

$mysqli->query($sql);
?>