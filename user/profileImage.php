<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_FILES["file"])){

        $file = $_FILES["file"];

        $rs = Database::search("SELECT `profile_image`.`id` FROM `profile_image` INNER JOIN `user` ON `user`.`id`=`profile_image`.`user_id` 
        WHERE `user`.`id`='".$_SESSION["user"]["id"]."' AND `user`.`status_id`='1' AND `profile_image`.`status_id`='1' AND `profile_image`.`id`!='1'");

        $date = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $date->setTimezone($tz);
        $today = $date->format("Y-m-d H:i:s");

        if($rs->num_rows == 1){

            $data = $rs->fetch_assoc();
            Database::iud("UPDATE `profile_image` SET `profile_image`.`status_id`='2' WHERE `profile_image`.`id`='".$data["id"]."' AND `profile_image`.`status_id`='1'");

        }

        $file_type = $file["type"];
        $type;

        if($file_type == "image/jpeg"){
            $type = ".jpeg";
        }else if($file_type == "image/png"){
            $type = ".png";
        }else if($file_type == "image/jpg"){
            $type = ".jpg";
        }else{
            echo("Invalid File Type");
        }

        $id = uniqid();
        $new_link = "../profile_image/".$id.$type;

        if(move_uploaded_file($file["tmp_name"],$new_link)){

            Database::iud("INSERT INTO `profile_image`(`date_time`,`status_id`,`link`,`user_id`) 
            VALUES('".$today."','1','".$new_link."','".$_SESSION["user"]["id"]."')");

            echo("Profile Image Updated");

        }else{
            echo("Profile Image Uploading Faild");
        }

    }else{
        echo("Please Select A Profile Image");
    }

}else{
    echo("Please LogIn First");
}

?>