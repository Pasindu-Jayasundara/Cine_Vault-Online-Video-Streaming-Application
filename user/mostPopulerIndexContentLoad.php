<?php
session_start();
require "../connection/connection.php";

$query = "SELECT COUNT(`like`) AS `like`,`code`
FROM `reaction` 
WHERE `reaction`.`like`='1' 
AND `reaction`.`status_id`='1' 
GROUP BY `code` 
ORDER BY `like` DESC ";
$rs = Database::search($query);

$num = $rs->num_rows;

for ($x = 0; $x < $num; $x++) {
    $data = $rs->fetch_assoc();

    $table_find_query = "SELECT * FROM `movie` WHERE `movie`.`code`='" . $data["code"] . "'";
    $table_find_rs = Database::search($table_find_query);
    $table_find_num = $table_find_rs->num_rows;

    if ($table_find_num > 0) { //then it is a movie
        $movie_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_code`='" . $data["code"] . "'");
        $movie_data = $movie_rs->fetch_assoc();
        $table_find_data = $table_find_rs->fetch_assoc();

?>
        <label data-bs-toggle="tooltip<?php echo $movie_data['movie_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $table_find_data['name']; ?>">

            <div class="col" style="margin-right: 140px; margin-bottom: 50px;">
                <div style="width: 150px; height:100px; z-index: 1;" onmouseover="movieDescription('<?php echo $movie_data['movie_code']; ?>');" onclick="singleContentLoad('m','<?php echo $movie_data['movie_code']; ?>');">
                    <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-position: center; background-image:url('<?php echo $movie_data["link"]; ?>')" />
                </div>
                <?php

                if (!empty($_SESSION["user"])) {

                    $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                    AND `favourite`.`code`='" . $data["code"] . "'");

                    if ($favourite_rs->num_rows == 1) {
                ?>
                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -7%;">
                            <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $movie_data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -7%;">
                            <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $movie_data['movie_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="position-absolute bg-black" style="z-index: 5; margin-top: -7%;">
                        <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                    </div>
                <?php
                }
                ?>
            </div>

        </label>

    <?php

    } else { //check tv_series
        $table_find_data = $table_find_rs->fetch_assoc();

        $tv_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $data["code"] . "'");
        $tv_data = $tv_rs->fetch_assoc();

        $tv_series_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_code`='" . $data["code"] . "'");
        $tv_series_data = $tv_series_rs->fetch_assoc();


    ?>
        <label data-bs-toggle="tooltip<?php echo $tv_series_data['tv_series_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $tv_data['name']; ?>">

            <div class="col" style="margin-right: 140px; margin-bottom: 50px;">
                <div style="width: 150px; height:100px; z-index: 1;" onmouseover="tv_seriesDescription('<?php echo $tv_series_data['tv_series_code']; ?>');" onclick="singleContentLoad('t','<?php echo $tv_series_data['tv_series_code']; ?>');">
                    <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-position: center; background-image:url('<?php echo $tv_series_data["link"]; ?>')" />
                </div>
                <?php

                if (!empty($_SESSION["user"])) {

                    $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                    AND `favourite`.`code`='" . $data["code"] . "'");

                    if ($favourite_rs->num_rows == 1) {
                ?>
                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -7%;">
                            <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="position-absolute bg-black" style="z-index: 5; margin-top: -7%;">
                            <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="position-absolute bg-black" style="z-index: 5; margin-top: -7%;">
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