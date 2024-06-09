<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["Obj"])){

        $obj = json_decode($_POST["Obj"]);
        // $obj = $_POST["Obj"];

        // check is there any active subscriptions
        $rs = Database::search("SELECT * FROM `user_subscription` WHERE `user_subscription`.`user_id`='".$_SESSION["user"]["id"]."' 
        AND `user_subscription`.`status_id`='1'");

        if($rs->num_rows > 0){//have need to remove

            Database::iud("UPDATE `user_subscription` SET `user_subscription`.`status_id`='2' WHERE `user_subscription`.`status_id`='1' 
            AND `user_subscription`.`user_id`='".$_SESSION["user"]["id"]."'");

        }

        $date = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $date->setTimezone($tz);
        $today = $date->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user_subscription`(`user_id`,`date_time`,`status_id`,`subscription_id`,`paid_price`) 
        VALUES('".$_SESSION["user"]["id"]."','".$today."','1','".$obj->plan_id."','".$obj->price."')");

        echo("1");

    }else{
        echo("Couldn't Get The Details");
    }

}else{
    header("Location:index.php");
}

?>