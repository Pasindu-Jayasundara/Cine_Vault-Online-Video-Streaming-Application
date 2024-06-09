<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $user_id = $_POST["user_id"];
    $status_id = $_POST["status_id"];

    $today = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $today->setTimezone($tz);
    $date = $today->format("Y-m-d H:i:s");

    if($status_id == 1){//deactivate

        if(!empty($_POST["reason"])){
            $reason = $_POST["reason"];

            // user
            Database::iud("UPDATE `user` SET `user`.`status_id`='2' WHERE `user`.`id`='".$user_id."' AND `user`.`status_id`='1'");

            // email
            Database::iud("UPDATE `user_email` SET `user_email`.`status_id`='2' WHERE `user_email`.`user_id`='".$user_id."' AND `user_email`.`status_id`='1'");

            // subscription
            Database::iud("UPDATE `user_subscription` SET `user_subscription`.`status_id`='2' WHERE `user_subscription`.`user_id`='".$user_id."' AND `user_subscription`.`status_id`='1'");

            // address
            Database::iud("UPDATE `user_address` SET `user_address`.`status_id`='2' WHERE `user_address`.`user_id`='".$user_id."' AND `user_address`.`status_id`='1'");

            // profile img
            Database::iud("UPDATE `profile_image` SET `profile_image`.`status_id`='2' WHERE `profile_image`.`user_id`='".$user_id."' AND `profile_image`.`status_id`='1'");


            Database::iud("INSERT INTO `user_status_change`(`reason`,`date_time`,`by`,`of`) 
            VALUES('".$reason."','".$date."','".$_SESSION["admin"]["admin_id"]."','".$user_id."')");

            // echo("De-Activation Successful");
            echo("1");

        }else{
            // echo("Please Insert The Reason For The De-activation");
            echo("2");
        }

    }else if($status_id == 2){//activate

        // user
        Database::iud("UPDATE `user` SET `user`.`status_id`='1' WHERE `user`.`id`='".$user_id."' AND `user`.`status_id`='2'");

        // email
        $email_rs = Database::search("SELECT `id` FROM `user_email` 
        WHERE `user_email`.`user_id`='".$user_id."' AND `user_email`.`status_id`='2'
        ORDER BY `user_email`.`id` DESC");
        $email_data = $email_rs->fetch_assoc();

        Database::iud("UPDATE `user_email` SET `user_email`.`status_id`='1' 
        WHERE `user_email`.`user_id`='".$user_id."' AND `user_email`.`status_id`='2'
        AND `user_email`.`id`='".$email_data["id"]."'");

        // subscription
        $subscription_rs = Database::search("SELECT `id` FROM `user_subscription` 
        WHERE `user_subscription`.`user_id`='".$user_id."' AND `user_subscription`.`status_id`='2'
        ORDER BY `user_subscription`.`id` DESC");
        $subscription_data = $subscription_rs->fetch_assoc();

        Database::iud("UPDATE `user_subscription` SET `user_subscription`.`status_id`='1' 
        WHERE `user_subscription`.`user_id`='".$user_id."' AND `user_subscription`.`status_id`='2'
        AND `user_subscription`.`id`='".$subscription_data["id"]."'");

        // address
        $address_rs = Database::search("SELECT `id` FROM `user_address` 
        WHERE `user_address`.`user_id`='".$user_id."' AND `user_address`.`status_id`='2'
        ORDER BY `user_address`.`id` DESC");
        $address_data = $address_rs->fetch_assoc();

        Database::iud("UPDATE `user_address` SET `user_address`.`status_id`='1' 
        WHERE `user_address`.`user_id`='".$user_id."' AND `user_address`.`status_id`='2'
        AND `user_address`.`id`='".$address_data["id"]."'");

        // profile img
        $profile_img_rs = Database::search("SELECT `id` FROM `profile_image` 
        WHERE `profile_image`.`user_id`='".$user_id."' AND `profile_image`.`status_id`='2'
        ORDER BY `profile_image`.`id` DESC");
        $profile_img_data = $profile_img_rs->fetch_assoc();

        Database::iud("UPDATE `profile_image` SET `profile_image`.`status_id`='1' 
        WHERE `profile_image`.`user_id`='".$user_id."' AND `profile_image`.`status_id`='2'
        AND `profile_image`.`id`='".$profile_img_data["id"]."'");


        Database::iud("INSERT INTO `user_status_change`(`date_time`,`by`,`of`) 
        VALUES('".$date."','".$_SESSION["admin"]["admin_id"]."','".$user_id."')");

        // echo("Re-Activation Successful");
        echo("3");

    }

}else{
    header("Location:index.php");
}

?>