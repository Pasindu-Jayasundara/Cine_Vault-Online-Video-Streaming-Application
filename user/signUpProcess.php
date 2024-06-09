<?php
session_start();
require "../connection/connection.php";

require "../connection/SMTP.php";
require "../connection/PHPMailer.php";
require "../connection/Exception.php";
require "../connection/OAuth.php";
require "../connection/POP3.php";

use PHPMailer\PHPMailer\PHPMailer;


if(!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["fname"]) && !empty($_POST["lname"])){

    $email = $_POST["email"];
    $password = $_POST["password"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];

    if(strlen($email)<100){
        if(strlen($password)<40){
            if(strlen($fname)<45){
                if(strlen($lname)<45){

                    if(filter_var($email,FILTER_VALIDATE_EMAIL)){

                        $user_rs = Database::search("SELECT * FROM `user_email` WHERE `user_email`.`email`='".$email."' AND `user_email`.`status_id`='1'");
                
                        $user_num = $user_rs->num_rows;
                
                        if($user_num == 1){
                
                            echo("1");
                
                        }else if($user_num == 0){
                
                            $code = uniqid();
                
                            $mail = new PHPMailer;
                            $mail->IsSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'cinevaultborwse@gmail.com';
                            $mail->Password = 'xfhjfnfbdhczjkpb';
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port = 465;
                            $mail->setFrom('cinevaultborwse@gmail.com', 'Verify Email Address');
                            $mail->addReplyTo('cinevaultborwse@gmail.com', 'Verify Email Address');
                            $mail->addAddress($email);
                            $mail->isHTML(true);
                            $mail->Subject = 'CineVault :- Email Verification';
                            $bodyContent = $code;
                            $mail->Body    = $bodyContent;
                
                            if($mail->send()){
                                
                                Database::iud("INSERT INTO `user`(`first_name`,`last_name`,`password`,`status_id`,`tmp_code`)  
                                VALUES('".$fname."','".$lname."','".$password."','3','".$code."')");
                    
                                $user_id = Database::$db_connection->insert_id;
                    
                                Database::iud("INSERT INTO `user_email`(`email`,`user_id`,`status_id`) 
                                VALUES('".$email."','".$user_id."','3')");
                    
                                $date = new DateTime();
                                $tz = new DateTimeZone("Asia/Colombo");
                                $date->setTimezone($tz);
                                $today = $date->format("Y-m-d H:i:s");
                    
                                Database::iud("INSERT INTO `user_subscription`(`user_id`,`date_time`,`status_id`,`subscription_id`,`paid_price`) 
                                VALUES('".$user_id."','".$today."','3','1','00.00')");
                
                                $_SESSION["newUseId"] = $user_id;
                    
                                echo("3");
                
                            }else{
                                echo("Email Verification Process Faild");
                            }
                
                        }
                
                    }else{
                        echo("Invalid Email Address");
                    }

                }else{
                    echo("Last Name is Too Long");
                }
            }else{
                echo("First Name is Too Long");
            }
        }else{
            echo("Password is Too Long");
        }
    }else{
        echo("Email Address is Too Long");
    }

}else{
    echo("2");
}



?>