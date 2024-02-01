<?php
require_once "../model/connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $title = $_POST["title"];
    $message = $_POST["message"];
    $subject = $_POST["subject"];
    
    $stmt = $mysqli->prepare("INSERT INTO messages (email,subject,title,message) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $email,$subject,$title,$message);
    $stmt->execute();
    $response = ['message' => 'Thank you, your message has been sent successfully.'];

    echo json_encode($response);

    $stmt->close();
    $mysqli->close();
}
?>