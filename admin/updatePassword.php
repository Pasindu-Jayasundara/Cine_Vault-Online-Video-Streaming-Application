<?php

require "../connection/connection.php";
session_start();

if (!empty($_SESSION["admin"])) {

    if (!empty(ltrim($_POST["oldP"])) && !empty(ltrim($_POST["newP"])) && !empty(ltrim($_POST["reNewP"]))) {

        $old_password = $_POST["oldP"];
        $new_password = $_POST["newP"];
        $re_type_new_password = $_POST["reNewP"];

        if ($new_password === $re_type_new_password) {

            if (strlen($new_password) <= 45) {

                $rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`admin_id`='" . $_SESSION["admin"]["admin_id"] . "' 
                AND `admin`.`admin_status_id`='1'");

                if ($rs->num_rows == 1) {
                    $data = $rs->fetch_assoc();

                    if ($data["password"] === $old_password) {

                        Database::iud("UPDATE `admin` SET `admin`.`password`='" . $new_password . "' 
                        WHERE `admin`.`admin_id`='" . $_SESSION["admin"]["admin_id"] . "' AND `admin`.`admin_status_id`='1' ");


                        $admin_rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`admin_id`='" . $_SESSION["admin"]["admin_id"] . "' 
                        AND `admin`.`admin_status_id`='1'");

                        $admin_data = $admin_rs->fetch_assoc();

                        $_SESSION["admin"] = $admin_data;


                        // echo("Password Succesfuly Updated");
                        echo ("1");
                    } else {
                        // echo("In-correct Old Password");
                        echo ("2");
                    }
                } else {
                    // echo("Couldn't Find The Admin");
                    echo ("3");
                }
            } else {
                // echo ("Password Size Must Be Less Than 45");
                echo ("6");
            }
        } else {
            // echo("New Passwords Don't Match");
            echo ("4");
        }
    } else {
        // echo("Fill The Details");
        echo ("5");
    }
} else {
    header("Location:index.php");
}

?>