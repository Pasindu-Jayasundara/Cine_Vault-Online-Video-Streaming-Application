<?php

require "../connection/connection.php";
session_start();

$query = "SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' ORDER BY `favourite`.`date_time` DESC";
$rs = Database::search($query);

$num = $rs->num_rows;
if ($num > 0) {

    for ($x = 0; $x < $num; $x++) {
        $data = $rs->fetch_assoc();

        $table_find_query = "SELECT * FROM `movie` WHERE `movie`.`code`='" . $data["code"] . "'";
        $table_find_rs = Database::search($table_find_query);
        $table_find_num = $table_find_rs->num_rows;

        if ($table_find_num > 0) { //then it is a movie
            $movie_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_code`='" . $data["code"] . "'");
            $movie_data = $movie_rs->fetch_assoc();

            $desciption_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`code`='" . $data["code"] . "'");
            $desciption_data = $desciption_rs->fetch_assoc();

?>
            <label data-bs-toggle="tooltip<?php echo $movie_data['movie_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $desciption_data['name']; ?>">

                <div class="col mt-5">
                    <div style="width: 150px; height:100px; z-index: 1;" onmouseover="movieDescription('<?php echo $movie_data['movie_code']; ?>');" onclick="singleContentLoad('m','<?php echo $movie_data['movie_code']; ?>');">
                        <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_data["link"]; ?>')" />
                    </div>
                    <?php

                    if (!empty($_SESSION["user"])) {

                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `cart`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `cart`.`status_id`='1' 
                        AND `cart`.`code`='" . $movie_data["movie_code"] . "' AND `cart`.`type_id`='1'");

                        if ($cart_rs->num_rows == 1) {
                    ?>
                            <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -6.6%;">
                                <i class="bi bi-cart-check-fill fs-4 greencolor" id="favouriteplusicon<?php echo $movie_data['movie_code']; ?>" onclick="bookmarkAddToCart('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                                <i class="bi bi-heart-fill fs-5 text-danger" onclick="removeFromFavourite('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -6.6%;">
                                <i class="bi bi-cart-plus-fill fs-4 text-warning" id="favouriteplusicon<?php echo $movie_data['movie_code']; ?>" onclick="bookmarkAddToCart('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                                <i class="bi bi-heart-fill fs-5 text-danger" onclick="removeFromFavourite('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -6.6%;">
                            <i class="bi bi-cart-plus-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                            <i class="bi bi-heart-fill fs-5 text-danger" onclick="alert('Please LogIn First');"></i>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </label>

        <?php

        } else { //check tv_series

            $tv_series_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_code`='" . $data["code"] . "'");
            $tv_series_data = $tv_series_rs->fetch_assoc();

            $desciption_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $data["code"] . "'");
            $desciption_data = $desciption_rs->fetch_assoc();

        ?>
            <label data-bs-toggle="tooltip<?php echo $tv_series_data['tv_series_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $desciption_data['name']; ?>">

                <div class="col mt-5">
                    <div style="width: 150px; height:100px; z-index: 1;" onmouseover="tv_seriesDescription('<?php echo $tv_series_data['tv_series_code']; ?>');" onclick="singleContentLoad('t','<?php echo $tv_series_data['tv_series_code']; ?>');">
                        <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_series_data["link"]; ?>')" />
                    </div>
                    <?php

                    if (!empty($_SESSION["user"])) {

                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `cart`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `cart`.`status_id`='1' 
                        AND `cart`.`code`='" . $data["code"] . "' AND `cart`.`type_id`='2'");

                        if ($cart_rs->num_rows == 1) {
                    ?>
                            <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -6.6%;">
                                <i class="bi bi-cart-check-fill fs-4 greencolor" id="favouriteplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToCart('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                                <i class="bi bi-heart-fill fs-5 text-danger" onclick="removeFromFavourite('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -6.6%;">
                                <i class="bi bi-cart-plus-fill fs-4 text-warning" id="favouriteplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToCart('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                                <i class="bi bi-heart-fill fs-5 text-danger" onclick="removeFromFavourite('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -6.6%;">
                            <i class="bi bi-cart-plus-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                            <i class="bi bi-heart-fill fs-5 text-danger" onclick="alert('Please LogIn First');"></i>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </label>

<?php

        }
    }
} else {
    ?>
    <div class="mt-5" style="width: 100vw;">
        <h2 class="text-warning text-center fw-normal">
            You Don't Have Any Favourite Content
        </h2>
    </div>
    <div class="d-flex justify-content-center" style="width: 100vw;">
        <img src="../design_images/favourite.png" class="position-absolute" style="width:32%; margin-top: 2%;" />
    </div>
    <?php
}
?>