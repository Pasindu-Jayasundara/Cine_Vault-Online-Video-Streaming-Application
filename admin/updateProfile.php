<?php

require "../connection/connection.php";
session_start();

if (!empty($_SESSION["admin"])) {

    if (!empty(ltrim($_POST["f_name"])) && !empty(ltrim($_POST["l_name"])) && !empty(ltrim($_POST["email"])) && !empty(ltrim($_POST["mobile"])) && !empty(ltrim($_POST["line_1"])) && !empty(ltrim($_POST["line_2"]))) {

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

            if (strlen($_POST["mobile"]) == 10) {

                if (preg_match("/[07][1,2,4,5,6,7,8][0-9]/", $_POST["mobile"])) {

                    if ($_POST["img"] == 2) {
                        $type = $_FILES["profile"]["type"];


                        $valid = ['image/png', 'image/jpg', 'image/jpeg'];

                        if (in_array($type, $valid)) {

                            $new_type;
                            if ($type == 'image/png') {
                                $new_type = '.png';
                            } else if ($type == 'imnage/jpg') {
                                $new_type = '.jpg';
                            } else if ($type == 'image/jpeg') {
                                $new_type = '.jpeg';
                            }

                            $url = "../admin_profile_image/" . uniqid() . $new_type;
                            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $url)) {

                                $date = new DateTime();
                                $tz = new DateTimeZone("Asia/Colombo");
                                $date->setTimezone($tz);
                                $today = $date->format("Y-m-d H:i:s");

                                Database::iud("UPDATE `admin` SET `first_name`='" . $_POST["f_name"] . "',`last_name`='" . $_POST["l_name"] . "' ");



                                Database::iud("UPDATE `admin_email` SET `admin_email`.`admin_email_status_id`='2' 
                                WHERE `admin_email`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_email`.`admin_email_status_id`='1' ");

                                Database::iud("INSERT INTO `admin_email`(`email`,`admin_email_status_id`,`added_date`,`admin_admin_id`) 
                                VALUES('" . $_POST["email"] . "','1','" . $today . "','" . $_SESSION["admin"]["admin_id"] . "')");



                                Database::iud("UPDATE `admin_profile_image` SET `status_id`='2' 
                                WHERE `admin_profile_image`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_profile_image`.`status_id`='1' ");

                                Database::iud("INSERT INTO `admin_profile_image`(`date_time`,`admin_admin_id`,`status_id`,`link`) 
                                VALUES('" . $today . "','" . $_SESSION["admin"]["admin_id"] . "','1','" . $url . "')");



                                Database::iud("UPDATE `admin_mobile` SET `admin_mobile`.`admin_mobile_status_id`='2' 
                                WHERE `admin_mobile`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_mobile`.`admin_mobile_status_id`='1' ");

                                Database::iud("INSERT INTO `admin_mobile`(`mobile`,`admin_mobile_status_id`,`added_date`,`admin_admin_id`) 
                                VALUES('" . $_POST["mobile"] . "','1','" . $today . "','" . $_SESSION["admin"]["admin_id"] . "')");



                                Database::iud("UPDATE `admin_address` SET `admin_address`.`admin_address_status_id`='2' 
                                WHERE `admin_address`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_address`.`admin_address_status_id`='1' ");

                                Database::iud("INSERT INTO `admin_address`(`line_1`,`line_2`,`admin_address_status_id`,`added_date`,`admin_admin_id`,`city_id`) 
                                VALUES('" . $_POST["line_1"] . "','" . $_POST["line_2"] . "','1','" . $today . "','" . $_SESSION["admin"]["admin_id"] . "','" . $_POST["city"] . "')");

                                // echo("Update Process Success");
                                echo ("1");
                            } else {
                                // echo("img Uploading Faild");
                                echo ("2");
                            }
                        } else {
                            // echo('Invalid img File Format');
                            echo ('3');
                        }
                    } else if ($_POST["img"] == 1) {

                        $date = new DateTime();
                        $tz = new DateTimeZone("Asia/Colombo");
                        $date->setTimezone($tz);
                        $today = $date->format("Y-m-d H:i:s");

                        Database::iud("UPDATE `admin` SET `first_name`='" . $_POST["f_name"] . "',`last_name`='" . $_POST["l_name"] . "' ");



                        Database::iud("UPDATE `admin_email` SET `admin_email`.`admin_email_status_id`='2' 
                                WHERE `admin_email`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_email`.`admin_email_status_id`='1' ");

                        Database::iud("INSERT INTO `admin_email`(`email`,`admin_email_status_id`,`added_date`,`admin_admin_id`) 
                                VALUES('" . $_POST["email"] . "','1','" . $today . "','" . $_SESSION["admin"]["admin_id"] . "')");



                        Database::iud("UPDATE `admin_mobile` SET `admin_mobile`.`admin_mobile_status_id`='2' 
                                WHERE `admin_mobile`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_mobile`.`admin_mobile_status_id`='1' ");

                        Database::iud("INSERT INTO `admin_mobile`(`mobile`,`admin_mobile_status_id`,`added_date`,`admin_admin_id`) 
                                VALUES('" . $_POST["mobile"] . "','1','" . $today . "','" . $_SESSION["admin"]["admin_id"] . "')");



                        Database::iud("UPDATE `admin_address` SET `admin_address`.`admin_address_status_id`='2' 
                                WHERE `admin_address`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin_address`.`admin_address_status_id`='1' ");

                        Database::iud("INSERT INTO `admin_address`(`line_1`,`line_2`,`admin_address_status_id`,`added_date`,`admin_admin_id`,`city_id`) 
                                VALUES('" . $_POST["line_1"] . "','" . $_POST["line_2"] . "','1','" . $today . "','" . $_SESSION["admin"]["admin_id"] . "','" . $_POST["city"] . "')");


                        // echo("Update Process Success");
                        echo ("1");
                    }




                    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`admin_id`='" . $_SESSION["admin"]["admin_id"] . "' 
                    AND `admin`.`admin_status_id`='1'");

                    $admin_data = $admin_rs->fetch_assoc();

                    $_SESSION["admin"] = $admin_data;
                } else {
                    // echo("In-valid Mobile Number");
                    echo ("4");
                }
            } else {
                // echo("Mobile Number Limit is 10");
                echo ("5");
            }
        } else {
            // echo("In-valid Email Address");
            echo ("6");
        }
    } else {
        // echo("Fill The Details");
        echo ("7");
    }
} else {
    header("Location:index.php");
}

?>