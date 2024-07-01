<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["select_tv"])) {

        if (!empty($_POST["name"])) {

            if ($_POST["hours"] > -1 && $_POST["hours"] < 25) {

                if ($_POST["minutes"] >= 0 && $_POST["minutes"] < 60) {

                    if (!empty($_FILES["episode"])) {

                        if (!empty($_POST["rating"])) {

                            $tv_id = $_POST["select_tv"];
                            $name = $_POST["name"];
                            $hours = $_POST["hours"];
                            $minutes = $_POST["minutes"];
                            $rating = $_POST["rating"];
                            $file = $_FILES["episode"];

                            $rs = Database::search("SELECT * FROM `episode` INNER JOIN `tv_series` ON `tv_series`.`id`=`episode`.`tv_series_id` 
                            WHERE `episode`.`tv_series_id`='" . $tv_id . "' 
                            AND `episode`.`name`='" . $name . "' AND `episode`.`status_id`='1' 
                            AND `tv_series`.`status_id`='1'");

                            if ($rs->num_rows == 0) {

                                $valid = ["video/mp4", "video/x-msvideo", "video/x-ms-wmv", "video/quicktime", "video/x-flv"];
                                if (in_array($file["type"], $valid)) {

                                    $type = $file["type"];
                                    $new_type;

                                    if ($type == "video/mp4") {
                                        $new_type = ".mp4";
                                    } else if ($type == "video/x-msvideo") {
                                        $new_type = ".avi";
                                    } else if ($type == "video/x-ms-wmv") {
                                        $new_type = ".wmv";
                                    } else if ($type == "video/quicktime") {
                                        $new_type = ".mov";
                                    } else if ($type == "video/x-flv") {
                                        $new_type = ".flv";
                                    }

                                    $url = "../episode/" . uniqid() . $new_type;

                                    if (move_uploaded_file($file["tmp_name"], $url)) {

                                        $date = new DateTime();
                                        $tz = new DateTimeZone("Asia/Colombo");
                                        $date->setTimezone($tz);
                                        $today = $date->format("Y-m-d H:i:s");

                                        $time_str = $hours . ":" . $minutes;
                                        $time = strtotime($time_str);
                                        $length = date("H:i", $time);

                                        $query = "SELECT * FROM `episode` WHERE `tv_series_id`='" . $tv_id . "' AND `episode`.`status_id`='1'";
                                        $epi_rs = Database::search($query);

                                        if ($epi_rs->num_rows == 0) { //episodes not availiable

                                            Database::iud("INSERT INTO `episode`(`ep_number`,`tv_series_id`,`date_time`,`url`,`name`,`length`,`status_id`,`rating`) 
                                            VALUES('1','" . $tv_id . "','" . $today . "','" . $url . "','" . $name . "','" . $length . "','1','" . $rating . "')");

                                            // echo("Successfully Completed");
                                            echo ("1");
                                        } else { //episode availiable

                                            $epi_num_rs = $query .= " ORDER BY `ep_number` DESC";
                                            $result_rs = Database::search($epi_num_rs);
                                            $result_data = $result_rs->fetch_assoc();

                                            $ep_number = intval($result_data["ep_number"]) + 1;

                                            Database::iud("INSERT INTO `episode`(`ep_number`,`tv_series_id`,`date_time`,`url`,`name`,`length`,`status_id`,`rating`) 
                                            VALUES('" . $ep_number . "','" . $tv_id . "','" . $today . "','" . $url . "','" . $name . "','" . $length . "','1','" . $rating . "')");

                                            // echo("Successfully Completed");
                                            echo ("1");
                                        }
                                    } else {
                                        // echo("File Uploading Faild");
                                        echo ("2");
                                    }
                                } else {
                                    // echo("Invalid File Format");
                                    echo ("3");
                                }
                            } else {
                                // echo("Episode Already Exists");
                                echo ("4");
                            }
                        } else {
                            echo ("10");
                        }
                    } else {
                        // echo("Select Episode File");
                        echo ("5");
                    }
                } else {
                    // echo("Invalid Minutes");
                    echo ("6");
                }
            } else {
                // echo("Invalid Hours");
                echo ("7");
            }
        } else {
            // echo("Insert Episode Name");
            echo ("8");
        }
    } else {
        // echo("Select Tv Series");
        echo ("9");
    }
} else {
    header("Location:index.php");
}

?>