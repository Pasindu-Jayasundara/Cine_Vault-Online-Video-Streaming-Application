<?php
require "../connection/connection.php";
session_start();

if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {

    $v_code = $_POST["v_code"];

    $rs = Database::search("SELECT * FROM `user` WHERE `user`.`id`='".$_SESSION["user"]["id"]."' AND `user`.`tmp_code`='".$v_code."' 
    AND `user`.`status_id`='1'");
    $num = $rs->num_rows;

    if($num == 1){

        $new_email = $_SESSION["new_email"];
        $old_email = $_SESSION["old_email"];

        Database::iud("INSERT INTO `user_email`(`email`,`user_id`,`status_id`) 
        VALUES('".$new_email."','".$_SESSION["user"]["id"]."','1')");

        Database::iud("UPDATE `user_email` SET `user_email`.`status_id`='2' WHERE `user_email`.`email`='".$old_email."'");

        $_SESSION["new_email"] = null;
        $_SESSION["old_email"] = null;

        echo("1");

    }else{
        echo("Invalid Verification Code");
    }

}else{
    echo("Log In First");
}

?>