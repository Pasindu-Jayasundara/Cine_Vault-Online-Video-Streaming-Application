<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["user"])) {

    if (!empty($_POST["type"]) && !empty($_POST["code"]) && !empty($_POST["epi_id"])) {

        $type = $_POST["type"];
        $code = $_POST["code"];
        $epi_id = $_POST["epi_id"];

        if ($type == 2) { //tv

            $watched_rs = Database::search("SELECT * FROM `watch` 
            WHERE `watch`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `watch`.`status_id`='1'");

            if ($watched_rs->num_rows > 0) { //has priviously watched

                $this_date_time = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $this_date_time->setTimezone($tz);

                $year = $this_date_time->format("Y");
                $month = $this_date_time->format("m");

                $watched_count = 0;

                for ($x = 0; $x < $watched_rs->num_rows; $x++) {

                    $watched_data = $watched_rs->fetch_assoc();

                    $watched_date_time = strtotime($watched_data["date_time"]);
                    $watched_month = date("m", $watched_date_time);
                    $watched_year = date("Y", $watched_date_time);

                    if ($watched_year == $year) {
                        if ($watched_month == $month) {

                            $watched_count++;
                        }
                    }
                }

                $subscription_rs = Database::search("SELECT * FROM `user_subscription` INNER JOIN `subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
                WHERE `subscription`.`status_id`='1' AND `user_subscription`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `user_subscription`.`status_id`='1' ");

                $subscription_data = $subscription_rs->fetch_assoc();

                $watch_limit_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`id`='" . $subscription_data["subscription_id"] . "'");
                $watch_limit_data = $watch_limit_rs->fetch_assoc();

                if (isset($_POST["b"]) && !empty($_POST["b"])) {

                    $rs = Database::search("SELECT * FROM `episode` INNER JOIN `tv_series` ON `tv_series`.`id`=`episode`.`tv_series_id` 
                        WHERE `episode`.`status_id`='1' AND `tv_series`.`code`='" . $code . "' AND `episode`.`id`='" . $epi_id . "'");

                        $data = $rs->fetch_assoc();

                        $this_date_time = new DateTime();
                        $tz = new DateTimeZone("Asia/Colombo");
                        $this_date_time->setTimezone($tz);
                        $date = $this_date_time->format("Y-m-d H:i:s");

                        $video_path = $data["url"];

                        echo $video_path;

                } else {

                    if ($watched_count > $watch_limit_data["watch_limit"]) {
                        echo ("4");
                    } else {

                        $rs = Database::search("SELECT * FROM `episode` INNER JOIN `tv_series` ON `tv_series`.`id`=`episode`.`tv_series_id` 
                        WHERE `episode`.`status_id`='1' AND `tv_series`.`code`='" . $code . "' AND `episode`.`id`='" . $epi_id . "'");

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
                        } else {
                            // Check the file permissions
                            if (($file_status['mode'] & 0x0080) === 0x0080) { // file is readable

                                Database::iud("INSERT INTO `watch`(`user_id`,`type_id`,`status_id`,`code`,`date_time`) 
                                VALUES('" . $_SESSION["user"]["id"] . "','" . $type . "','1','" . $code . "','" . $date . "')");

                                echo ($video_path);
                            } else {
                                echo ('1');
                            }
                        }
                    }
                }
            } else { //previously have not watched

                $rs = Database::search("SELECT * FROM `episode` INNER JOIN `tv_series` ON `tv_series`.`id`=`episode`.`tv_series_id` 
                WHERE `episode`.`status_id`='1' AND `tv_series`.`code`='" . $code . "' AND `episode`.`id`='" . $epi_id . "'");

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
                } else {
                    // Check the file permissions
                    if (($file_status['mode'] & 0x0080) === 0x0080) { // file is readable

                        Database::iud("INSERT INTO `watch`(`user_id`,`type_id`,`status_id`,`code`,`date_time`) 
                        VALUES('" . $_SESSION["user"]["id"] . "','" . $type . "','1','" . $code . "','" . $date . "')");

                        echo ($video_path);
                    } else {
                        echo ('1');
                    }
                }
            }
        }
    } else {
        echo ("2");
    }
} else {
    echo ("3");
}
?>