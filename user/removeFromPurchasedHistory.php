<?php

require "../connection/connection.php";
session_start();

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code"]) && !empty($_POST["id"])){

        $code = $_POST["code"];
        $id = $_POST["id"];//purchased item code 

        Database::iud("UPDATE `purchased_item_code` SET `purchased_item_code`.`status_id`='2' WHERE `purchased_item_code`.`status_id`='1' 
        AND `purchased_item_code`.`purchased_item_code_id`='".$id."' AND `purchased_item_code`.`purchased_item_code`='".$code."'");

        echo("1");

    }

}else{
    header("Location:index.php");
}

?>