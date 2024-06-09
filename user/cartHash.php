<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["total"]) && !empty($_POST["code_arr"])){

        $merchant_id = "1222794";
        $merchant_secret = "MTg2MDA0Mjk3NDI0MzMzMjQyMzIzNjg2NTQzMDc0Mjg0OTAxMjEx";
        $currency = "USD";

        $purchase_rs = Database::search("SELECT * FROM `purchase_history` ORDER BY `purchase_history`.`purchase_history_id` DESC");
        
        if($purchase_rs->num_rows < 1){
            $order_id = 1;
        }else{
            $purchase_data = $purchase_rs->fetch_assoc();
            $order_id = intval($purchase_data["purchase_history_id"])+1;
        }


        $items = $_POST["code_arr"];
        $price = $_POST["total"];

        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                number_format($price, 2, '.', '') . 
                $currency .  
                strtoupper(md5($merchant_secret)) 
            ) 
        );

        $obj = new stdClass();
        $obj->merchant_id = $merchant_id;
        $obj->items = $items;
        $obj->price = $price;
        $obj->currency = $currency;
        $obj->hash = $hash;
        $obj->first_name = $_SESSION["user"]["first_name"];
        $obj->last_name = $_SESSION["user"]["last_name"];

        $email_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_email` ON `user`.`id`=`user_email`.`user_id` 
        WHERE `user`.`id`='".$_SESSION["user"]["id"]."' AND `user`.`status_id`='1' AND `user_email`.`status_id`='1'");

        $email_data = $email_rs->fetch_assoc();
        
        $obj->email = $email_data["email"];


        // echo($_SESSION["user"]["id"]);
        echo(json_encode($obj));

    }else{
        echo("2");
    }

}else{
    header("Location:index.php");
}

?>