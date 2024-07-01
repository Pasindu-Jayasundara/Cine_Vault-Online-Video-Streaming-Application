<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $f_name = $_POST["first_name"];
    $l_name = $_POST["last_name"];
    $email = $_POST["email_address"];
    $mobile = $_POST["mobile_no"];

    if (!empty($f_name) && !empty($l_name) && !empty($email) && !empty($mobile)) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            if (strlen($mobile) == 10) {

                $pattern = "/07[0,1,2,4,5,6,7,8][0-9]/";
                if (preg_match($pattern, $mobile)) {

                    $rs = Database::search("SELECT * FROM `admin` INNER JOIN `admin_email` ON `admin`.`admin_id`=`admin_email`.`admin_admin_id` 
                    WHERE `admin`.`admin_status_id`='1' AND `admin_email`.`email`='" . $email . "'");

                    if ($rs->num_rows == 0) {

                        $password = uniqid();

                        $today = new DateTime();
                        $tz = new DateTimeZone("Asia/Colombo");
                        $today->setTimezone($tz);
                        $date = $today->format("Y-m-d H:i:s");

                        Database::iud("INSERT INTO `admin`(`first_name`,`last_name`,`password`,`admin_status_id`,`reg_date`) 
                        VALUES('" . $f_name . "','" . $l_name . "','" . $password . "','3','" . $date . "')");

                        $admin_id = Database::$db_connection->insert_id;

                        Database::iud("INSERT INTO `admin_email`(`email`,`admin_email_status_id`,`added_date`,`admin_admin_id`) 
                        VALUES('" . $email . "','3','" . $date . "','" . $admin_id . "')");

                        Database::iud("INSERT INTO `admin_profile_image`(`link`,`date_time`,`status_id`,`admin_admin_id`) 
                        VALUES('../profile_image/user.png','" . $date . "','1','" . $admin_id . "')");

                        Database::iud("INSERT INTO `admin_mobile`(`mobile`,`added_date`,`admin_mobile_status_id`,`admin_admin_id`) 
                        VALUES('" . $mobile . "','" . $date . "','1','" . $admin_id . "')");

                        Database::iud("INSERT INTO `admin_address`(`line_1`,`line_2`,`added_date`,`admin_address_status_id`,`admin_admin_id`,`city_id`) 
                        VALUES('not filled','not filled','" . $date . "','1','" . $admin_id . "','1')");


                        $obj = new stdClass();
                        $obj->password = $password;
                        $obj->username = $email;

                        $_SESSION["credential"] = json_encode($obj);

                        echo ("1");
                    } else {
                        // echo("Admin Already Exists");
                        echo ("2");
                    }
                }
            }
        } else {
            // echo("Invalid Email Address");
            echo ("3");
        }
    } else {
        // echo("Fill The Details");
        echo ("4");
    }
} else {
    header("Location:index.php");
}

?>