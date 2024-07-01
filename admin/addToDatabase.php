<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty(ltrim($_POST["new_clicked_type"]))) {

        if (!empty(ltrim($_POST["new_name"]))) {

            $new_name = $_POST["new_name"];
            $clicked_type = $_POST["new_clicked_type"];

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

            Database::iud("INSERT INTO `$selected_table`(`$selected_table`) VALUES('" . $new_name . "')");

            // echo("adding Success");
            echo ("1");
        } else {
            // echo("Insert New Value");
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