<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code"]) && !empty($_POST["type"])){

        $code = $_POST["code"];
        $type = $_POST["type"];

        $date = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $date->setTimezone($tz);
        $today = $date->format("Y-m-d H:i:s");

        $rs = Database::search("SELECT * FROM `reaction` WHERE `reaction`.`status_id`='1' AND `reaction`.`user_id`='".$_SESSION["user"]["id"]."' AND
        `reaction`.`type_id`='".$type."' AND `reaction`.`code`='".$code."'");

        if($rs->num_rows == 1){//have a record
            $data = $rs->fetch_assoc();

            if($data["dis_like"] == 1){//dis liked before
                // echo("You Have Already Un-Liked This Content");

                Database::iud("UPDATE `reaction` SET `reaction`.`status_id`='2' WHERE `reaction`.`reaction_id`='".$data["reaction_id"]."'");
                echo("Reaction Updated");


            }else if($data["like"] == 1){//liked before
                Database::iud("UPDATE `reaction` SET `reaction`.`status_id`='2' WHERE `reaction`.`reaction_id`='".$data["reaction_id"]."'");

                Database::iud("INSERT INTO `reaction`(`dis_like`,`status_id`,`user_id`,`type_id`,`code`,`date_time`) 
                VALUES('1','1','".$_SESSION["user"]["id"]."','".$type."','".$code."','".$today."')");

                echo("Reaction Updated");
            }

        }else{
            Database::iud("INSERT INTO `reaction`(`dis_like`,`status_id`,`user_id`,`type_id`,`code`,`date_time`) 
            VALUES('1','1','".$_SESSION["user"]["id"]."','".$type."','".$code."','".$today."')");

            echo("un-Liked Content");
        }

    }else{
        echo("Something Went Wrong");
    }

}else{
    echo("2");
}

?>