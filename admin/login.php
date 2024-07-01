<?php

session_start();
require "../connection/connection.php";

if (!empty($_POST["email"]) && !empty($_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $admin_rs = Database::search("SELECT * FROM `admin` INNER JOIN `admin_email` ON `admin`.`admin_id`=`admin_email`.`admin_admin_id` 
    WHERE `admin`.`password`='" . $password . "' AND `admin`.`admin_status_id`='1' AND `admin_email`.`email`='" . $email . "' 
    AND `admin_email`.`admin_email_status_id`='1'");

    $admin_num = $admin_rs->num_rows;

    if ($admin_num == 1) {

        $data = $admin_rs->fetch_assoc();

        $_SESSION["admin"] = $data;

        echo ("1");
    } else {
        echo ("Incorrect Details");
    }
} else {
    echo ("Please Enter Your Details");
}

?>