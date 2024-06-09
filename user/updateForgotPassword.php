<?php
require "../connection/connection.php";
session_start();

if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {

    if(!empty($_POST["forgotPasswordNewPassword"])){

        $forgotPasswordNewPassword = $_POST["forgotPasswordNewPassword"];

        $rs = Database::search("SELECT * FROM `user` WHERE `user`.`id`='".$_SESSION["user"]["id"]."' AND `user`.`status_id`='1'");
        $num = $rs->num_rows;

        if($num == 1){

            Database::iud("UPDATE `user` SET `user`.`password`='".$forgotPasswordNewPassword."' WHERE `user`.`id`='".$_SESSION["user"]["id"]."'");

            $n_rs = Database::search("SELECT * FROM `user` WHERE `user`.`id`='".$_SESSION["user"]["id"]."' AND `user`.`status_id`='1'");
            $n_data = $n_rs->fetch_assoc();

            $_SESSION["user"] = $n_data;

            echo("1");

        }else{
            echo("Something Went Wrong");
        }

    }else{
        echo("Fill the Detais First");
    }

}else{
    echo("Log In First");
}

?>