<?php
session_start();
require "../connection/connection.php";

if(!empty($_POST["email"]) && !empty($_POST["password"])){

    $email = $_POST["email"];
    $password = $_POST["password"];

    if(filter_var($email,FILTER_VALIDATE_EMAIL)){

        $user_rs = Database::search("SELECT `user`.`id` AS `id`,
        `user`.`first_name` AS `first_name`,
        `user`.`last_name` AS `last_name`,
        `user`.`status_id` AS `status_id`,
        `user`.`password` AS `password`,
        `user`.`tmp_code` AS `tmp_code`,
        `user_email`.`id` AS `email_id`,
        `user_email`.`email` AS `email`,
        `user_email`.`user_id` AS `user_id`,
        `user_email`.`status_id` AS `status_id`
        
        FROM `user` INNER JOIN `user_email` ON `user`.`id`=`user_email`.`user_id` 
        WHERE `user`.`password`='".$password."' AND `user_email`.`email`='".$email."' AND `user_email`.`status_id`='1'");
    
        $user_num = $user_rs->num_rows;
    
        if($user_num == 1){
    
            $user_data = $user_rs->fetch_assoc();
            $_SESSION["user"] = $user_data;
    
            echo("1");
            // echo($_SESSION["user"]["id"]);
    
        }else if($user_num == 0){
            echo("Sign Up First");
        }

    }else{
        echo("Invalid Email Address");
    }

}else{
    echo("Please Insert Your Details");
}

?>