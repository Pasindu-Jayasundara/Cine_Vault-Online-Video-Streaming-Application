<?php
session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code"]) && !empty($_POST["type"])){

        $code = $_POST["code"];
        $type = $_POST["type"];

        if($type == 1){//movie

            $rs = Database::search("SELECT * FROM `cart` INNER JOIN `movie` ON `movie`.`code`=`cart`.`code` 
            WHERE `cart`.`code`='".$code."' AND `movie`.`status_id`='1' AND `cart`.`status_id`='1'");

            if($rs->num_rows == 1){

                $obj = new stdClass();

                $data = $rs->fetch_assoc();

                $obj->name = $data["name"];
                $obj->price = $data["price"];
                $obj->code = $data["code"];

                $jsonText = json_encode($obj);
                echo($jsonText);

            }

        }else if($type == 2){//tv

            $rs = Database::search("SELECT * FROM `cart` INNER JOIN `tv_series` ON `tv_series`.`code`=`cart`.`code` 
            WHERE `cart`.`code`='".$code."' AND `tv_series`.`status_id`='1' AND `cart`.`status_id`='1'");

            if($rs->num_rows == 1){

                $obj = new stdClass();

                $data = $rs->fetch_assoc();

                $obj->name = $data["name"];
                $obj->price = $data["price"];
                $obj->code = $data["code"];

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