<?php

session_start();
require "../connection/connection.php";

if (!empty($_GET["value"]) && !empty($_GET["by"]) && !empty($_GET["type"])) {

    $value = $_GET["value"];
    $by = $_GET["by"];
    $type = $_GET["type"];

    if ($type == "movie") {

        $query = "SELECT * FROM `movie` 
        INNER JOIN `quality` ON `quality`.`quality_id`=`movie`.`quality_quality_id`
        INNER JOIN `movie_has_genre` ON `movie_has_genre`.`movie_id`=`movie`.`id`
        INNER JOIN `genre` ON `genre`.`genre_id`=`movie_has_genre`.`genre_genre_id`
        INNER JOIN `year` ON `year`.`year_id`=`movie`.`year_year_id`
        INNER JOIN `language` ON `language`.`language_id`=`movie`.`language_language_id`
        INNER JOIN `country` ON `country`.`country_id`=`movie`.`country_country_id`
        WHERE ";


        if (!empty($_GET["quality"])) {
            $quality = $_GET["quality"];

            $query .= " `quality`.`quality_id`='" . $quality . "' AND `movie`.`status_id`='1' AND `quality`.`status_id`='1'";
        }
        if (!empty($_GET["genre"])) {

            $genre = $_GET["genre"];
            if ($_GET["quality"] != 0) {

                $query .= " AND `genre`.`genre_id`='" . $genre . "' AND `movie`.`status_id`='1' AND `genre`.`status_id`='1'";
            } else {
                $query .= " `genre`.`genre_id`='" . $genre . "' AND `movie`.`status_id`='1' AND `genre`.`status_id`='1'";
            }
        }
        if (!empty($_GET["year"])) {

            $year = $_GET["year"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0) {

                $query .= " AND `year`.`year_id`='" . $year . "' AND `movie`.`status_id`='1' AND `year`.`status_id`='1'";
            } else {
                $query .= " `year`.`year_id`='" . $year . "' AND `movie`.`status_id`='1' AND `year`.`status_id`='1'";
            }
        }
        if (!empty($_GET["language"])) {

            $language = $_GET["language"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0) {

                $query .= " AND `language`.`language_id`='" . $language . "' AND `movie`.`status_id`='1' AND `language`.`status_id`='1'";
            } else {
                $query .= " `language`.`language_id`='" . $language . "' AND `movie`.`status_id`='1' AND `language`.`status_id`='1'";
            }
        }
        if (!empty($_GET["country"])) {

            $country = $_GET["country"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0 || $_GET["language"] != 0) {

                $query .= " AND `country`.`country_id`='" . $country . "' AND `movie`.`status_id`='1' AND `country`.`status_id`='1'";
            } else {
                $query .= " `country`.`country_id`='" . $country . "' AND `movie`.`status_id`='1' AND `country`.`status_id`='1'";
            }
        }


        $rs = Database::search($query);

        if ($rs->num_rows == 0) {
            // echo ("Couldn't Find Relavant Content");
?>
            <div class="no_content">
                <div class="mt-5">
                    <h2 class="text-secondary text-center">
                        Couldn't Find Relavant Content
                    </h2>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="../design_images/no_content_7.png" class="position-absolute" style="width:20%; margin-top: 4%;" />
                </div>
            </div>
        <?php
        } else {

        ?>
            <label class="form-label">Relavant Movies</label>

            <div class="container-fluid pb-3">
                <div class="d-grid gap-3 p-2">

                    <!-- cards -->
                    <div class="row row-cols-1 row-cols-md-5 g-4">
                        <?php

                        for ($x = 0; $x < $rs->num_rows; $x++) {
                            $data = $rs->fetch_assoc();

                            $movie_cover_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_id`='" . $data["id"] . "'");
                            $movie_cover = $movie_cover_rs->fetch_assoc();

                            if ($by == "genre") {
                                $movie_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`id`='" . $data["movie_id"] . "' AND `movie`.`status_id`='1'");
                                $movie_data = $movie_rs->fetch_assoc();

                        ?>

                                <label data-bs-toggle="tooltip<?php echo $data['movie_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $movie_data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:100px;" onmouseover="movieDescription('<?php echo $data['movie_code']; ?>');" onclick="singleContentLoad('m','<?php echo $data['movie_code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_cover["link"]; ?>')" />
                                        </div>
                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["movie_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                            <?php
                            } else {
                            ?>

                                <label data-bs-toggle="tooltip<?php echo $data['code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $data['name']; ?>">

                                    <div class="col mt-5">
                                        <div class="card h-100" onmouseover="movieDescription('<?php echo $data['code']; ?>');" onclick="singleContentLoad('m','<?php echo $data['code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_cover["link"]; ?>')" />
                                        </div>

                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["movie_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

        <?php
        }
    } else if ($type == "tv") {

        $query = "SELECT * FROM `tv_series` 
        INNER JOIN `quality` ON `quality`.`quality_id`=`tv_series`.`quality_quality_id`
        INNER JOIN `tv_series_has_genre` ON `tv_series_has_genre`.`tv_series_id`=`tv_series`.`id`
        INNER JOIN `genre` ON `genre`.`genre_id`=`tv_series_has_genre`.`genre_genre_id`
        INNER JOIN `year` ON `year`.`year_id`=`tv_series`.`year_year_id`
        INNER JOIN `language` ON `language`.`language_id`=`tv_series`.`language_language_id`
        INNER JOIN `country` ON `country`.`country_id`=`tv_series`.`country_country_id`
        WHERE ";


        if (!empty($_GET["quality"])) {
            $quality = $_GET["quality"];

            $query .= " `quality`.`quality_id`='" . $quality . "' AND `tv_series`.`status_id`='1' AND `quality`.`status_id`='1'";
        }
        if (!empty($_GET["genre"])) {

            $genre = $_GET["genre"];
            if ($_GET["quality"] != 0) {

                $query .= " AND `genre`.`genre_id`='" . $genre . "' AND `tv_series`.`status_id`='1' AND `genre`.`status_id`='1'";
            } else {
                $query .= " `genre`.`genre_id`='" . $genre . "' AND `tv_series`.`status_id`='1' AND `genre`.`status_id`='1'";
            }
        }
        if (!empty($_GET["year"])) {

            $year = $_GET["year"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0) {

                $query .= " AND `year`.`year_id`='" . $year . "' AND `tv_series`.`status_id`='1' AND `year`.`status_id`='1'";
            } else {
                $query .= " `year`.`year_id`='" . $year . "' AND `tv_series`.`status_id`='1' AND `year`.`status_id`='1'";
            }
        }
        if (!empty($_GET["language"])) {

            $language = $_GET["language"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0) {

                $query .= " AND `language`.`language_id`='" . $language . "' AND `tv_series`.`status_id`='1' AND `language`.`status_id`='1'";
            } else {
                $query .= " `language`.`language_id`='" . $language . "' AND `tv_series`.`status_id`='1' AND `language`.`status_id`='1'";
            }
        }
        if (!empty($_GET["country"])) {

            $country = $_GET["country"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0 || $_GET["language"] != 0) {

                $query .= " AND `country`.`country_id`='" . $country . "' AND `tv_series`.`status_id`='1' AND `country`.`status_id`='1'";
            } else {
                $query .= " `country`.`country_id`='" . $country . "' AND `tv_series`.`status_id`='1' AND `country`.`status_id`='1'";
            }
        }


        $rs = Database::search($query);


        if ($rs->num_rows == 0) {
            // echo ("Couldn't Find Relavant Content");
            ?>
            <div class="no_content">
                <div class="mt-5">
                    <h2 class="text-secondary text-center">
                        Couldn't Find Relavant Content
                    </h2>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="../design_images/no_content_7.png" class="position-absolute" style="width:20%; margin-top: 4%;" />
                </div>
            </div>
            <?php
        } else {

        ?>
            <label class="form-label">Relavant Tv-Series</label>

            <div class="container-fluid pb-3">
                <div class="d-grid gap-3 p-2">

                    <!-- cards -->
                    <div class="row row-cols-1 row-cols-md-5 g-4">
                        <?php

                        for ($x = 0; $x < $rs->num_rows; $x++) {
                            $data = $rs->fetch_assoc();

                            $tv_cover_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_id`='" . $data["id"] . "'");
                            $tv_cover = $tv_cover_rs->fetch_assoc();

                            if ($by == "genre") {

                                $tv_series_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`id`='" . $data["tv_series_id"] . "' AND `tv_series`.`status_id`='1'");
                                $tv_series_data = $tv_series_rs->fetch_assoc();
                        ?>

                                <label data-bs-toggle="tooltip<?php echo $data['tv_series_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $tv_series_data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:100px;" onmouseover="tv_seriesDescription('<?php echo $data['tv_series_code']; ?>');" onclick="singleContentLoad('t','<?php echo $data['tv_series_code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_cover["link"]; ?>')" />
                                        </div>
                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["tv_series_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                            <?php

                            } else {
                            ?>

                                <label data-bs-toggle="tooltip<?php echo $data['code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:100px;" onmouseover="tv_seriesDescription('<?php echo $data['code']; ?>');" onclick="singleContentLoad('t','<?php echo $data['code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_cover["link"]; ?>')" />
                                        </div>
                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["tv_series_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

        <?php
        }
    } else if ($type == "both") {
        $query = "SELECT * FROM `movie` 
        INNER JOIN `quality` ON `quality`.`quality_id`=`movie`.`quality_quality_id`
        INNER JOIN `movie_has_genre` ON `movie_has_genre`.`movie_id`=`movie`.`id`
        INNER JOIN `genre` ON `genre`.`genre_id`=`movie_has_genre`.`genre_genre_id`
        INNER JOIN `year` ON `year`.`year_id`=`movie`.`year_year_id`
        INNER JOIN `language` ON `language`.`language_id`=`movie`.`language_language_id`
        INNER JOIN `country` ON `country`.`country_id`=`movie`.`country_country_id`
        WHERE ";


        if (!empty($_GET["quality"])) {
            $quality = $_GET["quality"];

            $query .= " `quality`.`quality_id`='" . $quality . "' AND `movie`.`status_id`='1' AND `quality`.`status_id`='1'";
        }
        if (!empty($_GET["genre"])) {

            $genre = $_GET["genre"];
            if ($_GET["quality"] != 0) {

                $query .= " AND `genre`.`genre_id`='" . $genre . "' AND `movie`.`status_id`='1' AND `genre`.`status_id`='1'";
            } else {
                $query .= " `genre`.`genre_id`='" . $genre . "' AND `movie`.`status_id`='1' AND `genre`.`status_id`='1'";
            }
        }
        if (!empty($_GET["year"])) {

            $year = $_GET["year"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0) {

                $query .= " AND `year`.`year_id`='" . $year . "' AND `movie`.`status_id`='1' AND `year`.`status_id`='1'";
            } else {
                $query .= " `year`.`year_id`='" . $year . "' AND `movie`.`status_id`='1' AND `year`.`status_id`='1'";
            }
        }
        if (!empty($_GET["language"])) {

            $language = $_GET["language"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0) {

                $query .= " AND `language`.`language_id`='" . $language . "' AND `movie`.`status_id`='1' AND `language`.`status_id`='1'";
            } else {
                $query .= " `language`.`language_id`='" . $language . "' AND `movie`.`status_id`='1' AND `language`.`status_id`='1'";
            }
        }
        if (!empty($_GET["country"])) {

            $country = $_GET["country"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0 || $_GET["language"] != 0) {

                $query .= " AND `country`.`country_id`='" . $country . "' AND `movie`.`status_id`='1' AND `country`.`status_id`='1'";
            } else {
                $query .= " `country`.`country_id`='" . $country . "' AND `movie`.`status_id`='1' AND `country`.`status_id`='1'";
            }
        }

        $rs = Database::search($query);

        if ($rs->num_rows == 0) {
            // echo ("Couldn't Find Relavant Content");
        } else {

        ?>
            <label class="form-label">Relavant Movies</label>

            <div class="container-fluid pb-3">
                <div class="d-grid gap-3 p-2">

                    <!-- cards -->
                    <div class="row row-cols-1 row-cols-md-5 g-4">
                        <?php

                        for ($x = 0; $x < $rs->num_rows; $x++) {
                            $data = $rs->fetch_assoc();

                            $movie_cover_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_id`='" . $data["id"] . "'");
                            $movie_cover = $movie_cover_rs->fetch_assoc();

                            if ($by == "genre") {
                                $movie_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`id`='" . $data["movie_id"] . "' AND `movie`.`status_id`='1'");
                                $movie_data = $movie_rs->fetch_assoc();

                        ?>

                                <label data-bs-toggle="tooltip<?php echo $data['movie_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $movie_data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:150px;" onmouseover="movieDescription('<?php echo $data['movie_code']; ?>');" onclick="singleContentLoad('m','<?php echo $data['movie_code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_cover["link"]; ?>')" />
                                        </div>

                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["movie_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                            <?php
                            } else {
                            ?>

                                <label data-bs-toggle="tooltip<?php echo $data['code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:100px;" onmouseover="movieDescription('<?php echo $data['code']; ?>');" onclick="singleContentLoad('m','<?php echo $data['code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_cover["link"]; ?>')" />
                                        </div>
                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["movie_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['movie_code']; ?>','1');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

        <?php
        }


        $query = "SELECT * FROM `tv_series` 
        INNER JOIN `quality` ON `quality`.`quality_id`=`tv_series`.`quality_quality_id`
        INNER JOIN `tv_series_has_genre` ON `tv_series_has_genre`.`tv_series_id`=`tv_series`.`id`
        INNER JOIN `genre` ON `genre`.`genre_id`=`tv_series_has_genre`.`genre_genre_id`
        INNER JOIN `year` ON `year`.`year_id`=`tv_series`.`year_year_id`
        INNER JOIN `language` ON `language`.`language_id`=`tv_series`.`language_language_id`
        INNER JOIN `country` ON `country`.`country_id`=`tv_series`.`country_country_id`
        WHERE ";


        if (!empty($_GET["quality"])) {
            $quality = $_GET["quality"];

            $query .= " `quality`.`quality_id`='" . $quality . "' AND `tv_series`.`status_id`='1' AND `quality`.`status_id`='1'";
        }
        if (!empty($_GET["genre"])) {

            $genre = $_GET["genre"];
            if ($_GET["quality"] != 0) {

                $query .= " AND `genre`.`genre_id`='" . $genre . "' AND `tv_series`.`status_id`='1' AND `genre`.`status_id`='1'";
            } else {
                $query .= " `genre`.`genre_id`='" . $genre . "' AND `tv_series`.`status_id`='1' AND `genre`.`status_id`='1'";
            }
        }
        if (!empty($_GET["year"])) {

            $year = $_GET["year"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0) {

                $query .= " AND `year`.`year_id`='" . $year . "' AND `tv_series`.`status_id`='1' AND `year`.`status_id`='1'";
            } else {
                $query .= " `year`.`year_id`='" . $year . "' AND `tv_series`.`status_id`='1' AND `year`.`status_id`='1'";
            }
        }
        if (!empty($_GET["language"])) {

            $language = $_GET["language"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0) {

                $query .= " AND `language`.`language_id`='" . $language . "' AND `tv_series`.`status_id`='1' AND `language`.`status_id`='1'";
            } else {
                $query .= " `language`.`language_id`='" . $language . "' AND `tv_series`.`status_id`='1' AND `language`.`status_id`='1'";
            }
        }
        if (!empty($_GET["country"])) {

            $country = $_GET["country"];
            if ($_GET["quality"] != 0 || $_GET["genre"] != 0 || $_GET["year"] != 0 || $_GET["language"] != 0) {

                $query .= " AND `country`.`country_id`='" . $country . "' AND `tv_series`.`status_id`='1' AND `country`.`status_id`='1'";
            } else {
                $query .= " `country`.`country_id`='" . $country . "' AND `tv_series`.`status_id`='1' AND `country`.`status_id`='1'";
            }
        }


        $rs = Database::search($query);


        if ($rs->num_rows == 0) {
            // echo ("Couldn't Find Relavant Content");
        } else {

        ?>
            <label class="form-label " style="margin-top: 150%;">Relavant Tv-Series</label>

            <div class="container-fluid pb-3">
                <div class="d-grid gap-3 p-2">

                    <!-- cards -->
                    <div class="row row-cols-1 row-cols-md-5 g-4">
                        <?php

                        for ($x = 0; $x < $rs->num_rows; $x++) {
                            $data = $rs->fetch_assoc();

                            $tv_cover_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_id`='" . $data["id"] . "'");
                            $tv_cover = $tv_cover_rs->fetch_assoc();

                            if ($by == "genre") {

                                $tv_series_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`id`='" . $data["tv_series_id"] . "' AND `tv_series`.`status_id`='1'");
                                $tv_series_data = $tv_series_rs->fetch_assoc();
                        ?>

                                <label data-bs-toggle="tooltip<?php echo $data['tv_series_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $tv_series_data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:100px;" onmouseover="tv_seriesDescription('<?php echo $data['tv_series_code']; ?>');" onclick="singleContentLoad('t','<?php echo $data['tv_series_code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_cover["link"]; ?>')" />
                                        </div>
                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["tv_series_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                            <?php

                            } else {
                            ?>

                                <label data-bs-toggle="tooltip<?php echo $data['code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $data['name']; ?>">

                                    <div class="col mt-5">
                                        <div style="width: 150px; height:100px;" onmouseover="tv_seriesDescription('<?php echo $data['code']; ?>');" onclick="singleContentLoad('t','<?php echo $data['code']; ?>');">
                                            <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_cover["link"]; ?>')" />
                                        </div>
                                        <?php

                                        if (!empty($_SESSION["user"])) {

                                            $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                            AND `favourite`.`code`='" . $data["tv_series_code"] . "'");

                                            if ($favourite_rs->num_rows == 1) {
                                        ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $data['tv_series_code']; ?>','2');"></i>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                                <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </label>

                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

<?php
        }

        if($rs->num_rows == 0){
            ?>
            <div class="no_content">
                <div class="mt-5">
                    <h2 class="text-secondary text-center">
                        Couldn't Find Relavant Content
                    </h2>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="../design_images/no_content_7.png" class="position-absolute" style="width:20%; margin-top: 4%;" />
                </div>
            </div>
            <?php
        }
    }
} else {
    echo ("Something Went Wrong");
}


?>