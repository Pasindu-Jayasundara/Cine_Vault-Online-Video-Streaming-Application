<?php

session_start();

require "../connection/SMTP.php";
require "../connection/PHPMailer.php";
require "../connection/Exception.php";
require "../connection/OAuth.php";
require "../connection/POP3.php";

use PHPMailer\PHPMailer\PHPMailer;

if(!empty($_SESSION["admin"])){

    if(!empty($_POST["email"])){
     
        if(!empty($_POST["replyMsg"])){

            $email = $_POST["email"];
            $replyMsg = $_POST["replyMsg"];
            
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cinevaultborwse@gmail.com';
            $mail->Password = 'xfhjfnfbdhczjkpb';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('cinevaultborwse@gmail.com', 'CineVault - Reply For Your Message');
            $mail->addReplyTo('cinevaultborwse@gmail.com', 'CineVault - Reply For Your Message');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reply For Your Message';
            $bodyContent = $replyMsg;
            $mail->Body = $bodyContent;
            
            
            if ($mail->send()) {
                // echo(" Emailed Successfully");
                echo("1");
            } else {
                // echo(" Email Process Faild");
                echo("2");
            }

        }else{
            // echo("Please Insert Reply Msg");
            echo("3");
        }
        
    }else{
        // echo("Something Went Wrong");
        echo("4");
    }

}else{
    header("Location:index.php");
}

?>