<?php
session_start();
require "../connection/connection.php";

if(!empty($_POST["plan_id"])){

    $plan_id = $_POST["plan_id"];

    if(!empty($_SESSION["user"])){//previously subscription baught user

        $aviliable_subscription_rs = Database::search("SELECT * FROM `user_subscription` WHERE `user_subscription`.`user_id`='".$_SESSION["user"]["id"]."' 
        AND `user_subscription`.`status_id`='1' AND `user_subscription`.`subscription_id`='".$plan_id."'");

        $aviliable_subscription_num = $aviliable_subscription_rs->num_rows;

        if($aviliable_subscription_num == 1){//already active subscription availiable
            echo("1");
        }else{
            echo("3");
        }

    }else{
        echo("4");
    }


}else{
    echo("2");
}
?>