<?php

require "../connection/connection.php";
session_start();

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code"]) && !empty($_POST["type"])){

        $code = $_POST["code"];
        $type_id = $_POST["type"];

        Database::iud("UPDATE `favourite` SET `favourite`.`status_id`='2' WHERE `favourite`.`status_id`='1' AND `favourite`.`type_id`='".$type_id."' 
        AND `favourite`.`code`='".$code."' AND `favourite`.`user_id`='".$_SESSION["user"]["id"]."'");

        echo('1');

    }else{
        echo("Something Went Wrong");
    }

}else{
    header("Location:index.php");
}

?>