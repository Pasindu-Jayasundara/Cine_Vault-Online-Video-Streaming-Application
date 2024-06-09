<?php

require "../connection/connection.php";
session_start();

$query = "SELECT * FROM `cart` WHERE `cart`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `cart`.`status_id`='1' ORDER BY `cart`.`date_time` DESC";
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

            <div class="col mx-4 mt-5">
                <div style="width: 250px; height:140px; z-index: 1;" onclick="singleContentLoad('m','<?php echo $movie_data['movie_code']; ?>');">
                    <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $movie_data["link"]; ?>')" />
                </div>
                <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -9.3%;">
                    <i class="bi bi-bookmark-plus-fill fs-4 text-warning" id="cartplusicon<?php echo $movie_data['movie_code']; ?>" onclick="bookmarkAddToCheckList('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                    <i class="bi bi-cart-check-fill fs-4 greencolor" onclick="removeFromCart('<?php echo $movie_data['movie_code']; ?>','1');"></i>
                </div>
            </div>


        <?php

        } else { //check tv_series

            $tv_series_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_code`='" . $data["code"] . "'");
            $tv_series_data = $tv_series_rs->fetch_assoc();

            $desciption_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $data["code"] . "'");
            $desciption_data = $desciption_rs->fetch_assoc();

        ?>

            <div class="col mx-4 mt-5">
                <div style="width: 250px; height:140px; z-index: 1;" onclick="singleContentLoad('t','<?php echo $tv_series_data['tv_series_code']; ?>');">
                    <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_series_data["link"]; ?>')" />
                </div>
                <div class="position-absolute bg-black d-flex flex-column" style="z-index: 5; margin-top: -9.3%;">
                    <i class="bi bi-bookmark-plus-fill fs-4 text-warning" id="cartplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToCheckList('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                    <i class="bi bi-cart-check-fill fs-4 greencolor" onclick="removeFromCart('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                </div>
            </div>


    <?php

        }
    }
} else {
    ?>
    <div class="mt-5 d-flex justify-content-center " style="width: 100vw;">
        <h2 class="text-warning text-center fw-normal" style="margin-left: 11%;">
            You Don't Have Any Cart Content
        </h2>
    </div>
    <div class="d-flex justify-content-center" style="width: 100vw;">
        <img src="../design_images/pngwing.com.png" class="position-absolute" style="width:32%; margin-top: 2%;" />
    </div>
<?php
}
?>