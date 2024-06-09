<?php

require "../connection/connection.php";
session_start();

if(!empty($_SESSION["user"])){

    if(!empty($_POST["code_arr"])){

        $arr = array();

        $code_json_arr = $_POST["code_arr"];
        $code_arr = json_decode($code_json_arr);

        for($x = 0; $x <count($code_arr); $x++){
            $checking_code = $code_arr[$x];

            $rs = Database::search("SELECT * FROM `purchase_history` INNER JOIN `purchased_item_code` 
            ON `purchase_history`.`purchase_history_id`=`purchased_item_code`.`purchase_history_purchase_history_id`
            WHERE `purchase_history`.`user_id`='".$_SESSION["user"]["id"]."' 
            AND `purchased_item_code`.`purchased_item_code`='".$checking_code."'");

            if($rs->num_rows > 0){//already baught

                $movie_name_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`code`='".$checking_code."'");
                if($movie_name_rs->num_rows == 1){//its a movie

                    $name = $movie_name_rs->fetch_assoc();
                    array_push($arr,$name["name"]);

                }else{//check tv

                    $tv_name_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='".$checking_code."'");
                    if($tv_name_rs->num_rows == 1){

                        $name = $tv_name_rs->fetch_assoc();
                        array_push($arr,$name["name"]);

                    }

                }

            }

        }

        echo (json_encode($arr));

    }else{
        echo "Something Went Wrong";
    }

}else{
    header("Location:index.php");
}

?>