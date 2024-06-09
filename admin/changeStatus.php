<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $admin_id = $_POST["admin_id"];
    $status_id = $_POST["status_id"];

    $today = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $today->setTimezone($tz);
    $date = $today->format("Y-m-d H:i:s");

    if($status_id == 1){//deactivate

        if(!empty($_POST["reason"])){
            $reason = $_POST["reason"];

            // admin
            Database::iud("UPDATE `admin` SET `admin`.`admin_status_id`='2' WHERE `admin`.`admin_id`='".$admin_id."' AND `admin`.`admin_status_id`='1'");

            // email
            Database::iud("UPDATE `admin_email` SET `admin_email`.`admin_email_status_id`='2' WHERE `admin_email`.`admin_admin_id`='".$admin_id."' AND `admin_email`.`admin_email_status_id`='1'");

            // mobile
            Database::iud("UPDATE `admin_mobile` SET `admin_mobile`.`admin_mobile_status_id`='2' WHERE `admin_mobile`.`admin_admin_id`='".$admin_id."' AND `admin_mobile`.`admin_mobile_status_id`='1'");

            // address
            Database::iud("UPDATE `admin_address` SET `admin_address`.`admin_address_status_id`='2' WHERE `admin_address`.`admin_admin_id`='".$admin_id."' AND `admin_address`.`admin_address_status_id`='1'");

            // profile img
            Database::iud("UPDATE `admin_profile_image` SET `admin_profile_image`.`status_id`='2' WHERE `admin_profile_image`.`admin_admin_id`='".$admin_id."' AND `admin_profile_image`.`status_id`='1'");


            Database::iud("INSERT INTO `admin_status_change`(`reason`,`date_time`,`by`,`of`) 
            VALUES('".$reason."','".$date."','".$_SESSION["admin"]["admin_id"]."','".$admin_id."')");

            // echo("De-Activation Successful");
            echo("1");

        }else{
            // echo("Please Insert The Reason For The De-activation");
            echo("2");
        }

    }else if($status_id == 2){//activate

        // admin
        Database::iud("UPDATE `admin` SET `admin`.`admin_status_id`='1' WHERE `admin`.`admin_id`='".$admin_id."' AND `admin`.`admin_status_id`='2'");

        // email
        $email_rs = Database::search("SELECT `admin_email_id` FROM `admin_email` 
        WHERE `admin_email`.`admin_admin_id`='".$admin_id."' AND `admin_email`.`admin_email_status_id`='2'
        ORDER BY `admin_email`.`added_date` DESC");
        $email_data = $email_rs->fetch_assoc();

        Database::iud("UPDATE `admin_email` SET `admin_email`.`admin_email_status_id`='1' 
        WHERE `admin_email`.`admin_admin_id`='".$admin_id."' AND `admin_email`.`admin_email_status_id`='2'
        AND `admin_email`.`admin_email_id`='".$email_data["admin_email_id"]."'");

        // mobile
        $mobile_rs = Database::search("SELECT `admin_mobile_id` FROM `admin_mobile` 
        WHERE `admin_mobile`.`admin_admin_id`='".$admin_id."' AND `admin_mobile`.`admin_mobile_status_id`='2'
        ORDER BY `admin_mobile`.`added_date` DESC");
        $mobile_data = $mobile_rs->fetch_assoc();

        Database::iud("UPDATE `admin_mobile` SET `admin_mobile`.`admin_mobile_status_id`='1' 
        WHERE `admin_mobile`.`admin_admin_id`='".$admin_id."' AND `admin_mobile`.`admin_mobile_status_id`='2'
        AND `admin_mobile`.`admin_mobile_id`='".$mobile_data["admin_mobile_id"]."'");

        // address
        $address_rs = Database::search("SELECT `admin_address_id` FROM `admin_address` 
        WHERE `admin_address`.`admin_admin_id`='".$admin_id."' AND `admin_address`.`admin_address_status_id`='2'
        ORDER BY `admin_address`.`added_date` DESC");
        $address_data = $address_rs->fetch_assoc();

        Database::iud("UPDATE `admin_address` SET `admin_address`.`admin_address_status_id`='1' 
        WHERE `admin_address`.`admin_admin_id`='".$admin_id."' AND `admin_address`.`admin_address_status_id`='2'
        AND `admin_address`.`admin_address_id`='".$address_data["admin_address_id"]."'");

        // profile img
        $profile_img_rs = Database::search("SELECT `admin_profile_img_id` FROM `admin_profile_image` 
        WHERE `admin_profile_image`.`admin_admin_id`='".$admin_id."' AND `admin_profile_image`.`status_id`='2'
        ORDER BY `admin_profile_image`.`date_time` DESC");
        $profile_img_data = $profile_img_rs->fetch_assoc();

        Database::iud("UPDATE `admin_profile_image` SET `admin_profile_image`.`status_id`='1' 
        WHERE `admin_profile_image`.`admin_admin_id`='".$admin_id."' AND `admin_profile_image`.`status_id`='2'
        AND `admin_profile_image`.`admin_profile_img_id`='".$profile_img_data["admin_profile_img_id"]."'");


        Database::iud("INSERT INTO `admin_status_change`(`date_time`,`by`,`of`) 
        VALUES('".$date."','".$_SESSION["admin"]["admin_id"]."','".$admin_id."')");

        // echo("Re-Activation Successful");
        echo("3");

    }

}else{
    header("Location:index.php");
}

?>