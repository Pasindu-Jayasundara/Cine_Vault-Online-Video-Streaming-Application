<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $name = $_POST["name"];
    $release_date = $_POST["date"];
    $file = $_FILES["file"];

    if(!empty($name)&&!empty($release_date)&&!empty($file)){

        $rs = Database::search("SELECT * FROM `upcomming_content` WHERE `upcomming_content`.`status_id`='1' 
        AND `upcomming_content`.`content_name`='".$name."' AND `upcomming_content`.`release_date`='".$release_date."'");

        if($rs->num_rows == 0){

            $type = $file["type"];

            $valid_type = ["image/png","image/jpg","image/jpeg"];

            if(in_array($type,$valid_type)){

                $new_type;
                if($type == "image/png"){
                    $new_type=".png";
                }else if($type == "image/jpg"){
                    $new_type=".jpg";
                }else if($type == "image/jpeg"){
                    $new_type=".jpeg";
                }

                $url = "../upcomming/".$name.uniqid().$new_type;

                if(move_uploaded_file($file["tmp_name"],$url)){

                    $date = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $date->setTimezone($tz);
                    $today = $date->format("Y-m-d H:i:s");

                    Database::iud("INSERT INTO `upcomming_content`(`content_name`,`release_date`,`date_time`,`url`,`by`,`status_id`) 
                    VALUES('".$name."','".$release_date."','".$today."','".$url."','".$_SESSION["admin"]["admin_id"]."','1')");

                    // echo("Content Adding Successful");
                    echo("1");

                }else{
                    // echo("File Uploading Faild");
                    echo("2");
                }

            }else{
                // echo("Invalid File Type");
                echo("3");
            }

        }else{
            // echo("Content Already Exists");
            echo("4");
        }

    }else{
        // echo("Insert Relavant Details");
        echo("5");
    }

}else{
    header("Location:index.php");
}