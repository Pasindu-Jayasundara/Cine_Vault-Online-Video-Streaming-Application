<?php
session_start();
require "../connection/connection.php";

if(!empty($_POST["forgotPasswordEmailVerificationCode"])){

    $rs = Database::search("SELECT * FROM `user` WHERE `user`.`tmp_code`='".$_POST["forgotPasswordEmailVerificationCode"]."'");

    $data = $rs->fetch_assoc();

    if($data["id"] == $_SESSION["user"]["id"]){

        echo("success");

    }else{
        echo("Invalid Code");
    }

}else{
    echo("3");
}

?>