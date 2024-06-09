<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $tvSeriesId = $_POST["tvSeriesId"];
    $episodeId = $_POST["episodeId"];
    $episodeStatus = $_POST["episodeStatus"];

    $tv_Status_rs = Database::search("SELECT `status_id` FROM `tv_series` WHERE `tv_series`.`id`='".$tvSeriesId."'");

    if($tv_Status_rs->num_rows == 1){

        $tv_data = $tv_Status_rs->fetch_assoc();

        if($tv_data["status_id"] == 1){//active tv series

            $today = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $today->setTimezone($tz);
            $date = $today->format("Y-m-d H:i:s");

            if($episodeStatus == 1){//deactivate

                if(!empty($_POST["reason"])){
                    $reason = $_POST["reason"];

                    // tv
                    Database::iud("UPDATE `episode` SET `episode`.`status_id`='2' WHERE `episode`.`id`='".$episodeId."' AND `episode`.`tv_series_id`='".$tvSeriesId."' AND `episode`.`status_id`='1'");
                                
                    Database::iud("INSERT INTO `episode_status_change`(`reason`,`date_time`,`by`,`episode_id`,`tv_series_id`) 
                    VALUES('".$reason."','".$date."','".$_SESSION["admin"]["admin_id"]."','".$episodeId."','".$tvSeriesId."')");
            
                    // echo("De-Activation Successful");
                    echo("1");
            
                }else{
                    // echo("Please Insert The Reason For The De-activation");
                    echo("2");
                }

            }
            
            if($episodeStatus == 2){//activate

                Database::iud("UPDATE `episode` SET `episode`.`status_id`='1' WHERE `episode`.`id`='".$episodeId."' AND `episode`.`tv_series_id`='".$tvSeriesId."' AND `episode`.`status_id`='2'");

                Database::iud("INSERT INTO `episode_status_change`(`date_time`,`by`,`episode_id`,`tv_series_id`) 
                VALUES('".$date."','".$_SESSION["admin"]["admin_id"]."','".$episodeId."','".$tvSeriesId."')");

                // echo("Re-Activation Successful");
                echo("3");

            }

        }else{
            // echo("Please Activate Relavant Tv-Series First");
            echo("4");
        }

    }else{
        // echo("Couldn't Find The Tv-Series");
        echo("5");
    }

}else{
    header("Location:index.php");
}

?>