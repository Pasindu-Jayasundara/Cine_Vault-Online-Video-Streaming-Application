<?php
require "../connection/connection.php";
session_start();


if (!empty($_POST["forgotPasswordNewPassword"])) {

    $forgotPasswordNewPassword = $_POST["forgotPasswordNewPassword"];

    $rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`admin_id`='" . $_SESSION["id"] . "' AND `admin`.`admin_status_id`='1'");
    $num = $rs->num_rows;

    if ($num == 1) {

        Database::iud("UPDATE `admin` SET `admin`.`password`='" . $forgotPasswordNewPassword . "' WHERE `admin`.`admin_id`='" . $_SESSION["id"] . "'");

        $n_rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`admin_id`='" . $_SESSION["id"] . "' AND `admin`.`admin_status_id`='1'");
        $n_data = $n_rs->fetch_assoc();

        $_SESSION["admin"] = $n_data;

        echo ("1");
    } else {
        echo ("Something Went Wrong");
    }
} else {
    echo ("Fill the Detais First");
}

?>