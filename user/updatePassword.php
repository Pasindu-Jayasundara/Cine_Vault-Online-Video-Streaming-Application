<?php
require "../connection/connection.php";
session_start();

if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {

    $v_code = $_POST["v_code"];

    $rs = Database::search("SELECT * FROM `user` WHERE `user`.`id`='".$_SESSION["user"]["id"]."' AND `user`.`tmp_code`='".$v_code."' 
    AND `user`.`status_id`='1'");
    $num = $rs->num_rows;

    if($num == 1){

        $new_password = $_SESSION["new_password"];
        $old_password = $_SESSION["old_password"];

        Database::iud("UPDATE `user` SET `user`.`password`='".$new_password."' WHERE `user`.`id`='".$_SESSION["user"]["id"]."'");

        $_SESSION["new_password"] = null;
        $_SESSION["old_password"] = null;

        echo("1");

    }else{
        echo("Invalid Verification Code");
    }

}else{
    echo("Log In First");
}

?>