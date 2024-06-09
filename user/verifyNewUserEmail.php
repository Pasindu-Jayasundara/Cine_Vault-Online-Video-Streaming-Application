<?php

session_start();
$user_id = $_SESSION["newUseId"];

require "../connection/connection.php";

if(!empty($_POST["newUserVCode"])){

    $code = $_POST["newUserVCode"];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `user`.`id`='".$user_id."' AND `user`.`tmp_code`='".$code."' AND `user`.`status_id`='3'");

    if($user_rs->num_rows == 1){

        Database::iud("UPDATE `user` SET `status_id`='1' WHERE `user`.`id`='".$user_id."'");
        Database::iud("UPDATE `user_email` SET `status_id`='1' WHERE `user`.`id`='".$user_id."'");
        Database::iud("UPDATE `user_subscription` SET `status_id`='1' WHERE `user`.`id`='".$user_id."'");

        $_SESSION["newUseId"] = null;
        $_SESSION["user"] = $user_rs->fetch_assoc();

        echo("Account Activation Successful.");

    }else{
        echo("Invalid Verification Code");
    }

}else{
    echo("Please Insert Your Email Verification Code");
}

?>