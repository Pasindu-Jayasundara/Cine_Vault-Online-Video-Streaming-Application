<?php
session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code"]) && !empty($_POST["type"])){

        $code = $_POST["code"];
        $type = $_POST["type"];

        if($type == 1){//movie

            $rs = Database::search("SELECT * FROM `cart` INNER JOIN `movie` ON `movie`.`code`=`cart`.`code` 
            WHERE `cart`.`code`='".$code."' AND `movie`.`status_id`='1' AND `cart`.`status_id`='1' AND `cart`.`type_id`='".$type."'");

            if($rs->num_rows == 1){

                Database::iud("UPDATE `cart` SET `cart`.`status_id`='2' WHERE `cart`.`code`='".$code."' AND `cart`.`status_id`='1' AND `cart`.`type_id`='".$type."'");

                $date = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $date->setTimezone($tz);
                $today = $date->format("H:i:s");

                $obj = new stdClass();

                $obj->message = "Movie Removed From Cart";
                $obj->time = $today;
                $obj->status = '1';

                $jsonText = json_encode($obj);
                echo($jsonText);

            }else{

                $date = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $date->setTimezone($tz);
                $today = $date->format("Y-m-d H:i:s");

                Database::iud("INSERT INTO `cart`(`user_id`,`type_id`,`code`,`date_time`,`status_id`) 
                VALUES('".$_SESSION["user"]["id"]."','".$type."','".$code."','".$today."','1')");

                $today = $date->format("H:i:s");

                $obj = new stdClass();

                $obj->message = "Movie Added To The Cart";
                $obj->time = $today;
                $obj->status = '2';

                $jsonText = json_encode($obj);
                echo($jsonText);

            }

        }else if($type == 2){//tv

            $rs = Database::search("SELECT * FROM `cart` INNER JOIN `tv_series` ON `tv_series`.`code`=`cart`.`code` 
            WHERE `cart`.`code`='".$code."' AND `tv_series`.`status_id`='1' AND `cart`.`status_id`='1' AND `cart`.`type_id`='".$type."'");

            if($rs->num_rows == 1){

                Database::iud("UPDATE `cart` SET `cart`.`status_id`='2' WHERE `cart`.`code`='".$code."' AND `cart`.`status_id`='1' AND `cart`.`type_id`='".$type."'");

                $date = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $date->setTimezone($tz);
                $today = $date->format("H:i:s");

                $obj = new stdClass();

                $obj->message = "Tv-Series Removed From Cart";
                $obj->time = $today;
                $obj->status = '1';

                $jsonText = json_encode($obj);
                echo($jsonText);

            }else{

                $date = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $date->setTimezone($tz);
                $today = $date->format("Y-m-d H:i:s");

                Database::iud("INSERT INTO `cart`(`user_id`,`type_id`,`code`,`date_time`,`status_id`) 
                VALUES('".$_SESSION["user"]["id"]."','".$type."','".$code."','".$today."','1')");

                $today = $date->format("H:i:s");

                $obj = new stdClass();

                $obj->message = "Tv-Series Added To The Cart";
                $obj->time = $today;
                $obj->status = '2';

                $jsonText = json_encode($obj);
                echo($jsonText);

            }

        }

    }else{
        echo("Something Went Wrong");
    }

}else{
    echo("Please LogIn First");
}


?>