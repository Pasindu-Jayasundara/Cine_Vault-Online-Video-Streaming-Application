<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["plan_id"])){

        $merchant_id = "1222051";
        $plan_id = $_POST["plan_id"];
        $currency = "USD";
        $merchant_secret = "MzgyMjc2NzUwOTExODQyMTExNjAyNDQxMDU2NDg1MzE3NjM5MDc=";

        $price_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`id`='".$plan_id."'");
        $price_data = $price_rs->fetch_assoc();

        $price = $price_data["price"];

        $hash = strtoupper(
            md5(
                $merchant_id . 
                $plan_id . 
                number_format($price, 2, '.', '') . 
                $currency .  
                strtoupper(md5($merchant_secret)) 
            ) 
        );

        $subscription_name = $price_data["type"];
        $user_first_name = $_SESSION["user"]["first_name"];
        $user_last_name = $_SESSION["user"]["last_name"];
        $email = $_SESSION["user"]["email"];

        $obj = new stdClass();
        $obj->merchant_id = $merchant_id;
        $obj->plan_id = $plan_id;
        $obj->price = $price;
        $obj->currency = $currency;
        $obj->hash = $hash;
        $obj->user_first_name = $user_first_name;
        $obj->user_last_name = $user_last_name;
        $obj->email = $email;
        $obj->subscription_name = $subscription_name;

        echo(json_encode($obj));

    }

}else{
    header("Location:index.php");
}
?>