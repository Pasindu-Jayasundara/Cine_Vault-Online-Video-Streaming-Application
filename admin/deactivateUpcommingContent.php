<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["admin"])){

    if(!empty($_POST["id"]) && !empty("status")){

        $id = $_POST["id"];
        $status = $_POST["status"];

        if($status == 1){//must be active one to be deactivated

            Database::iud("UPDATE `upcomming_content` SET `upcomming_content`.`status_id`='2'");

            // echo("De-activation Successful");
            echo("1");

        }else{
            // echo("Something Went Wrong");
            echo("2");
        }

    }else{
        // echo("Something Went Wrong !");
        echo("2");
    }

}else{
    header("Location:index.php");
}

?>