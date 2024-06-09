<?php

require "../connection/connection.php";
session_start();

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code"]) && !empty($_POST["type"])){

        $code = $_POST["code"];
        $type_id = $_POST["type"];

        Database::iud("UPDATE `cart` SET `cart`.`status_id`='2' WHERE `cart`.`status_id`='1' AND `cart`.`type_id`='".$type_id."' 
        AND `cart`.`code`='".$code."' AND `cart`.`user_id`='".$_SESSION["user"]["id"]."'");

        echo('1');

    }else{
        echo("Something Went Wrong");
    }

}else{
    header("Location:index.php");
}

?>