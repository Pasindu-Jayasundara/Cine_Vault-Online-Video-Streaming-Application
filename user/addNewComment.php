<?php
session_start();
require "../connection/connection.php";

if (!empty($_POST["txt"])) {

    if (!empty($_SESSION["user"])) {

        $user_id = $_SESSION["user"]["id"];

        $txt = $_POST["txt"];
        $type = $_POST["type"];
        $code = $_POST["code"];

        $date = new DateTime();
        $time_zone = new DateTimeZone("Asia/Colombo");
        $date->setTimezone($time_zone);
        $today = $date->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `comment`(`comment`,`date_time`,`type_id`,`user_id`,`code`) 
        VALUES('" . $txt . "','" . $today . "','" . $type . "','" . $user_id . "','" . $code . "')");

        echo ("1");
    } else {
        echo ("2");
    }
} else {
    echo ("Type Your Comment First");
}

?>