<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty(ltrim($_POST["clicked_type"])) && !empty(ltrim($_POST["clicked_id"]))) {

        if (!empty(ltrim($_POST["to"]))) {

            $to = $_POST["to"];
            $clicked_type = $_POST["clicked_type"];
            $clicked_id = $_POST["clicked_id"];

            $selected_table;

            if ($clicked_type == 'c') {
                $selected_table = "type";
            } else if ($clicked_type == 'g') {
                $selected_table = "genre";
            } else if ($clicked_type == 'q') {
                $selected_table = "quality";
            } else if ($clicked_type == 'y') {
                $selected_table = "year";
            } else if ($clicked_type == 'l') {
                $selected_table = "language";
            } else if ($clicked_type == 'con') {
                $selected_table = "country";
            }

            if ($selected_table == "type") {
                $selected_table_id = "id";
            } else {
                $selected_table_id = $selected_table . "_id";
            }

            Database::iud("UPDATE `$selected_table` SET `$selected_table`.`$selected_table`='" . $to . "'
            WHERE `$selected_table`.`$selected_table_id`='" . $clicked_id . "'");

            // echo("Update Success");
            echo ("1");
        } else {
            // echo("Insert 'To' Value");
            echo ("2");
        }
    } else {
        // echo("Something Went Wrong");
        echo ("3");
    }
} else {
    header("Location:index.php");
}

?>