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

        $rs = Database::search("SELECT * FROM `cart` WHERE `cart`.`status_id`='1' AND `cart`.`user_id`='".$_SESSION["user"]["id"]."' 
        AND `cart`.`type_id`='".$type."' AND `cart`.`code`='".$code."'");

        $obj = new stdClass();

        if($rs->num_rows == 1){//have a record
            $data = $rs->fetch_assoc();

            Database::iud("UPDATE `cart` SET `cart`.`status_id`='2' WHERE `cart`.`user_id`='".$_SESSION["user"]["id"]."' AND `cart`.`type_id`='".$type."' 
            AND `cart`.`code`='".$code."'");

            $obj->msg = "Removed From Cart";

        }else{
            Database::iud("INSERT INTO `cart`(`status_id`,`user_id`,`type_id`,`code`,`date_time`) 
            VALUES('1','".$_SESSION["user"]["id"]."','".$type."','".$code."','".$today."')");

            $obj->msg = "Added to Cart";
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