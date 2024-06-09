<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $content_type_id = $_POST["content_type_id"];
    $content_id = $_POST["content_id"];
    $content_status_id = $_POST["content_status_id"];

    $today = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $today->setTimezone($tz);
    $date = $today->format("Y-m-d H:i:s");

    if($content_status_id == 1){//deactivate

        if(!empty($_POST["reason"])){
            $reason = $_POST["reason"];
    
            if($content_type_id==1){//movie

                // movie
                Database::iud("UPDATE `movie` SET `movie`.`status_id`='2' WHERE `movie`.`id`='".$content_id."' AND `movie`.`status_id`='1'");
        
                $code_rs = Database::search("SELECT `code` FROM `movie` WHERE `movie`.`id`='".$content_id."' AND `movie`.`status_id`='2'");
                $code_data = $code_rs->fetch_assoc();

            }else if($content_type_id==2){//tv
                // tv
                Database::iud("UPDATE `tv_series` SET `tv_series`.`status_id`='2' WHERE `tv_series`.`id`='".$content_id."' AND `tv_series`.`status_id`='1'");
                        
                $code_rs = Database::search("SELECT `code` FROM `tv_series` WHERE `tv_series`.`id`='".$content_id."' AND `tv_series`.`status_id`='2'");
                $code_data = $code_rs->fetch_assoc();

            }

            Database::iud("INSERT INTO `content_status_change`(`reason`,`date_time`,`by`,`content_type`,`code`) 
            VALUES('".$reason."','".$date."','".$_SESSION["admin"]["admin_id"]."','".$content_type_id."','".$code_data["code"]."')");
    
            // echo("De-Activation Successful");
            echo("1");
    
        }else{
            // echo("Please Insert The Reason For The De-activation");
            echo("2");
        }

    }
    
    if($content_status_id == 2){//activate

        if($content_type_id==1){//movie

            Database::iud("UPDATE `movie` SET `movie`.`status_id`='1' WHERE `movie`.`id`='".$content_id."' AND `movie`.`status_id`='2'");

            $code_rs = Database::search("SELECT `code` FROM `movie` WHERE `movie`.`id`='".$content_id."' AND `movie`.`status_id`='1'");
            $code_data = $code_rs->fetch_assoc();

        }else if($content_type_id==2){//tv

            Database::iud("UPDATE `tv_series` SET `tv_series`.`status_id`='1' WHERE `tv_series`.`id`='".$content_id."' AND `tv_series`.`status_id`='2'");
                        
            $code_rs = Database::search("SELECT `code` FROM `tv_series` WHERE `tv_series`.`id`='".$content_id."' AND `tv_series`.`status_id`='1'");
            $code_data = $code_rs->fetch_assoc();

        }

        Database::iud("INSERT INTO `content_status_change`(`date_time`,`by`,`content_type`,`code`) 
        VALUES('".$date."','".$_SESSION["admin"]["admin_id"]."','".$content_type_id."','".$code_data["code"]."')");

        // echo("Re-Activation Successful");
        echo("3");

    }

}else{
    header("Location:index.php");
}

?>