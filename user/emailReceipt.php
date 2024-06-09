<?php

session_start();
require "../connection/connection.php";

require "../connection/SMTP.php";
require "../connection/PHPMailer.php";
require "../connection/Exception.php";
require "../connection/OAuth.php";
require "../connection/POP3.php";

use PHPMailer\PHPMailer\PHPMailer;

if(!empty($_SESSION["user"])){

    $email = $_SESSION["user"]["email"];
    $body = $_POST["body"];

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cinevaultborwse@gmail.com';
    $mail->Password = 'xfhjfnfbdhczjkpb';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('cinevaultborwse@gmail.com', 'CineVault Payment Receipt');
    // $mail->addReplyTo('cinevaultborwse@gmail.com', 'Reset Password');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'CineVault Payment Receipt';
    $bodyContent = $body;
    $mail->Body    = $bodyContent;

    if($mail->send()){
        echo("Email Sending Success");        
    }else{
        echo("Email Sending Faild");        
    }

}else{
    header("Location:index.php");
}

?>