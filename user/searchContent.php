<?php
require "../connection/connection.php";
session_start();

if (!empty($_GET["txt"])) {

    $txt = $_GET["txt"];

    $movie_search_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`name` LIKE '%" . $txt . "%' AND `movie`.`status_id`='1'");
    $movie_search_num = $movie_search_rs->num_rows;

    if ($movie_search_num > 0) {

?>

        <label class="form-label">Relavant Movies</label>

        <div class="container-fluid pb-3" >
            <div class="d-grid gap-3 p-2">

                <!-- cards -->
                <div class="row row-cols-1 row-cols-md-5 g-4">

                    <?php

                    for ($x = 0; $x < $movie_search_num; $x++) {
                        $movie_search_data = $movie_search_rs->fetch_assoc();

                        $movie_cover_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_id`='" . $movie_search_data["id"] . "' AND `movie_cover`.`status_id`='1'");
                        $movie_cover = $movie_cover_rs->fetch_assoc();
                    ?>

                        <label data-bs-toggle="tooltip<?php echo $movie_search_data['code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $movie_search_data['name']; ?>">

                            <div class="col mb-5">
                                <div style="width: 150px; height:100px; z-index: 1;" onmouseover="movieDescription('<?php echo $movie_search_data['code']; ?>');" onclick="singleContentLoad('m','<?php echo $movie_search_data['code']; ?>');">
                                    <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_cover["link"]; ?>')" />
                                </div>
                                <?php

                                if (!empty($_SESSION["user"])) {

                                    $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                    AND `favourite`.`code`='" . $movie_search_data["code"] . "'");

                                    if ($favourite_rs->num_rows == 1) {
                                ?>
                                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                            <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $movie_search_data['code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $movie_search_data['code']; ?>','1');"></i>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                            <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $movie_search_data['code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $movie_search_data['code']; ?>','1');"></i>
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
                    ?>

                </div>

            </div>
        </div>

    <?php
    }

    $tv_search_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`name` LIKE '%" . $txt . "%' AND `tv_series`.`status_id`='1'");
    $tv_search_num = $tv_search_rs->num_rows;

    if ($tv_search_num > 0) {

    ?>

        <label class="form-label mt-5">Relavant Tv-Series</label>

        <div class="container-fluid pb-3 mb-5">
            <div class="d-grid gap-3 p-2">

                <!-- cards -->
                <div class="row row-cols-1 row-cols-md-5 g-4">

                    <?php

                    for ($y = 0; $y < $tv_search_num; $y++) {
                        $tv_search_data = $tv_search_rs->fetch_assoc();

                        $tv_cover_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_id`='" . $tv_search_data["id"] . "' AND `tv_series_cover`.`status_id`='1'");
                        $tv_cover = $tv_cover_rs->fetch_assoc();
                    ?>

                        <label data-bs-toggle="tooltip<?php echo $tv_search_data['code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $tv_search_data['name']; ?>">

                            <div class="col mb-5">
                                <div style="width: 150px; height:100px; z-index: 1;" onmouseover="tv_seriesDescription('<?php echo $tv_search_data['code']; ?>');" onclick="singleContentLoad('t','<?php echo $tv_search_data['code']; ?>');">
                                    <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_cover["link"]; ?>')" />
                                </div>
                                <?php

                                if (!empty($_SESSION["user"])) {

                                    $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                                    AND `favourite`.`code`='" . $tv_search_data["code"] . "'");

                                    if ($favourite_rs->num_rows == 1) {
                                ?>
                                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                            <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $tv_search_data['code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $tv_search_data['code']; ?>','2');"></i>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.6%;">
                                            <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $tv_search_data['code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $tv_search_data['code']; ?>','2');"></i>
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

                    ?>

                </div>

            </div>
        </div>

    <?php
    }

    if ($movie_search_num == 0 && $tv_search_num == 0) {
        // echo ("Sorry We Couldn't Find Your Search");
    ?>
    <div class="no_content">
        <div class="mt-5">
            <h2 class="text-secondary text-center">
            Sorry We Couldn't Find Your Search
            </h2>
        </div>
        <div class="d-flex justify-content-center">
            <img src="../design_images/no_content_7.png" class="position-absolute" style="width:20%; margin-top: 4%;" />
        </div>
    </div>
<?php
    }
} else {
    echo ("1");
}

?>