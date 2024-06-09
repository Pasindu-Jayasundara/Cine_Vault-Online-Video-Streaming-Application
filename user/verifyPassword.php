<?php
session_start();
require "../connection/connection.php";

require "../connection/SMTP.php";
require "../connection/PHPMailer.php";
require "../connection/Exception.php";
require "../connection/OAuth.php";
require "../connection/POP3.php";

use PHPMailer\PHPMailer\PHPMailer;

if(!empty($_POST["old_password"]) && !empty($_POST["new_password"])){

    $email_rs = Database::search("SELECT * FROM `user_email` WHERE `user_email`.`user_id`='".$_SESSION["user"]["id"]."' AND 
    `user_email`.`status_id`='1'");
    $email_data = $email_rs->fetch_assoc();

    $rs = Database::search("SELECT * FROM `user_email` WHERE `user_email`.`email`='".$email_data["email"]."' AND `user_email`.`status_id`='1' 
    AND `user_email`.`user_id`='".$_SESSION["user"]["id"]."'");

    $num = $rs->num_rows;

    if($num == 1){

        $_SESSION["new_password"] = $_POST["new_password"];
        $_SESSION["old_password"] = $_POST["old_password"];

        $data = $rs->fetch_assoc();

        $tmp_code = uniqid();

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cinevaultborwse@gmail.com';
        $mail->Password = 'xfhjfnfbdhczjkpb';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('cinevaultborwse@gmail.com', 'CineVault Password Verification');
        // $mail->addReplyTo('cinevaultborwse@gmail.com', 'Reset Password');
        $mail->addAddress($email_data["email"]);
        $mail->isHTML(true);
        $mail->Subject = 'CineVault Password Verification';
        $bodyContent = "Your Verification Code is : '".$tmp_code."'";
        $mail->Body    = $bodyContent;

        if($mail->send()){
            Database::iud("UPDATE `user` SET `user`.`tmp_code`='".$tmp_code."' WHERE `user`.`id`='".$_SESSION["user"]["id"]."'");
            echo("5");
        }else{
            echo("2");
        }

    }else{
        echo("1");
    }

}else{
    echo("3");
}

?>