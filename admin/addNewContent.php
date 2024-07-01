<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["releasedDate"]) && !empty($_POST["rating"]) && $_POST["newContentHours"] >= 0 || $_POST["newContentHours"] <= 24 && $_POST["newContentMinutes"] >= 0 || $_POST["newContentMinutes"] <= 60 && !empty($_POST["type"]) && !empty($_POST["genre"]) && !empty($_POST["quality"]) && !empty($_POST["language"]) && !empty($_POST["year"]) && !empty($_POST["country"]) && !empty($_POST["name"]) && !empty($_POST["director"]) && !empty($_POST["price"]) && !empty($_FILES["img"]) && !empty($_POST["description"])) {

        $type = $_POST["type"];
        $genre = $_POST["genre"];
        $quality = $_POST["quality"];
        $language = $_POST["language"];
        $year = $_POST["year"];
        $country = $_POST["country"];
        $name = $_POST["name"];
        $director = $_POST["director"];
        $price = $_POST["price"];
        $img = $_FILES["img"];
        $description = $_POST["description"];
        $releasedDate = $_POST["releasedDate"];
        $newContentHours = $_POST["newContentHours"];
        $newContentMinutes = $_POST["newContentMinutes"];
        $rating = $_POST["rating"];

        $combined_length = strtotime($newContentHours . ":" . $newContentMinutes);

        $length = date("H:i", $combined_length);

        // $date = new DateTime();
        // $tz = new DateTimeZone("Asia/Colombo");
        // $date->setTimezone($tz);
        // $today = $date->format("Y-m-d H:i:s");

        $code = uniqid();
        $img_url_code = uniqid();

        $valid_img = ["image/jpg", "image/jpeg", "image/png"];
        if (in_array($img["type"], $valid_img)) {

            $type = $img["type"];
            $new_type;

            if ($type == "image/jpg") {
                $new_type = ".jpg";
            } else if ($type == "image/jpeg") {
                $new_type = ".jpeg";
            } else if ($type == "image/png") {
                $new_type = ".png";
            }

            if ($_POST["type"] == 1) { // movie
                $movie = $_FILES["movie"];

                $valid_movie = ["video/mp4", "video/x-msvideo", "video/x-ms-wmv", "video/quicktime", "video/x-flv"];
                if (in_array($movie["type"], $valid_movie)) {

                    $m_type = $movie["type"];
                    $m_new_type;

                    if ($m_type == "video/mp4") {
                        $m_new_type = ".mp4";
                    } else if ($m_type == "video/x-msvideo") {
                        $m_new_type = ".avi";
                    } else if ($m_type == "video/x-ms-wmv") {
                        $m_new_type = ".wmv";
                    } else if ($m_type == "video/quicktime") {
                        $m_new_type = ".mov";
                    } else if ($m_type == "video/x-flv") {
                        $m_new_type = ".flv";
                    }

                    $movie_url_code = uniqid();

                    $movie_url = "../movie/" . $movie_url_code . $m_new_type;
                    if (move_uploaded_file($movie["tmp_name"], $movie_url)) {

                        $url = "../images/" . $img_url_code . $new_type;
                        if (move_uploaded_file($img["tmp_name"], $url)) {

                            Database::iud("INSERT INTO `movie`(`name`,`date_time`,`description`,`price`,`code`,`status_id`,`quality_quality_id`,`year_year_id`,`language_language_id`,`country_country_id`,`rating`,`director`)
                            VALUES('" . $name . "','" . $releasedDate . "','" . $description . "','" . $price . "','" . $code . "','1','" . $quality . "','" . $year . "','" . $language . "','" . $country . "','" . $rating . "','" . $director . "')");

                            $movie_id = Database::$db_connection->insert_id;

                            Database::iud("INSERT INTO `movie_url`(`url`,`movie_id`,`lenght`) 
                            VALUES('" . $movie_url . "','" . $movie_id . "','" . $length . "')");

                            Database::iud("INSERT INTO `movie_cover`(`link`,`movie_id`,`movie_code`,`status_id`)
                            VALUES('" . $url . "','" . $movie_id . "','" . $code . "','1')");

                            Database::iud("INSERT INTO `movie_has_genre`(`movie_id`,`movie_code`,`status_id`,`genre_genre_id`) 
                            VALUES('" . $movie_id . "','" . $code . "','1','" . $genre . "')");

                            // echo ("New Content Adding Successful");
                            echo ("1");
                        } else {
                            // echo ("Movie Cover Uploading Faild");
                            echo ("2");
                        }
                    } else {
                        // echo ("Movie Uploading Faild");
                        echo ("3");
                    }
                } else {
                    // echo ("Invalid Movie File Format");
                    echo ("4");
                }
            } else if ($_POST["type"] == 2) { //tv

                $url = "../images/" . $img_url_code . $new_type;
                if (move_uploaded_file($img["tmp_name"], $url)) {

                    Database::iud("INSERT INTO `tv_series`(`name`,`date_time`,`description`,`price`,`code`,`status_id`,`year_year_id`,`quality_quality_id`,`language_language_id`,`country_country_id`,`rating`,`director`) 
                    VALUES('" . $name . "','" . $releasedDate . "','" . $description . "','" . $price . "','" . $code . "','1','" . $year . "','" . $quality . "','" . $language . "','" . $country . "','" . $rating . "','" . $director . "')");

                    $tv_id = Database::$db_connection->insert_id;

                    Database::iud("INSERT INTO `tv_series_cover`(`link`,`tv_series_id`,`tv_series_code`,`status_id`) 
                    VALUES('" . $url . "','" . $tv_id . "','" . $code . "','1')");

                    Database::iud("INSERT INTO `tv_series_has_genre`(`tv_series_id`,`tv_series_code`,`status_id`,`genre_genre_id`) 
                    VALUES('" . $tv_id . "','" . $code . "','1','" . $genre . "')");

                    // echo ("New Content Adding Successful");
                    echo ("1");
                } else {
                    // echo("Tv-Series Cover Image Uploading Faild");
                    echo ("5");
                }
            }
        } else {
            // echo ("Invalid Image Format");
            echo ("6");
        }
    } else {
        // echo("Please Provide All Necessary Details");
        echo ("7");
    }
} else {
    header("Location:index.php");
}

?>