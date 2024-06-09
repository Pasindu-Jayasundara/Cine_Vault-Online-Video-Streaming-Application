<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    $subscription_rs = Database::search("SELECT * FROM `subscription` INNER JOIN `user_subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
    INNER JOIN `user` ON `user`.`id`=`user_subscription`.`user_id` WHERE `user`.`status_id`='1' AND `subscription`.`status_id`='1' 
    AND `user_subscription`.`status_id`='1' AND `user`.`id`='".$_SESSION["user"]["id"]."'");

    if($subscription_rs->num_rows == 1){

        $subscription_data = $subscription_rs->fetch_assoc();

        if($subscription_data["subscription_id"] != 1){

            if(!empty($_POST["textToAdmin"])){

                $msg = $_POST["textToAdmin"];

                $date = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $date->setTimezone($tz);
                $today = $date->format("Y-m-d H:i:s");

                Database::iud("INSERT INTO `admin_message`(`user_id`,`status_id`,`message`,`date_time`,`admin_id`) 
                VALUES('".$_SESSION["user"]["id"]."','3','".$msg."','".$today."','2')");

                echo("Message Sent Successfuly");

            }else{
                echo("Please Enter Your Message First");
            }

        }else{//basic user
            echo("1");
        }

    }else{
        echo("Something Went Wrong");
    }

}else{
    echo("Please LogIn First");
}

?>