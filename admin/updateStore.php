<?php

require "../connection/connection.php";
session_start();

if (!empty($_SESSION["admin"])) {

    if (!empty(ltrim($_POST["name"])) && !empty(ltrim($_POST["email"])) && !empty(ltrim($_POST["mobile"])) && !empty(ltrim($_POST["line_1"])) && !empty(ltrim($_POST["line_2"]))) {

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

            if (strlen($_POST["mobile"]) == 10) {

                if (preg_match("/[07][1,2,4,5,6,7,8][0-9]/", $_POST["mobile"])) {

                    if ($_POST["img"] == 2) {
                        $type = $_FILES["logo"]["type"];


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

                            $url = "../logo/" . uniqid() . $new_type;
                            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $url)) {

                                Database::iud("UPDATE `shop` SET `name`='" . $_POST["name"] . "',`email`='" . $_POST["email"] . "',`mobile`='" . $_POST["mobile"] . "',`line_1`='" . $_POST["line_1"] . "',
                                `line_2`='" . $_POST["line_2"] . "',`logo_link`='" . $url . "' ");

                                $date = new DateTime();
                                $tz = new DateTimeZone("Asia/Colombo");
                                $date->setTimezone($tz);
                                $today = $date->format("Y-m-d H:i:s");

                                Database::iud("INSERT INTO `shop_update`(`date_time`,`admin_admin_id`,`shop_id`) 
                                VALUES('" . $today . "','" . $_SESSION["admin"]["admin_id"] . "','1')");

                                // echo("Update Process Success");
                                echo ("1");
                            } else {
                                // echo("Logo Uploading Faild");
                                echo ("2");
                            }
                        } else {
                            // echo('Invalid Logo File Format');
                            echo ('3');
                        }
                    }else if($_POST["img"] == 1){

                        Database::iud("UPDATE `shop` SET `name`='" . $_POST["name"] . "',`email`='" . $_POST["email"] . "',`mobile`='" . $_POST["mobile"] . "',`line_1`='" . $_POST["line_1"] . "',
                        `line_2`='" . $_POST["line_2"] . "'");

                        $date = new DateTime();
                        $tz = new DateTimeZone("Asia/Colombo");
                        $date->setTimezone($tz);
                        $today = $date->format("Y-m-d H:i:s");

                        Database::iud("INSERT INTO `shop_update`(`date_time`,`admin_admin_id`,`shop_id`) 
                        VALUES('" . $today . "','" . $_SESSION["admin"]["admin_id"] . "','1')");

                        // echo("Update Process Success");
                        echo ("1");

                    }
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
