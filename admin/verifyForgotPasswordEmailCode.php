<?php
session_start();
require "../connection/connection.php";

if(!empty($_POST["forgotPasswordEmailVerificationCode"])){

    $rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`tmp_code`='".$_POST["forgotPasswordEmailVerificationCode"]."'");

    $data = $rs->fetch_assoc();

    if($data["admin_id"] == $_SESSION["id"]){

        echo("success");

    }else{
        echo("Invalid Code");
    }

}else{
    echo("3");
}

?>