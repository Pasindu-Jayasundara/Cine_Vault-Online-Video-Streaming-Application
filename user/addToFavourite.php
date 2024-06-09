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

        $rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`status_id`='1' AND `favourite`.`user_id`='".$_SESSION["user"]["id"]."' AND
        `favourite`.`type_id`='".$type."' AND `favourite`.`code`='".$code."'");

        $obj = new stdClass();

        if($rs->num_rows == 1){//have a record
            $data = $rs->fetch_assoc();

            Database::iud("UPDATE `favourite` SET `favourite`.`status_id`='2' WHERE `favourite`.`user_id`='".$_SESSION["user"]["id"]."' AND `favourite`.`type_id`='".$type."' 
            AND `favourite`.`code`='".$code."'");

            $obj->msg = "Removed From Favourite";

        }else{
            Database::iud("INSERT INTO `favourite`(`status_id`,`user_id`,`type_id`,`code`,`date_time`) 
            VALUES('1','".$_SESSION["user"]["id"]."','".$type."','".$code."','".$today."')");

            $obj->msg = "Added to Favourite";
        }

        $time = $date->format("H:i:s");
        $jsonText = json_encode($obj);
        echo($jsonText);

    }else{
        echo("1");
    }

}else{
    echo("2");
}

?>