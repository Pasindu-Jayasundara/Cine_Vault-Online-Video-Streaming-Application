<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["jsObj"])){

        $json_obj = $_POST["jsObj"];
        $obj = json_decode($json_obj);

        $code = json_decode($obj->items);

        $date = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $date->setTimezone($tz);
        $today = $date->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `purchase_history`(`user_id`,`date_time`,`price`,`promo_code_id`) 
        VALUES('".$_SESSION["user"]["id"]."','".$today."','".$obj->price."','1')");

        $purchase_history_id = Database::$db_connection->insert_id;

        for($x = 0; $x < count($code); $x++){

            $current_code = $code[$x];
            
            Database::iud("INSERT INTO `purchased_item_code`(`purchased_item_code`,`purchase_history_purchase_history_id`) 
            VALUES('".$current_code."','".$purchase_history_id."')");

        }

        echo $purchase_history_id;

    }else{
        echo("Something Went Wrong");
    }

}else{
    header("Location:index.php");
}


?>