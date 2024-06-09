<?php

session_start();
require "../connection/connection.php";

if(!empty($_SESSION["user"])){

    if(!empty($_POST["type"]) && !empty($_POST["code"])){

        $type = $_POST["type"];
        $code = $_POST["code"];
        $epi_id = $_POST["epi_id"];

        if($type == 2){//tv

            $download_rs = Database::search("SELECT * FROM `download` 
            WHERE `download`.`user_id`='".$_SESSION["user"]["id"]."' AND `download`.`status_id`='1'");
            
            if($download_rs->num_rows > 0){ //has priviously downloaded

                $this_date_time = new DateTime();     
                $tz = new DateTimeZone("Asia/Colombo");
                $this_date_time->setTimezone($tz);

                $year = $this_date_time->format("Y");     
                $month = $this_date_time->format("m"); 

                $downloaded_count = 0;

                for($x = 0; $x < $download_rs->num_rows; $x++){

                    $downloaded_data = $download_rs->fetch_assoc();

                    $downloaded_date_time = strtotime($downloaded_data["date_time"]);
                    $downloaded_month = date("m",$downloaded_date_time);
                    $downloaded_year = date("Y",$downloaded_date_time);

                    if($downloaded_year == $year){
                        if($downloaded_month == $month){
    
                            $downloaded_count++;
    
                        }
                    }

                }

                $subscription_rs = Database::search("SELECT * FROM `user_subscription` INNER JOIN `subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
                WHERE `subscription`.`status_id`='1' AND `user_subscription`.`user_id`='".$_SESSION["user"]["id"]."' AND `user_subscription`.`status_id`='1' ");

                $subscription_data = $subscription_rs->fetch_assoc();


                $download_limit_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`id`='".$subscription_data["subscription_id"]."'");
                $download_limit_data = $download_limit_rs->fetch_assoc();

                if($downloaded_count > $download_limit_data["download_limit"]){
                    echo("4");
                }else{

                    $rs = Database::search("SELECT * FROM `episode` INNER JOIN `tv_series` ON `tv_series`.`id`=`episode`.`tv_series_id` 
                    WHERE `episode`.`status_id`='1' AND `tv_series`.`code`='".$code."' AND `episode`.`id`='".$epi_id."'");
                    $data = $rs->fetch_assoc();

                    $this_date_time = new DateTime();     
                    $tz = new DateTimeZone("Asia/Colombo");
                    $this_date_time->setTimezone($tz);
                    $date = $this_date_time->format("Y-m-d H:i:s");  
       
                    $video_path = $data["url"];

                    // Get the file status
                    $file_status = @stat($video_path);

                    if ($file_status === false) {
                        $last_error = error_get_last();
                        echo 'Error: ' . $last_error['message'];
                    }else {
                        
                        // Check the file permissions
                        if (($file_status['mode'] & 0x0080) === 0x0080) {// file is readable
                            
                            Database::iud("INSERT INTO `download`(`user_id`,`type_id`,`status_id`,`code`,`date_time`) 
                            VALUES('".$_SESSION["user"]["id"]."','".$type."','1','".$code."','".$date."')");
                            
                            if (file_exists($video_path)) {
                                header('Content-Description: File Transfer');
                                header('Content-Type: application/octet-stream');
                                header('Content-Disposition: attachment; filename="'.basename($video_path).'"');
                                header('Content-Transfer-Encoding: binary');
                                header('Expires: 0');
                                header('Cache-Control: must-revalidate');
                                header('Pragma: public');
                                ob_clean();
                                flush();
                                readfile($video_path);
                                exit;
                            }
                            
                        } else {
                            echo ('1');
                        }
                        
                    }

                }

            }else{ //previously have not downloaded

                $rs = Database::search("SELECT * FROM `tv_series` INNER JOIN `episode` ON `tv_series`.`id`=`episode`.`tv_series_id` 
                WHERE `episode`.`status_id`='1' AND `tv_series`.`code`='".$code."' AND `episode`.`id`='".$epi_id."'");
                $data = $rs->fetch_assoc();

                $this_date_time = new DateTime();     
                $tz = new DateTimeZone("Asia/Colombo");
                $this_date_time->setTimezone($tz);
                $date = $this_date_time->format("Y-m-d H:i:s");  
       
                $video_path = $data["url"];

                // Get the file status
                $file_status = @stat($video_path);

                if ($file_status === false) {
                    $last_error = error_get_last();
                    echo 'Error: ' . $last_error['message'];
                }else {
                    
                    // Check the file permissions
                    if (($file_status['mode'] & 0x0080) === 0x0080) {// file is readable
                            
                        Database::iud("INSERT INTO `download`(`user_id`,`type_id`,`status_id`,`code`,`date_time`) 
                        VALUES('".$_SESSION["user"]["id"]."','".$type."','1','".$code."','".$date."')");

                        if (file_exists($video_path)) {
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename="'.basename($video_path).'"');
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            ob_clean();
                            flush();
                            readfile($video_path);
                            exit;
                        }
                        
                    } else {
                        echo ('1');
                    }

                }

            }

        }

    }else{
        echo("2");
    }

}else{
    echo("3");
}

?>